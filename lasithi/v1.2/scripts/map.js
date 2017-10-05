var map = new GoogleMap();

/* Set Google Map */
function GoogleMap(){
	this.initialize = function(){
		var map = showMap();
	}
	var showMap = function(){
		var mapOptions = {
			zoom: 12,
			center: new google.maps.LatLng(35.18, 25.46),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("contentMap"), mapOptions);
		return map;
	}
}

/* Create Marker */
function createMarkers(map){
	var mapBounds = new google.maps.LatLngBounds();
	var latitudeAndLongitudeOne = new google.maps.LatLng('-33.890542','151.274856');
	var markerOne = new google.maps.Marker({
		position: latitudeAndLongitudeOne,
		map: map
	});
	var latitudeAndLongitudeTwo = new google.maps.LatLng('57.77828', '14.17200');
	var markerOne = new google.maps.Marker({
		position: latitudeAndLongitudeTwo,
		map: map
	});
	mapBounds.extend(latitudeAndLongitudeOne);
	mapBounds.extend(latitudeAndLongitudeTwo);
	map.fitBounds(mapBounds);
}

/* Show Map */
function showMap() {
	mapVisible = !mapVisible;
	if(mapVisible==true) {
		document.getElementById("content").style.display='none';
		document.getElementById("contentMap").style.display='block';
		//**********************************
		if (navigator.onLine) {
			alert("online");
			/* Creare Map */
			map = new GoogleMap();
			map.initialize();
			/* Creare Markers */
			//createMarkers(map);
		}else{
			loadAnyContent('contentMap', '<div class="err">There is no Internet Connection</div>');
		}
		//**********************************
	}else{
		document.getElementById("contentMap").style.display='none';
		document.getElementById("content").style.display='block';
	}
}

/*
var map;
var bounds = 0;
var zoom = 0;
var lat = 0;
var lng = 0;

/* set map 
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

/* centers map 
function centerOfTheMap()
{
	//default
	if (bounds==0 && lat==0 && lng==0 && zoom==0)
		map.setCenter(new GLatLng(38, 25), 6);
	//query
	else
		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
}

/* create marker 
function createMarker(point, descr) 
{
	// set markers icon
	var newIcon = new GIcon();
	newIcon.image = "img/markerA.png";
    newIcon.iconAnchor = new GPoint(16, 16);
   	newIcon.infoWindowAnchor = new GPoint(16, 0);
    newIcon.iconSize = new GSize(24, 38);
    newIcon.shadow = "img/markerShadow.png";
    newIcon.shadowSize = new GSize(59, 32);	
	//create marker
	var marker = new GMarker(point,newIcon);
	//show tab info
    GEvent.addListener(marker, 'click', function() {
        marker.openInfoWindowHtml(descr);
      });
	return marker;
}

/* Convert xml files to markers 
function getResults(url)
{
	GDownloadUrl(url, function(data, responseCode)
	{
		if(responseCode == 200)
		{
			//alert(responseCode);
			var xml = parseXML(data);
			var quakes = xml.getElementsByTagName('quake');
			//alert("quakes.length="+quakes.length);
			if ((quakes.length == 0) && (data.length<60))
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = 'No results found.';
			}
			else if(quakes.length == 1 && quakes[0].getAttribute('code')=="error")
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = "<div class='err'>Error during query execution.</div>";
			}
			else if ((data.length>60) && (quakes.length == 0))
			{
				centerOfTheMap();
				document.getElementById('status').innerHTML = 'Too many results. Can not display on screen.';
				alert("Too many results that can't be display on screen!\nPlease make your search for smaller dataset!");
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
					
					var marker = createMarker(point, quakeInfo);
					
					map.addOverlay(marker);                 
					bounds.extend(point);
				}
				centerOfTheMap();
				bounds = 0;
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

function findDistance(mag,dist,lat,lon,source)
{	
	var searchUrl = 'contents/dbQueries/getDistance.php?mag='+mag+'&dist='+dist+'&lat='+lat+'&lon='+lon+'&source='+source;
     
	getResults(searchUrl);
}
*/

