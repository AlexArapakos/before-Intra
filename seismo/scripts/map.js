var distanceCounter = 0.0;
var lastLegDistance = 0.0;
var measureUnit = "K";
var measurePolyline;
var startMeasureMarker;
var currentMeasureMarker;
var measurePoints = new Array();
var polylines = new Array();
var map;
var bounds = 0;
var size;
var rightContentForm;
var rightContentFormWidth = 0;
var rightContentFormHeight = 0;
var restor_maximize = 0;
var zoom = 0;
var lat = 0;
var lng = 0;
var doc;
var copy = new Array();
var redraw = 0;
var removedOverlays = new Array();
var e = 0;
var tabPointLat = new Array();
var tabPointLon = new Array();
var tabPoint = new Array();
var tabInfo = new Array();
var savedTabs = new Array();
var redrawTab = 0;
var removedMarkers = new Array();
var removedMarkersLength = 0;
var markerNum = new Array();
var tabstring = new Array();
var removeTabMarker = new Array();
var addSimpleMarkers = new Array();
var removeTabMarkerLength = 0;
var addSimpleMarkersLength = 0;
var a = 0;
var macroDataResult=0;


function loadMap() 
{
	if (GBrowserIsCompatible()) 
	{	
	    map = new GMap2(document.getElementById("map"));
		centerOfTheMap();
		map.addControl(new GLargeMapControl3D());
		map.addControl(new GScaleControl());
		//map.addControl(new GOverviewMapControl());
		//map.enableScrollWheelZoom();
		map.enableDoubleClickZoom();
		map.enableContinuousZoom();
		var boxStyleOpts = 	{	opacity: .2, 
								border: "2px solid #356AA0" 
							};
		var otherOpts = { 	buttonHTML: "<img src='img/zoomInactive.png' />",
							buttonZoomingHTML: "<img src='img/zoomActive.png' />",
							buttonStartingStyle: {width: '17px', height: '17px'},
							overlayRemoveTime: 0
						};
		map.addControl( new DragZoomControl(boxStyleOpts, otherOpts, {}),
						new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(28,283))
					  );
		map.addMapType(G_PHYSICAL_MAP); 
		var mapControl = new GHierarchicalMapTypeControl();
		mapControl.clearRelationships();
        mapControl.addRelationship(G_SATELLITE_MAP, G_HYBRID_MAP, "Show labels", false);		
        map.addControl(mapControl);		
		GEvent.addListener(map, 'click', function(overlay, point) {
      	onClick(point);
    	});
		GEvent.addListener(map, 'move', function() {      	
      	var latLngStr = '(' + parseFloat(map.getCenter().lat()).toFixed(5) + ', ' + parseFloat(map.getCenter().lng()).toFixed(5) + ')';
      	document.getElementById("center").innerHTML = "Center: "+latLngStr;
    	});
		GEvent.addListener(map, 'zoomend', function(oldLevel, newLevel) {
      	document.getElementById("zoom").innerHTML = "Zoom: "+newLevel;
    	});
	}
	else 
	{
		alert("Your browser does not support Google Maps.");
	}
}

function onClick(point) 
{
	if(document.getElementById('measureDistance').checked==false)
		return;
  	
	if (point ==null)
		return;
	
	measurePoints.push(point);

	var measureIcon = G_DEFAULT_ICON;	
	measureIcon.image = "img/ruler.png";

  	if (startMeasureMarker == null) 
  	{
   		startMeasureMarker = new GMarker(point,measureIcon);
    	map.addOverlay(startMeasureMarker);
  	} 
  	else 
  	{    
    	if (currentMeasureMarker != null)
		{
      		map.removeOverlay(currentMeasureMarker);
    	}
		if (currentMeasureMarker == null)
		{
      		currentMeasureMarker = startMeasureMarker;
    	}
		lastLegDistance = point.distanceFrom(currentMeasureMarker.getPoint()) / 1000;
    	if (measureUnit=="M")
		{
			lastLegDistance/= 1.609344;
    	}
		distanceCounter += lastLegDistance;
		document.getElementById("path").innerHTML = "Length of path: "+distanceCounter.toFixed(3)+", Length of last leg: "+lastLegDistance.toFixed(3); 

    	measurePolyline = new GPolyline([currentMeasureMarker.getPoint(), point], "#356AA0", 3, 1);
		polylines.push(measurePolyline);
		currentMeasureMarker = new GMarker(point,measureIcon);
    	currentMeasureMarker.point = point;
   		map.addOverlay(measurePolyline);
    	map.addOverlay(currentMeasureMarker);
  	}
}

