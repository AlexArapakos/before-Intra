/* Create request Object for different browsers */
function createRequestObject()
{
	var req = false;
	try
	{		
		req=new XMLHttpRequest();
	}
	catch (e)
	{		
		try
		{
			req=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				req=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert('Error creating the request.');
			}
		}
	}
	return req;
}

/*the XML parser*/
function parseXML(data) 
{ 
	//GLog.write(data); 
	var xmlDoc; 
	// code for IE 
	try //if(window.ActiveXObject)
	{ 
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM"); 
		xmlDoc.async=false;
		xmlDoc.loadXML(data); 
	}
	// code for Mozilla, Firefox, Opera, etc. 
	catch(e)
	{
		try
		{
			xmlDoc=(new DOMParser()).parseFromString(data,"text/xml");
		}
		catch(e)
		{
			alert(e.message);
			return;
		}
	}
	return xmlDoc;
}

/* Handle server responce */
function handleServerResponse(targetId,http)
{
	var target = document.getElementById(targetId);
	if (http.readyState == 1)
	{		
		if(targetId=="leftMenuContent")
			target.innerHTML = '<br><br><br><h4><img src="img/loading.gif"/></h4><br><br><br>';
		else if(targetId=="leftLoginContent")
			target.innerHTML = '<br><br><br><h4><img src="img/loading.gif"/></h4><br><br><br>';
		else if(targetId=="rightTextContent")
			target.innerHTML = '<div class="title">Loading...</div><div class="roundRightContent"><br><br><br><h4><img src="img/loading.gif"/></h4><br><br><br></div>';
		else if(targetId=="boxForm")
			target.innerHTML = '<div class="squareTitle">Loading...</div><div class="squareContent"><br><br><h4><img src="img/loading.gif"/></h4><br><br></div>';
	}	
	else if (http.readyState == 4)
	{
		if (http.status == 200)
		{
			try	
			{
				target.innerHTML = "<!-- IE Fix " + http.responseText;
			}
			catch(e)
			{
				alert("Error reading the response: " + e.toString());
			}
		}
		else
			alert("There was a problem retrieving the data("+http.status+"):" +http.statusText);
	}
}

/* Change top menu classes */
function changeTopClass(topMenu)
{
	var menu=document.getElementById("menuHeader");
	var listItems = menu.getElementsByTagName("a");
	for (i = 0; i < listItems.length; i++)
	{					
		if(listItems[i].name==topMenu)
			listItems[i].className = "active";
		else
			listItems[i].className = "menuNormal";
	}		
}

/* Load right and left content */
function loadRightLeftContent(urlRight,urlLeft,topMenu,mapVisible)
{
	if(topMenu!="none")
	{
		if(document.getElementById(topMenu).className=="active")
			return;
	}

	loadRightContent(urlRight,mapVisible);	
	
	if(urlLeft=='none')
		document.getElementById("leftMenuContent").innerHTML="";
	else
		loadLeftContent(urlLeft,0);
	
	changeTopClass(topMenu);	
}

/* Load right content */
function loadRightContent(url,mapVisible) 
{	
	var http = createRequestObject();
	  
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	if (mapVisible==true)
		document.getElementById('mapContent').style.display='block';
	else
		document.getElementById('mapContent').style.display='none';
	
	var target=document.getElementById("rightTextContent");
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", "0");	
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("rightTextContent",http); }
  	try
  	{
  		http.send("");
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="title">Error</div><div class="roundRightContent"><div class="err">Request failed</div></div>';
  	}	
}

/* Load left content */
function loadLeftContent(url) 
{
	var http = createRequestObject();
	
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	var target=document.getElementById("leftMenuContent");
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", '0');
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("leftMenuContent",http); }
  	try
  	{
  		http.send('');
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="err">Request failed</div>';
  	}	
}

