function showForm(width,height)
{	
	var size = getSize();	
	
	var dis=document.getElementById("dis");
	var box=document.getElementById("boxForm");
	
	var totalWidth = document.getElementById("theBody").offsetWidth;
	var totalHeight = document.getElementById("theBody").offsetHeight;
	
	dis.style.left = "0px";
	dis.style.top = "0px";
	dis.style.width = totalWidth+"px";
	dis.style.height = totalHeight+"px";
	dis.style.display='block';
	dis.style.backgroundColor='';
	dis.style.backgroundImage="url(img/dis.png)";
	dis.style.backgroundRepeat='repeat';
	
	box.style.width=width+"px";
	box.style.height=(height=='auto')?'auto':height+"px";
	box.style.left = size[0]/2-width/2+"px";
	box.style.top = (height=='auto')?size[1]/2-100+"px":size[1]/2-height/2+"px";		
	box.style.display='block';	
}

function showBigForm()
{	
	var dis=document.getElementById("dis");
	var box=document.getElementById("boxForm");
	
	var totalWidth = document.getElementById("theBody").offsetWidth;
	var totalHeight = document.getElementById("theBody").offsetHeight;
	
	dis.style.left = box.style.left = "0px";
	dis.style.top = box.style.top = "0px";
	dis.style.width = totalWidth+"px";
	dis.style.height = totalHeight+"px";
	dis.style.display='block';	
	dis.style.backgroundColor='#C3D9FF';
	dis.style.backgroundImage='none';	
	
	box.style.width = box.style.height = "auto";		
	box.style.display='block';	
}

function hideForm()
{	
	var dis=document.getElementById("dis");
	var box=document.getElementById("boxForm");
	
	box.innerHTML = "";
	box.style.display = 'none';
	dis.style.display = 'none';
}