function centerOfTheMap()
{
	//default
	if (bounds==0 && lat==0 && lng==0 && zoom==0)
		map.setCenter(new GLatLng(38, 25), 6);
	//maximize, restore
	else if (bounds==0)
	{
		map.setCenter(new GLatLng(lat, lng), zoom);
		//if no mistake has occured or no clear results triggered
		if (e==0)
		{
			if (redraw!=0)
			{
				//no simple marker is removed
				if (removedOverlays.length == 0)
				{
					for (var j = 0; j < redraw; j++)
						map.addOverlay(copy[j]);
				}
				//1 simple marker is removed
				else if(removedOverlays.length == 1)
				{
					for (var j = 0; j < redraw; j++)
					{
						if (j != removedOverlays[0])
							map.addOverlay(copy[j]);
					}
				}
				//more simple markers are removed
				else
				{
					for (var j = 0; j < redraw; j++)
					{
						var z = 0;
						var r = removedOverlays.length;
						for (var i = 0; i < r; i++)
						{
							if(j==removedOverlays[i])
								z = 1;
						}
						if (z==0)
							map.addOverlay(copy[j]);
					}
				}
				//tab markers
				for (var i = 0; i < redrawTab; i++)
					map.addOverlay(savedTabs[i]);
				if (removeTabMarker.length!=0)
				{
					for (var i = 0; i < redrawTab; i++)
					{
						for (var j=0; j<removeTabMarkerLength; j++)
						{
							if (removeTabMarker[j]==savedTabs[i])
								map.removeOverlay(savedTabs[i]);
						}
					}
					//alert("redrawtab="+redrawTab);
					//alert("removeTabMarkerLength="+removeTabMarkerLength);
				}
				//hide simple markers that have become tab markers
				for (var i = 0; i < removedMarkersLength; i++)
					copy[removedMarkers[i]].hide();
				if (addSimpleMarkers.length!=0)
				{
					for (var i = 0; i < removedMarkersLength; i++)
					{
						for (var j=0; j<addSimpleMarkersLength; j++)
						{
							if (addSimpleMarkers[j]==removedMarkers[i])
								copy[removedMarkers[i]].show();
						}
					}
					//alert("removedMarkersLength="+removedMarkersLength);
					//alert("addSimpleMarkersLength="+addSimpleMarkersLength);
				}
			}
		}
	}
	//query
	else
	{
		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
		e = 0;
		a = 0;
		removedOverlays = new Array();
		removeTabMarker = new Array();
		addSimpleMarkers = new Array();
		removeTabMarkerLength = 0;
		addSimpleMarkersLength = 0;
		savedTabs = new Array();
		markerNum = new Array();
		tabstring = new Array();
		removedMarkers = new Array();
		redrawTab = 0;
		removedMarkersLength = 0;
		macroDataResult=0;
	}

	//measure distance
	if ((document.getElementById('measureDistance').checked==true) && (measurePoints.length>0))
	{
		var newPoints = measurePoints.slice();
		resetCounter();
		for (i in newPoints)
		{
			var p = newPoints[i];
			onClick(p);
		}
	}
}

function resetCounter() 
{
	if ((startMeasureMarker != null) && (currentMeasureMarker != null))
	{
	   	startMeasureMarker.remove();
	    currentMeasureMarker.remove();
		for (i in polylines)
		{
			var p = polylines[i];
			p.remove();
		}
	}
	else if ((startMeasureMarker != null) && (currentMeasureMarker == null))
		startMeasureMarker.remove();
	distanceCounter = 0.0;
	lastLegDistance = 0.0;
  	measurePolyline = null;
  	startMeasureMarker = null;
  	currentMeasureMarker = null;
  	measurePoints = new Array();
	polylines = new Array();
  	document.getElementById("path").innerHTML = "Length of path:-, Length of last leg:-";  	
}

function removeLastLeg() 
{
  	measurePoints.pop();
  	var newPoints = measurePoints.slice();
  	resetCounter();

  	for (i in newPoints)
  	{
    	var p = newPoints[i];
    	onClick(p);
  	}
}

function clearResults()
{
	map.clearOverlays();
	e = 1;
	document.getElementById("status").innerHTML = '';
	
	if ((document.getElementById('measureDistance').checked==true) && (measurePoints.length>0))
	{
		var newPoints = measurePoints.slice();
		resetCounter();
		for (i in newPoints)
		{
			var p = newPoints[i];
			onClick(p);
		}
	}
}

function clearCurrentResult(i)
{
	//normal markers
	if (copy[i].isHidden()==false)
	{
		copy[i].closeInfoWindow();
		map.removeOverlay(copy[i]);
		removedOverlays.push(i);
	}
	//tab markers
	else
	{
		var temp = new Array();
		for (var j=0; j<redrawTab; j++)
		{
			temp = tabstring[j].split(",");
			for (var z=0; z<markerNum[j]; z++)
			{
				//marker with 2 tabs
				if ((temp[z]==i) && (markerNum[j]==2))
				{
					map.closeInfoWindow();
					map.removeOverlay(savedTabs[j]);
					removeTabMarker.push(savedTabs[j]);
					if (temp[0]==i)
					{
						copy[temp[1]].show();
						addSimpleMarkers.push(temp[1]);
					}
					else
					{
						copy[temp[0]].show();
						addSimpleMarkers.push(temp[0]);
					}
					removeTabMarkerLength++;
					addSimpleMarkersLength++;
				}
				//marker with more than 2 tabs
				else if ((temp[z]==i) && (markerNum[j]!=2))
				{
					map.closeInfoWindow();
					map.removeOverlay(savedTabs[j]);
					var arr = new Array();
					var b = 0;
					var str;
					for (var k=0; k<markerNum[j]; k++)
					{
						if (k==z)
							b=1;
						else
							arr[k-b] = temp[k];
					}
					str=arr[0];
					for (var k=1; k<markerNum[j]-1; k++)
						str+=","+arr[k];
					var marker2 = createTabMarker(str);
					map.addOverlay(marker2);
					//alert("markerNum[j](defore)="+markerNum[j]);
					savedTabs[j] = marker2;
					markerNum[j] += -1;
					tabstring[j] = str;
					//alert("markerNum[j](after)="+markerNum[j]);
				}
			}
		}
	}
	a++;
	var res = redraw - a;
	document.getElementById("status").innerHTML = res + ' results displayed.';
}