/* Registration */
function register() 
{
	var http = createRequestObject();
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	document.getElementById('mapContent').style.display='none';
	
	var url = "contents/users/register.php";
	var target=document.getElementById("rightTextContent");
	var nickName=document.getElementById("nickName").value;
	var email=document.getElementById("email").value;
	var password=document.getElementById("password").value;
	var passwordConfirm=document.getElementById("passwordConfirm").value;
	var firstName=document.getElementById("firstName").value;
	var lastName=document.getElementById("lastName").value;
	var country=document.getElementById("country").value;
	var city=document.getElementById("city").value;
	var params = "nickName="+nickName+"&email="+email+"&password="+password+"&passwordConfirm="+passwordConfirm+"&firstName="+firstName+"&lastName="+lastName+"&country="+country+"&city="+city;
	
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("rightTextContent",http); }
  	try
  	{
  		http.send(params);
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="title">Error</div><div class="roundRightContent"><div class="err">Request failed</div></div>';
  	}
}

/* Retrieve password */
function retrieve() 
{
	var http = createRequestObject();
	  
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	document.getElementById('mapContent').style.display='none';
	
	var url = "contents/users/forgotPassword.php";
	var target=document.getElementById("rightTextContent");
	var email=document.getElementById("email").value;
	var params = "email="+email;
	
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("rightTextContent",http); }
  	try
  	{
  		http.send(params);
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="title">Error</div><div class="roundRightContent"><div class="err">Request failed</div></div>';
  	}
}			

/* Load box content */
function loadBoxContent(url,width,height,params) 
{	
	var http = createRequestObject();
	  
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	showForm(width,height);	
	var target=document.getElementById("boxForm");
	var maplat = parseFloat(map.getCenter().lat()).toFixed(5);
	var maplng = parseFloat(map.getCenter().lng()).toFixed(5);
	var mapzoom = map.getZoom();
	
	if (!params)
		params = "maplat="+maplat+"&maplon="+maplng+"&zoom="+mapzoom;
	else
		params = params+"&maplat="+maplat+"&maplon="+maplng+"&zoom="+mapzoom;
	
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("boxForm",http); }	
  	try
  	{
  		http.send(params);
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="err">Request failed</div>';
  	}	
	
}

/* Load big box content */
function loadBigBoxContent(url,params) 
{	
	var http = createRequestObject();
	  
	if(!http)
	{
		alert("Your Web browser does not support the XMLHttpRequest object.");
		return;
	}
	
	showBigForm();	
	var target=document.getElementById("boxForm");
	http.open("POST", url, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

  	http.onreadystatechange = function() { handleServerResponse("boxForm",http); }	
  	try
  	{
  		http.send(params);
  	}
 	catch(e)
  	{
    	while(target.firstChild)
			target.removeChild(target.firstChild);
    	target.innerHTML='<div class="err">Request failed</div>';
  	}	
}

function showLoader()
{
	document.getElementById('preloader').style.visibility = 'hidden';	
	document.getElementById('preloader').style.display = 'none';
	document.getElementById('loader').style.display = 'block';	
}

function enableMeasure()
{
	if(document.getElementById('measureDistance').checked==true)	
		document.getElementById('measure').style.display = 'block';	
	else
		document.getElementById('measure').style.display = 'none';	
	resetCounter();
}

function hideShowSavePosition()
{	
	if(document.getElementById("newPosition").checked==true)	
	{
		document.getElementById('newPositionName').style.visibility = 'visible';
		document.getElementById('replacePositionName').style.visibility = 'hidden';		
	}
	else
	{		
		document.getElementById('newPositionName').style.visibility = 'hidden';
		document.getElementById('replacePositionName').style.visibility = 'visible';
	}
}

function showCoordinatesType()
{
	var coordType=document.getElementById("coordinateType");
	
	document.getElementById("decDeg").style.display=(coordType.selectedIndex==0)?'block':'none';
	document.getElementById("dms").style.display=(coordType.selectedIndex==1)?'block':'none';
	document.getElementById("utm").style.display=(coordType.selectedIndex==2)?'block':'none';
	document.getElementById("mgrs").style.display=(coordType.selectedIndex==3)?'block':'none';
}