/* Save position */
function saveCurrentPosition()
{
	var userName = document.getElementById("userName").value;
	var lat = parseFloat(map.getCenter().lat()).toFixed(5);
	var lng = parseFloat(map.getCenter().lng()).toFixed(5);
	var zoom = parseInt(map.getZoom());
	
	if (document.getElementById("newPosition").checked==true)
	{
		var positionName=document.getElementById("newPositionName").value;
		//alert("userName="+userName+" positionName="+positionName+" lat="+lat+" lng="+lng+" zoom="+zoom);
		if(positionName=="")
		{
			document.getElementById("boxStatusBar").innerHTML="<div class='err'>Error: You must name the position.</div>";
		}
		else
		{
			var searchUrl = "contents/dbQueries/setPosition.php?userName="+userName+"&positionName="+positionName+"&lat="+lat+"&lng="+lng+"&zoom="+zoom;
			
			GDownloadUrl(searchUrl, function(data, responseCode) 
			{
				if(responseCode == 200)
				{
					if (data == 'inserted correctly')
					{
						document.getElementById("status").innerHTML="Position saved as "+positionName;
					}
					else
					{
						document.getElementById('status').innerHTML = "<div class='err'>"+data+"</div>";
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
	}
	else
	{
		if(document.getElementById("replacePositionName").innerHTML=="No positions found")
		{
			document.getElementById("boxStatusBar").innerHTML="<div class='err'>Error: No saved positions found.</div>";			
		}
		else
		{
			var positionName=document.getElementById("replacePositionName").options[document.getElementById("replacePositionName").selectedIndex].text;
			
			var searchUrl = "contents/dbQueries/updatePosition.php?userName="+userName+"&positionName="+positionName+"&lat="+lat+"&lng="+lng+"&zoom="+zoom;
			
			GDownloadUrl(searchUrl, function(data, responseCode) 
			{
				if(responseCode == 200)
				{
					if (data == 'inserted correctly')
					{
						document.getElementById("status").innerHTML="Position saved as "+positionName;
					}
					else
					{
						document.getElementById('status').innerHTML = "<div class='err'>"+data+"</div>";
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
	}
}

/* load position */
function loadSelectedPosition()
{
	var userName = document.getElementById("userName").value;
	var positionName=document.getElementById("loadPositionName").value;
	
	if(document.getElementById("loadPositionName").innerHTML=="No positions found")
	{
		document.getElementById("boxStatusBar").innerHTML="<div class='err'>Error: No saved positions found.</div>";			
	}
	else
	{
		positionName=document.getElementById("loadPositionName").options[document.getElementById("loadPositionName").selectedIndex].text;
		var searchUrl = "contents/dbQueries/loadPosition.php?userName="+userName+"&positionName="+positionName;
			
		GDownloadUrl(searchUrl, function(data, responseCode) 
		{
			if(responseCode == 200)
			{
				var xml = parseXML(data);
				var position = xml.getElementsByTagName("position");
		
				if (position[0].getAttribute('lat') == 'error')
				{
					document.getElementById('status').innerHTML = "<div class='err'>"+position[0].getAttribute('lng')+"</div>";
				}
				else
				{
					map.setZoom(parseInt(position[0].getAttribute('zoom'))); 
					map.panTo(new GLatLng(position[0].getAttribute('lat'),position[0].getAttribute('lng')));
					document.getElementById("status").innerHTML="Position "+positionName + " loaded correctly.";
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
}

/* delete position */
function deleteSelectedPosition()
{
	var userName = document.getElementById("userName").value;
	var positionName=document.getElementById("deletePositionName").value;
	
	if(document.getElementById("deletePositionName").innerHTML=="No positions found")
	{
		
		document.getElementById("boxStatusBar").innerHTML="<div class='err'>Error: No saved positions found.</div>";			
	}
	else
	{
		positionName=document.getElementById("deletePositionName").options[document.getElementById("deletePositionName").selectedIndex].text;
		var searchUrl = "contents/dbQueries/deletePosition.php?userName="+userName+"&positionName="+positionName;
			
		GDownloadUrl(searchUrl, function(data, responseCode) 
		{
			if(responseCode == 200)
			{
				if (data == 'deleted correctly')
				{
					document.getElementById("status").innerHTML="Position "+positionName + " deleted.";
				}
				else
				{
					document.getElementById('status').innerHTML = "<div class='err'>"+data+"</div>";
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
}

function moveToCoordinates()
{
	var coordType=document.getElementById("coordinateType");
	if (coordType.selectedIndex==0)
	{
		map.setCenter(new GLatLng(parseFloat(document.getElementById("decDegLat").value),parseFloat(document.getElementById("decDegLong").value)), parseInt(document.getElementById("zoomVal").value));
		document.getElementById("status").innerHTML="Moved successfully to coordinates.";
		document.getElementById("zoom").innerHTML="Zoom: " + parseInt(document.getElementById("zoomVal").value);
		hideForm();
	}
	else if (coordType.selectedIndex==1)
	{
		map.setCenter(new GLatLng(parseFloat(document.getElementById("dmsLatDec").value)+parseFloat(document.getElementById("dmsLatMin").value)/60+parseFloat(document.getElementById("dmsLatSec").value)/360,parseFloat(document.getElementById("dmsLongDec").value)+parseFloat(document.getElementById("dmsLongMin").value)/60+parseFloat(document.getElementById("dmsLongSec").value)/360), parseInt(document.getElementById("zoomVal").value));
		document.getElementById("status").innerHTML="Moved successfully to coordinates.";
		hideForm();
	}
	else if (coordType.selectedIndex==2)
	{
		if(utmToLatLon(document.getElementById("utmZone"), document.getElementById("utmHem"), document.getElementById("utmEast"), document.getElementById("utmNor"), parseInt(document.getElementById("zoomVal").value))==false)
			document.getElementById("status").innerHTML="<div class='err'>Error: Coordinates are not valid.</div>";
		else
		{
			document.getElementById("status").innerHTML="Moved successfully to coordinates.";
			hideForm();
		}
	}
	else
	{
		if(GUsngtoLL(document.getElementById("utmHem").value, parseInt(document.getElementById("zoomVal").value))==false)
			document.getElementById("status").innerHTML="<div class='err'>Error: Coordinates are not valid.</div>";
		else
		{
			document.getElementById("status").innerHTML="Moved successfully to coordinates.";
			hideForm();
		}			
	}	
}

function loadSites()
{

	var minPopulation=parseInt(document.getElementById('minPop').value);
	var maxPopulation=parseInt(document.getElementById('maxPop').value);
	
	if (minPopulation<=maxPopulation)
	{
		document.getElementById('squareTitle').innerHTML="Executing query...";
		document.getElementById('boxForm').style.height="80px";
		document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
		findSites(minPopulation, maxPopulation);
	}
	else
		alert("You haven't parse the data correctly!");
	
}

function loadRange()
{
	var minMag=parseFloat(document.getElementById("minMag").value);
	var maxMag=parseFloat(document.getElementById("maxMag").value);	
	var minDepth=parseInt(document.getElementById("minDepth").value);
	var maxDepth=parseInt(document.getElementById("maxDepth").value);
	var minLat=parseFloat(document.getElementById("minLat").value);
	var maxLat=parseFloat(document.getElementById("maxLat").value);
	var minLon=parseFloat(document.getElementById("minLon").value);
	var maxLon=parseFloat(document.getElementById("maxLon").value);
	var yearFrom=parseInt(document.getElementById("yearFrom").options[document.getElementById("yearFrom").selectedIndex].text);
	var monthFrom=parseInt(document.getElementById("monthFrom").options[document.getElementById("monthFrom").selectedIndex].text);
	var dayFrom=parseInt(document.getElementById("dayFrom").options[document.getElementById("dayFrom").selectedIndex].text);
	var yearTo=parseInt(document.getElementById("yearTo").options[document.getElementById("yearTo").selectedIndex].text);
	var monthTo=parseInt(document.getElementById("monthTo").options[document.getElementById("monthTo").selectedIndex].text);
	var dayTo=parseInt(document.getElementById("dayTo").options[document.getElementById("dayTo").selectedIndex].text);
	var minDate= yearFrom + "-" + monthFrom + "-" + dayFrom;
	var maxDate= yearTo + "-" + monthTo + "-" + dayTo;
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	var mag=(document.getElementById("mag").checked==true)?1:0;
	var depth=(document.getElementById("depth").checked==true)?1:0;
	var time=(document.getElementById("time").checked==true)?1:0;
	
	if ((minLat<=maxLat) && (minLon<=maxLon))
	{
		if ((mag==1) && (depth==1) && (time==1) && (minMag<=maxMag) && (minDepth<=maxDepth) && ((yearFrom<yearTo) || ((yearFrom==yearTo) && (monthFrom<monthTo)) || ((yearFrom==yearTo) && (monthFrom==monthTo) && (dayFrom<=dayTo))))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==1) && (depth==1) && (time==0) && (minMag<=maxMag) && (minDepth<=maxDepth))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==1) && (depth==0) && (time==1) && (minMag<=maxMag) && ((yearFrom<yearTo) || ((yearFrom==yearTo) && (monthFrom<monthTo)) || ((yearFrom==yearTo) && (monthFrom==monthTo) && (dayFrom<=dayTo))))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==1) && (depth==0) && (time==0) && (minMag<=maxMag))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==0) && (depth==1) && (time==1) && (minDepth<=maxDepth) && ((yearFrom<yearTo) || ((yearFrom==yearTo) && (monthFrom<monthTo)) || ((yearFrom==yearTo) && (monthFrom==monthTo) && (dayFrom<=dayTo))))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==0) && (depth==1) && (time==0) && (minDepth<=maxDepth))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==0) && (depth==0) && (time==1) && ((yearFrom<yearTo) || ((yearFrom==yearTo) && (monthFrom<monthTo)) || ((yearFrom==yearTo) && (monthFrom==monthTo) && (dayFrom<=dayTo))))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else if ((mag==0) && (depth==0) && (time==0))
		{
			document.getElementById('squareTitle').innerHTML="Executing query...";
			document.getElementById('boxForm').style.height="80px";
			document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
			findRange(minMag,maxMag,minDepth,maxDepth,minLat,maxLat,minLon,maxLon,minDate,maxDate,source,mag,depth,time);
		}
		else
			alert("You haven't parse the data correctly!");
	}
	else
		alert("You haven't parse the data correctly!\nGet range from a spot or an area!");
}

function loadTopN()
{
	var topN=parseInt(document.getElementById("topN").value);
	var quakeType=parseInt(document.getElementById("quakeType").options[document.getElementById("quakeType").selectedIndex].value);
	var minLat=parseFloat(document.getElementById("minLat").value);
	var maxLat=parseFloat(document.getElementById("maxLat").value);
	var minLon=parseFloat(document.getElementById("minLon").value);
	var maxLon=parseFloat(document.getElementById("maxLon").value);
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	
	if ((minLat<maxLat) && (minLon<maxLon))
	{
		document.getElementById('squareTitle').innerHTML="Executing query...";
		document.getElementById('boxForm').style.height="80px";
		document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
		findTopN(topN,quakeType,minLat,maxLat,minLon,maxLon,source);
	}
	else
		alert("You haven't parse the data correctly!");
	
}

function loadNN()
{
	var lat=parseFloat(document.getElementById("lat").value);
	var lon=parseFloat(document.getElementById("lon").value);
	var nNum=parseInt(document.getElementById("nNumber").value);
	var mag=parseFloat(document.getElementById("mag").value);
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	
	document.getElementById('squareTitle').innerHTML="Executing query...";
	document.getElementById('boxForm').style.height="80px";
	document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';	
	
	findNN(lat,lon,nNum,mag,source);				
}

function loadDistance()
{
	var mag=parseFloat(document.getElementById("mag").value);
	var dist=parseInt(document.getElementById("dist").value);
	var lat=parseFloat(document.getElementById("lat").value);
	var lon=parseFloat(document.getElementById("lon").value);	
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	
	document.getElementById('squareTitle').innerHTML="Executing query...";
	document.getElementById('boxForm').style.height="80px";
	document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';	
	
	findDistance(mag,dist,lat,lon,source);				
}

function loadMacro()
{
	showForm(300,150);
	document.getElementById("boxForm").innerHTML='<div id="squareTitle" class="squareTitle">'
												+'<table align="center" border="0" cellpadding="0" cellspacing="0" width="350">'
												+'<tr><td align="left">&nbsp;Quakes with Macroseismic Data</td>'
												+'<td align="right"><div class="smallText">'
												+'[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td></tr></table></div>'
												+'<div id="squareContent" class="squareContent"></div>';
	document.getElementById('squareTitle').innerHTML="Executing query...";
	document.getElementById('boxForm').style.height="80px";
	document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr>'
													  +'<td>Please wait while executing query...</td>'
													  +'<td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td>'
													  +'</tr></table>';	
	findMacroQuakes();				
}

function loadMacroData(quake)
{
	var minIntensity=parseFloat(document.getElementById("minIntensity").value);
	var maxIntensity=parseFloat(document.getElementById("maxIntensity").value);
	
	if (minIntensity<=maxIntensity)
	{
		showForm(300,150);
		document.getElementById("boxForm").innerHTML='<div id="squareTitle" class="squareTitle">'
													+'<table align="center" border="0" cellpadding="0" cellspacing="0" width="350">'
													+'<tr><td align="left">&nbsp;Quake\'s Macroseismic Data</td>'
													+'<td align="right"><div class="smallText">'
													+'[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td></tr></table></div>'
													+'<div id="squareContent" class="squareContent"></div>';
		document.getElementById('squareTitle').innerHTML="Executing query...";
		document.getElementById('boxForm').style.height="80px";
		document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr>'
														  +'<td>Please wait while executing query...</td>'
														  +'<td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td>'
														  +'</tr></table>';
		
		findMacroData(quake, minIntensity, maxIntensity);
	}
	else
		alert("You haven't parse the data correctly!");
}

function loadMagFreq()
{
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	loadBigBoxContent('contents/dbQueries/MagFreq.php','source='+source);
}

function sawQuakeMagFreq()
{
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	var counter=parseInt(document.getElementById("counter").value);
	var q=0;
	var magString='';
	for(i=0; i<counter; i++)
	{
		var mag=(document.getElementById("mag["+i+"]").checked==true)?1:0;
		if (mag==1)
		{
			var getMag=parseFloat(document.getElementById("mag["+i+"]").value);
			if (q==0)
				magString = getMag;
			else
				magString = magString + "-" + getMag;
			q++;
		}
	}
	
	if (q>0)
	{
		document.getElementById('squareTitle').innerHTML="Executing query...";
		document.getElementById('boxForm').style.height="80px";
		document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
		sawQuakeMag(magString, source);
	}
	else
		alert("You haven't checked any checkbox!");
}

function loadDepFreq()
{
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	loadBigBoxContent('contents/dbQueries/DepFreq.php','source='+source);
}

function sawQuakeDepthFreq()
{
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;
	var counter=parseInt(document.getElementById("counter").value);
	var q=0;
	var depthString='';
	for(i=0; i<counter; i++)
	{
		var depth=(document.getElementById("depth["+i+"]").checked==true)?1:0;
		if (depth==1)
		{
			var getDepth=parseInt(document.getElementById("depth["+i+"]").value);
			if (q==0)
				depthString = getDepth;
			else
				depthString = depthString + "-" + getDepth;
			q++;
		}
	}
	if (q>0)
	{
		document.getElementById('squareTitle').innerHTML="Executing query...";
		document.getElementById('boxForm').style.height="80px";
		document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';
		sawQuakeDepth(depthString, source);
	}
	else
		alert("You haven't checked any checkbox!");
}

function loadTopEvents(period)
{	
	var source = document.getElementById("source").options[document.getElementById("source").selectedIndex].text;

	showForm(300,150);
	document.getElementById("boxForm").innerHTML='<div id="squareTitle" class="squareTitle">'
												+'<table align="center" border="0" cellpadding="0" cellspacing="0" width="350">'
												+'<tr><td align="left">&nbsp;Quake\'s Macroseismic Data</td>'
												+'<td align="right"><div class="smallText">'
												+'[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td></tr></table></div>'
												+'<div id="squareContent" class="squareContent"></div>';
	document.getElementById('squareTitle').innerHTML="Executing query...";
	document.getElementById('boxForm').style.height="80px";
	document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="230"><tr><td>Please wait while executing query...</td><td><img alt="Executing query..." title="Executing Query..." src="img/queryExecution.gif"></td></tr></table>';

	getTopEvents(period,source)
}