/* Set the unit of distance */
function setUnit() 
{
  select = document.getElementById("unit");
  measureUnit = select.options[select.selectedIndex].value;
  
  if (measureUnit=="K") 
  { 
    distanceCounter *= 1.609344; 
    lastLegDistance  *= 1.609344;
  }
  if (measureUnit=="M") 
  { 
    distanceCounter /= 1.609344;
    lastLegDistance /= 1.609344;
  }
  document.getElementById("path").innerHTML = "Length of path: "+distanceCounter.toFixed(3)+", Length of last leg: "+lastLegDistance.toFixed(3); 
}

/* Get client window size */
function getSize() 
{
  var winWidth = 0, winHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) 
  {
    winWidth = window.innerWidth;
    winHeight = window.innerHeight;
  } 
  else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
  {
    winWidth = document.documentElement.clientWidth;
    winHeight = document.documentElement.clientHeight;
  } 
  else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
  {
   	winWidth = document.body.clientWidth;
    winHeight = document.body.clientHeight;
  } 
  return [winWidth, winHeight];
}

function maximizeForm()
{	
	size = getSize();
	rightContentForm=document.getElementById("rightContent");
	zoom = map.getZoom();
	lat = parseFloat(map.getCenter().lat()).toFixed(5);
	lng = parseFloat(map.getCenter().lng()).toFixed(5);
	rightContentForm.style.position='absolute';
	rightContentForm.style.top=0;
	rightContentForm.style.left=0;
	rightContentFormWidth=rightContentForm.style.width;
	rightContentForm.style.width=size[0]+"px";
	rightContentFormHeight=rightContentForm.style.height;
	rightContentForm.style.height=size[1]+"px";
	document.getElementById("map").style.width=size[0]-20+"px";
	document.getElementById("map").style.height=size[1]*0.73+"px";
	loadMap();
	document.getElementById("maxRestore").innerHTML='[<a href="#" onclick="restoreForm()">Restore</a>]&nbsp;';
	document.getElementById("horizontalMenu").style.display='block';
	zoom = 0;
	lat = 0;
	lng = 0;
	restor_maximize = 1;
}

function restoreForm()
{
	rightContentForm=document.getElementById("rightContent");
	zoom = map.getZoom();
	lat = parseFloat(map.getCenter().lat()).toFixed(5);
	lng = parseFloat(map.getCenter().lng()).toFixed(5);
	rightContentForm.style.position='static';	
	rightContentForm.style.width=rightContentFormWidth;	
	rightContentForm.style.height=rightContentFormHeight;
	document.getElementById("map").style.width="718px";
	document.getElementById("map").style.height="450px";
	loadMap();
	document.getElementById("maxRestore").innerHTML="[<a href=\"#\" onclick=\"maximizeForm()\">Maximize</a>]&nbsp;";
	document.getElementById("horizontalMenu").style.display='none';
	zoom = 0;
	lat = 0;
	lng = 0;
	restor_maximize = 0;
}

function createMarker(point, descr, icon) 
{
	var marker = new GMarker(point,icon);
    GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(descr);
      });
	return marker;
}

/* Check if there are more than 1 results in 1 position */
function checkTabMarker()
{
	var counter = 0;
	var n;
	var t;
	
	for (var i=0; i<redraw-1; i++)
	{
		for (var j=i+1; j<redraw; j++)
		{
			if ((tabPointLat[i]==tabPointLat[j]) && (tabPointLon[i]==tabPointLon[j]))
			{
				if ((counter==0) || ((copy[i].isHidden()==false) && (copy[j].isHidden()==false)))
				{
					counter++;
					copy[i].hide();
					copy[j].hide();
					removedMarkers.push(i);
					removedMarkers.push(j);
					markerNum.push(2);
					tabstring.push(i+","+j);
					var marker2 = createTabMarker(tabstring[counter-1]);
					map.addOverlay(marker2);
					savedTabs.push(marker2);
				}
				else if ((copy[i].isHidden()==true) && (copy[j].isHidden()==false))
				{
					copy[j].hide();
					removedMarkers.push(j);
					map.removeOverlay(savedTabs[counter-1]);
					savedTabs.pop();
					n = markerNum.pop();
					markerNum.push(n+1);
					t = tabstring.pop();
					tabstring.push(t+","+j);
					var marker2 = createTabMarker(tabstring[counter-1]);
					map.addOverlay(marker2);
					savedTabs.push(marker2);
				}
				removedMarkersLength = removedMarkers.length;
				redrawTab = savedTabs.length;
			}
		}
	}
}

function createTabMarker(str)
{
	var tabs = new Array();
	var labels = new Array();
	var htmls = new Array();
	var temp = str.split(",");
	
	for (var z=0; z<temp.length; z++)
	{
		labels[z] = z+1;
		htmls[z] = tabInfo[temp[z]];
		if (temp.length > 2)
			htmls[z] ='<div style="width:'+temp.length*88+'px">'+htmls[z]+'</div>';
		tabs.push(new GInfoWindowTab(labels[z],htmls[z]));
	}
	
	var newIcon = new GIcon();
	newIcon.iconAnchor = new GPoint(16, 16);
	newIcon.infoWindowAnchor = new GPoint(16, 0);
	
	if (macroDataResult == 0 )
	{
		newIcon.image = "img/multiMarker.png";
		newIcon.shadow = "img/markerShadow.png";
		newIcon.iconSize = new GSize(24, 38);
		newIcon.shadowSize = new GSize(59, 32);
	}
	else
	{
		newIcon.image = "img/macroPink.png";
		newIcon.shadow = "img/macroShadow.png";
		newIcon.iconSize = new GSize(12, 20);
		newIcon.shadowSize = new GSize(22, 20);
	}
	
	var marker2 = new GMarker(tabPoint[temp[0]], newIcon);
	
	GEvent.addListener(marker2, "click", function() {
		marker2.openInfoWindowTabsHtml(tabs);
	});
		
	return marker2;
}

function findSites(minPopulation, maxPopulation)
{	
	var dStart = new Date();
    var searchUrl = 'contents/dbQueries/getSites.php?minPop='+minPopulation+'&maxPop='+maxPopulation;
     
	GDownloadUrl(searchUrl, function(data, responseCode) 
	{
	if(responseCode == 200)
	{
		//data=data.replace(/^\s+/g, '') ;
		var xml = parseXML(data);
		var sites = xml.getElementsByTagName("site");
		//alert("data="+data);
		//alert("data length="+data.length);
		//alert("Query's results = "+sites.length);
		//alert(xml.getElementsByTagName("parsererror").length ?"xml error" : "ok!");
		map.clearOverlays();
       
       	if ((sites.length == 0) && (data.length<60))
		{
			centerOfTheMap();
         	document.getElementById('status').innerHTML = 'No results found.';
			e = 1;
       	}
		else if(sites.length == 1 && sites[0].getAttribute('code')=="error")
		{
			centerOfTheMap();
			document.getElementById('status').innerHTML = "<div class='err'>Error during query execution.</div>";
			e = 2;
		}
		else if ((data.length>60) && (sites.length == 0))
		{
			centerOfTheMap();
			document.getElementById('status').innerHTML = 'Too many resalts. Can not display on screen.';
			alert("Too many resalts that can't be display on screen!\nPlease make your search for smaller dataset!");
			e = 3;
		}
		else
		{
			bounds = new GLatLngBounds();
		
			for (var i = 0; i < sites.length; i++) 
			{
				var siteInfo='<table align="center" border="0" cellpadding="0" cellspacing="5">'+
						  '<tr><td align="right"><b>Site Code:</b></td><td align="left">'+sites[i].getAttribute('code')+'</td></tr>'+		
      			          '<tr><td align="right"><b>Site Name (EN):</b></td><td align="left">'+sites[i].getAttribute('nameEn')+'</td></tr>'+		
      				      '<tr><td align="right"><b>Population:</b></td><td align="left">'+sites[i].getAttribute('population')+'</td></tr>'+		
      					  '<tr><td align="right"><b>Latitude:</b></td><td align="left">'+sites[i].getAttribute('lat')+'</td></tr>'+		
      					  '<tr><td align="right"><b>Longitude:</b></td><td align="left">'+sites[i].getAttribute('lon')+'</td></tr>'+		
      					  '<tr><td align="right"><b>Prefecture (EN):</b></td><td align="left">'+sites[i].getAttribute('prefectureEn')+'</td></tr>'+		
                 		  '<tr><td align="right"><b>Country Name:</b></td><td align="left">'+sites[i].getAttribute('country')+'</td></tr>'+		
						  '</table>'+
						  '<a href="#" onClick="loadBoxContent(\'contents/maps/NN.php\',550,230,\'lat='+sites[i].getAttribute('lat')+'&lon='+sites[i].getAttribute('lon')+'\')">Nearest Neighbour Query</a>'+ 
						  '<br/><a href="#" onClick="loadBoxContent(\'contents/maps/distance.php\',550,230,\'lat='+sites[i].getAttribute('lat')+'&lon='+sites[i].getAttribute('lon')+'\')">Distance Based Query</a>'+
						  '<br/><a href="#" onClick="clearCurrentResult(\''+i+'\')">Remove this Overlay</a>'; 
						  
				var pointLat = parseFloat(sites[i].getAttribute('lat'));
				var pointLon = parseFloat(sites[i].getAttribute('lon'));
				var point = new GLatLng(pointLat, pointLon);	  
				
				var siteIcon = new GIcon();
				siteIcon.image = "img/house.png";
				siteIcon.iconAnchor = new GPoint(16, 16);
				siteIcon.infoWindowAnchor = new GPoint(16, 0);
				siteIcon.iconSize = new GSize(32, 32);
				siteIcon.shadow = "img/houseShadow.png";
				siteIcon.shadowSize = new GSize(59, 32);
				
				tabPointLat[i] = pointLat;
				tabPointLon[i] = pointLon;
				tabPoint[i] = point;
				tabInfo[i] = siteInfo;
				
				var marker = createMarker(point, siteInfo, siteIcon);
				
				map.addOverlay(marker); 				 
				bounds.extend(point);
				copy[i]=marker;
			}
			redraw = sites.length;
			centerOfTheMap();
			bounds = 0;
			checkTabMarker();
			var dEnd=new Date();
			var executionTime=dEnd.getTime()-dStart.getTime();		
			document.getElementById('status').innerHTML ="Query executed in "+executionTime+ " msec and returned "+sites.length+ " results.";
    	}
		hideForm();
	}
	else if(responseCode == -1) 
	{
		alert("Data request timed out. Please try later.");
    }
	else
	{ 
		alert("Request resulted in error. Check XML file is retrievable.");
	}

	});	
}

function findMacroData(quake, minIntensity, maxIntensity)
{	
	var dStart = new Date();
	var searchUrl = 'contents/dbQueries/getMacroData.php?quake=' + quake
						+ '&minIntensity=' + minIntensity
						+ '&maxIntensity=' + maxIntensity;
	
	GDownloadUrl(searchUrl, function(data, responseCode)
	{
	if(responseCode == 200)
	{
		//alert("data="+data);
		//alert("data length="+data.length);
		//alert(responseCode);
	 	//data=data.replace(/^\s+/g, '');
		var xml = parseXML(data);
    	var macros = xml.getElementsByTagName('macro');
		//alert("macros.length="+macros.length);
		
		if ((macros.length == 0) && (data.length<60))
	   	{
			map.clearOverlays();
			centerOfTheMap();
			document.getElementById('status').innerHTML = 'No results found.';
			e = 1;
			hideForm();
       	}
		else if(macros.length == 1 && macros[0].getAttribute('macroId')=="error")
		{
			map.clearOverlays();
			centerOfTheMap();
			document.getElementById('status').innerHTML = "<div class='err'>Error during query execution.</div>";
			e = 2;
			hideForm();
		}
		else if ((data.length>60) && (macros.length == 0))
		{
			document.getElementById('status').innerHTML = 'Too many results. Can not display on screen.';
			hideForm();
			loadBoxContent("contents/maps/macroData.php?quake="+quake,550,150,'');
		}
		else
		{
			map.clearOverlays();
			bounds = new GLatLngBounds();	
		
			for (var i = 0; i < macros.length; i++) 
			{
				var macroInfo='<table align="center" border="0" cellpadding="0" cellspacing="5">'+
						  '<tr><td align="right"><b>Macro ID:</b></td><td align="left">'+macros[i].getAttribute('macroId')+'</td></tr>'+
						  '<tr><td align="right"><b>Macro Intensity:</b></td><td align="left">'+macros[i].getAttribute('intensity')+'</td></tr>'+
						  '<tr><td align="right"><b>Catalog:</b></td><td align="left">'+macros[i].getAttribute('catalog')+'</td></tr>'+
						  '<tr><td align="right"><b>Azimuth:</b></td><td align="left">'+macros[i].getAttribute('azimuth')+'</td></tr>'+
						  '<tr><td align="right"><b>Distance:</b></td><td align="left">'+macros[i].getAttribute('distance')+'</td></tr>'+
			              '<tr><td align="right"><b>Hypocenter distance:</b></td><td align="left">'+macros[i].getAttribute('hypdist')+'</td></tr>'+
		 				  '<tr><td align="right"><b>Intensity:</b></td><td align="left">'+macros[i].getAttribute('intensity')+'</td></tr>'+
						  '<tr><td align="right"><b>Intensity Symbol:</b></td><td align="left">'+macros[i].getAttribute('intensityC')+'</td></tr>'+
						  '<tr><td align="right"><b>Name (EN):</b></td><td align="left">'+macros[i].getAttribute('nameEn')+'</td></tr>'+
       					  '<tr><td align="right"><b>Prefecture (EN):</b></td><td align="left">'+macros[i].getAttribute('prefectureEn')+'</td></tr>'+
					      '<tr><td align="right"><b>Population:</b></td><td align="left">'+macros[i].getAttribute('pop')+'</td></tr>'+
						  '<tr><td align="right"><b>Latitude:</b></td><td align="left">'+macros[i].getAttribute('lat')+'</td></tr>'+
						  '<tr><td align="right"><b>Longitude:</b></td><td align="left">'+macros[i].getAttribute('lon')+'</td></tr>'+
						  '<tr><td align="right"><b>Country:</b></td><td align="left">'+macros[i].getAttribute('country')+'</td></tr>'+
						  '</table>'+
						  '<br/><a href="#" onClick="clearCurrentResult(\''+i+'\')">Remove this Overlay</a>';
				
				var pointLat = parseFloat(macros[i].getAttribute('lat'));
				var pointLon = parseFloat(macros[i].getAttribute('lon'));
				var point = new GLatLng(pointLat, pointLon);
				
				var	intensity=macros[i].getAttribute('intensity');
				var macroIcon = new GIcon();
				var imgURL="";
				
				if(intensity >= 7)
					imgURL="macroRed.png";
				else if (intensity  >= 6)					
					imgURL="macroYellow.png";
				else if (intensity  >= 5)	
					imgURL="macroBlue.png";
				else if (intensity  >= 4)	
					imgURL="macroGreen.png";
				else
					imgURL="macroWhite.png";
				
				macroIcon.image = "img/"+imgURL;
				macroIcon.iconAnchor = new GPoint(16, 16);
				macroIcon.infoWindowAnchor = new GPoint(16, 0);
				macroIcon.iconSize = new GSize(12, 20);
				macroIcon.shadow = "img/macroShadow.png";
				macroIcon.shadowSize = new GSize(22, 20);
		  	  
				tabPointLat[i] = pointLat;
				tabPointLon[i] = pointLon;
				tabPoint[i] = point;
				tabInfo[i] = macroInfo;
				
				var marker = createMarker(point, macroInfo, macroIcon);
				
				map.addOverlay(marker);
				bounds.extend(point);
				copy[i]=marker;
			}
			redraw = macros.length;
			centerOfTheMap();
			bounds = 0;
			macroDataResult=1;
			checkTabMarker();
			sawQuakeMacro(quake);
			var dEnd=new Date();
			var executionTime=dEnd.getTime()-dStart.getTime();
			document.getElementById('status').innerHTML ="Query executed in "+executionTime+ " msec and returned "+macros.length+ " results.";	
			hideForm();
		}
	}
	else if(responseCode == -1) 
	{
		alert("Data request timed out. Please try later.");
    }
	else
	{ 
		alert("Request resulted in error. Check XML file is retrievable.");
	}
	
	});
}

/* displays the quake that has the macroseismic data, which are displayed with function findMacroData */
function sawQuakeMacro(quake)
{
	var searchUrl = 'contents/dbQueries/getQuakeMacro.php?quake=' + quake;
	
	GDownloadUrl(searchUrl, function(data, responseCode)
	{
		if(responseCode == 200)
		{
			var xml = parseXML(data);
			var quakes = xml.getElementsByTagName('quake');
			var quakeInfo='<table align="center" border="0" cellpadding="0" cellspacing="5">'+
						'<tr><td align="right"><b>Quake ID:</b></td><td align="left">'+quakes[0].getAttribute('code')+'</td></tr>'+
						'<tr><td align="right"><b>Quake\'s Magnitude:</b></td><td align="left">'+quakes[0].getAttribute('mag')+'</td></tr>'+
						'<tr><td align="right"><b>Catalog Name:</b></td><td align="left">'+quakes[0].getAttribute('catalog')+'</td></tr>'+		      				  
						'<tr><td align="right"><b>Date - Time:</b></td><td align="left">'+quakes[0].getAttribute('datetime')+'</td></tr>'+
						'<tr><td align="right"><b>Latitude:</b></td><td align="left">'+quakes[0].getAttribute('lat')+'</td></tr>'+
						'<tr><td align="right"><b>Longitude:</b></td><td align="left">'+quakes[0].getAttribute('lon')+'</td></tr>'+
						'<tr><td align="right"><b>Depth:</b></td><td align="left">'+quakes[0].getAttribute('depth')+'</td></tr>'+
						'<tr><td align="right"><b>Agency:</b></td><td align="left">'+quakes[0].getAttribute('agency')+'</td></tr>'+
						'<tr><td align="right"><b>Flinn - Engdahl code:</b></td><td align="left">'+quakes[0].getAttribute('fe')+'</td></tr>'+						  
						'<tr><td align="right"><b>Has macroseismic data:</b></td><td align="left">'+quakes[0].getAttribute('macro')+'</td></tr>'+
						'<tr><td align="right"><b>Has documents:</b></td><td align="left">'+quakes[0].getAttribute('info')+'</td></tr>'+
						'</table>'+
						'<a href="#" onClick="loadBoxContent(\'contents/dbQueries/quakeMag.php\',550,\'auto\',\'quakeID='+quakes[0].getAttribute('code')+'\')">Show Quake\'s Magnitude Data</a>'+
						'<br/><a href="#" onClick="loadBoxContent(\'contents/maps/macroData2.php\',550,150,\'quake='+quakes[0].getAttribute('code')+'\')">Show Quake\'s Macroseismic Data</a>';  
			if(quakes[0].getAttribute('info')=="True")
			{
				quakeInfo=quakeInfo+'<br/><a href="#" onClick="loadBoxContent(\'contents/dbQueries/quakeDoc.php\',550,\'auto\',\'quakeID='+quakes[0].getAttribute('code')+'\')">Show Quake\'s Documents</a>';
			}
			
			var pointLat = parseFloat(quakes[0].getAttribute('lat'));
			var pointLon = parseFloat(quakes[0].getAttribute('lon'));
			var point = new GLatLng(pointLat, pointLon);	  
			
			var quakeIcon = findIcon(parseFloat(quakes[0].getAttribute('mag')),quakes[0].getAttribute('macro'),quakes[0].getAttribute('info'));	  	
			
			var marker = createMarker(point, quakeInfo, quakeIcon);
			
			map.addOverlay(marker);
		}
		else if(responseCode == -1) 
		{
			alert("Data request timed out. Please try later.");
		}
		else
		{ 
			alert("Request resulted in error. Check XML file is retrievable.");
		}
	});
}

/* Select whitch icon suits to a marker */
function findIcon(mag,macro,info)
{
	var newIcon = new GIcon();
	var imgURL="";
	
	if(mag >= 7)
	{
		if(macro == "True")
			imgURL=(info == "True")?"markerADM.png":"markerAM.png";
		else
			imgURL=(info == "True")?"markerAD.png":"markerA.png";
	}			
	else if (mag >= 6)			
	{
		if(macro == "True")
			imgURL=(info == "True")?"markerBDM.png":"markerBM.png";
		else
			imgURL=(info == "True")?"markerBD.png":"markerB.png";	
	}
	else if (mag >= 5)	
	{
		if(macro == "True")
			imgURL=(info == "True")?"markerCDM.png":"markerCM.png";
		else
			imgURL=(info == "True")?"markerCD.png":"markerC.png"; 
	}
	else if (mag >= 4)
	{
		if(macro == "True")
			imgURL=(info == "True")?"markerDDM.png":"markerDM.png";
		else
			imgURL=(info == "True")?"markerDD.png":"markerD.png"; 
	}
	else	
	{
		if(macro == "True")
			imgURL=(info == "True")?"markerEDM.png":"markerEM.png";
		else
			imgURL=(info == "True")?"markerED.png":"markerE.png"; 
	}
	
	newIcon.image = "img/"+imgURL;
    newIcon.iconAnchor = new GPoint(16, 16);
   	newIcon.infoWindowAnchor = new GPoint(16, 0);
    newIcon.iconSize = new GSize(24, 38);
    newIcon.shadow = "img/markerShadow.png";
    newIcon.shadowSize = new GSize(59, 32);		  		  
	return newIcon;
}	

/* Convert xml files to markers */
function getResults(url)
{
	var dStart = new Date();
    
	GDownloadUrl(url, function(data, responseCode)
	{
		if(responseCode == 200)
		{
			//alert("data="+data);
			//alert(responseCode);
			//data=data.replace(/^\s+/g, '');
			var xml = parseXML(data);
			var quakes = xml.getElementsByTagName('quake');
			map.clearOverlays(); 
			//alert("quakes.length="+quakes.length);
			if ((quakes.length == 0) && (data.length<60))
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = 'No results found.';
				e = 1;
			}
			else if(quakes.length == 1 && quakes[0].getAttribute('code')=="error")
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = "<div class='err'>Error during query execution.</div>";
				e = 2;
			}
			else if ((data.length>60) && (quakes.length == 0))
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = 'Too many results. Can not display on screen.';
				alert("Too many results that can't be display on screen!\nPlease make your search for smaller dataset!");
				e = 3;
			}
			else
			{
				bounds = new GLatLngBounds();
				for (var i = 0; i < quakes.length; i++) 
				{		
					var quakeInfo='<table align="center" border="0" cellpadding="0" cellspacing="5">'+
						'<tr><td align="right"><b>Quake ID:</b></td><td align="left">'+quakes[i].getAttribute('code')+'</td></tr>'+
						'<tr><td align="right"><b>Quake\'s Magnitude:</b></td><td align="left">'+quakes[i].getAttribute('mag')+'</td></tr>'+
						'<tr><td align="right"><b>Catalog Name:</b></td><td align="left">'+quakes[i].getAttribute('catalog')+'</td></tr>'+		      				  
						'<tr><td align="right"><b>Date - Time:</b></td><td align="left">'+quakes[i].getAttribute('datetime')+'</td></tr>'+
						'<tr><td align="right"><b>Latitude:</b></td><td align="left">'+quakes[i].getAttribute('lat')+'</td></tr>'+
						'<tr><td align="right"><b>Longitude:</b></td><td align="left">'+quakes[i].getAttribute('lon')+'</td></tr>'+
						'<tr><td align="right"><b>Depth:</b></td><td align="left">'+quakes[i].getAttribute('depth')+'</td></tr>'+
						'<tr><td align="right"><b>Agency:</b></td><td align="left">'+quakes[i].getAttribute('agency')+'</td></tr>'+
						'<tr><td align="right"><b>Flinn - Engdahl code:</b></td><td align="left">'+quakes[i].getAttribute('fe')+'</td></tr>'+						  
						'<tr><td align="right"><b>Has macroseismic data:</b></td><td align="left">'+quakes[i].getAttribute('macro')+'</td></tr>'+
						'<tr><td align="right"><b>Has documents:</b></td><td align="left">'+quakes[i].getAttribute('info')+'</td></tr>'+
						'</table>'+
						'<a href="#" onClick="loadBoxContent(\'contents/dbQueries/quakeMag.php\',550,\'auto\',\'quakeID='+quakes[i].getAttribute('code')+'\')">Show Quake\'s Magnitude Data</a>'; 
					if(quakes[i].getAttribute('macro')=="True")
					{
						quakeInfo=quakeInfo+'<br/><a href="#" onClick="loadBoxContent(\'contents/maps/macroData2.php\',550,150,\'quake='+quakes[i].getAttribute('code')+'\')">Show Quake\'s Macroseismic Data</a>';  
					}
					if(quakes[i].getAttribute('info')=="True")
					{
						quakeInfo=quakeInfo+'<br/><a href="#" onClick="loadBoxContent(\'contents/dbQueries/quakeDoc.php\',550,\'auto\',\'quakeID='+quakes[i].getAttribute('code')+'\')">Show Quake\'s Documents</a>';
					}
					quakeInfo=quakeInfo+'<br/><a href="#" onClick="clearCurrentResult(\''+i+'\')">Remove this Overlay</a>';
					
					var pointLat = parseFloat(quakes[i].getAttribute('lat'));
					var pointLon = parseFloat(quakes[i].getAttribute('lon'));
					var point = new GLatLng(pointLat, pointLon);	  
					
					var quakeIcon = findIcon(parseFloat(quakes[i].getAttribute('mag')),quakes[i].getAttribute('macro'),quakes[i].getAttribute('info'));	  	
					
					tabPointLat[i] = pointLat;
					tabPointLon[i] = pointLon;
					tabPoint[i] = point;
					tabInfo[i] = quakeInfo;
					
					var marker = createMarker(point, quakeInfo, quakeIcon);
					
					map.addOverlay(marker);                 
					bounds.extend(point);	
					copy[i]=marker;
				}
				redraw = quakes.length;
				centerOfTheMap();
				bounds = 0;
				checkTabMarker();
				var dEnd=new Date();
				var executionTime=dEnd.getTime()-dStart.getTime();
				document.getElementById('status').innerHTML ="Query executed in "+executionTime+" msec and returned "+quakes.length+ " results.";
			}
			hideForm();
		}
		else if(responseCode == -1) 
		{
			alert("Data request timed out. Please try later.");
		}
		else
		{ 
			alert("Request resulted in error. Check XML file is retrievable.");
		}
	});
	
}

function findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time)
{
	var searchUrl = 'contents/dbQueries/getRange.php?minMag=' + minMag 
		 				+ '&maxMag=' +  maxMag
						+ '&minDepth=' +  minDepth
						+ '&maxDepth=' +  maxDepth
						+ '&minLat=' +  minLat
						+ '&maxLat=' +  maxLat
						+ '&minLon=' +  minLon
						+ '&maxLon=' +  maxLon
						+ '&minDate=' +  minDate
						+ '&maxDate=' +  maxDate
						+ '&source=' +  source
						+ '&mag=' + mag
						+ '&depth=' + depth
						+ '&time=' + time;
	
	getResults(searchUrl);
}

function findTopN(topN,quakeType,minLat,maxLat,minLon,maxLon,source)
{
	var searchUrl = 'contents/dbQueries/getTopN.php?topN=' + topN 
					+ '&quakeType=' +  quakeType
					+ '&minLat=' +  minLat
					+ '&maxLat=' +  maxLat
					+ '&minLon=' +  minLon
					+ '&maxLon=' +  maxLon
					+ '&source=' +  source;
    
	getResults(searchUrl);
}

function findNN(lat,lon,nNum,mag,source)
{	
	var searchUrl = 'contents/dbQueries/getNN.php?lat='+lat+'&lon='+lon+'&nNum='+nNum+'&mag='+mag+'&source='+source;
     
	getResults(searchUrl);
}

function findDistance(mag,dist,lat,lon,source)
{	
	var searchUrl = 'contents/dbQueries/getDistance.php?mag='+mag+'&dist='+dist+'&lat='+lat+'&lon='+lon+'&source='+source;
     
	getResults(searchUrl);
}

function findMacroQuakes()
{	
	var searchUrl = 'contents/dbQueries/getMacro.php';
     
	getResults(searchUrl);
}

function sawQuakeMag(magString ,source)
{
	var searchUrl = 'contents/dbQueries/getQuakeMagFreq.php?magString='+magString+'&source='+source;
     
	getResults(searchUrl);
}

function sawQuakeDepth(depthString ,source)
{
	var searchUrl = 'contents/dbQueries/getQuakeDepthFreq.php?depthString='+depthString+'&source='+source;
     
	getResults(searchUrl);
}

function getTopEvents(period,source)
{
	var searchUrl = 'contents/dbQueries/getTop.php?period=' + period
			      + '&source=' +  source;

	getResults(searchUrl);
	
	document.getElementById("day").className=(period=="day")?'selectedA':'';
	document.getElementById("week").className=(period=="week")?'selectedA':'';
	document.getElementById("month").className=(period=="month")?'selectedA':'';
	document.getElementById("year").className=(period=="year")?'selectedA':'';
}
