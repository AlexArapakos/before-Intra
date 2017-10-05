var idArray = new Array();
var lat = new Array();
var lon = new Array();
var name = new Array();
var titleEn = new Array();
var titleGr = new Array();
var isStaticPage = new Array();
var hasImage = new Array();
var hasMap = new Array();

/* Create request Object for different browsers */
function loadXMLDoc(){
	var xhttp = false;
	try{		
		xhttp=new XMLHttpRequest();
	}catch (e){		
		try{
			xhttp=new ActiveXObject("MSXML2.XMLHTTP");
		}catch (e){
			try{
				xhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert('Error creating the request.');
			}
		}
	}
	return xhttp;
} 

/* Parse XML */
function parseXML() {
	var tempCounter=0;
	
	// Call an XMLHttpRequest
	var httpXML = loadXMLDoc();
	httpXML.open("get","menu.xml",false);
	httpXML.send();
	
	var xmlDoc = httpXML.responseXML;
	
	// Place the root node in an element.
	var Menu = xmlDoc.childNodes[0];
	
	for (var i = 0; i < Menu.children.length; i++){
		//*** Get menuItems ***//
		var menuItem = Menu.children[i];
		// Set arrays with xml's atributes
		idArray.push(menuItem.getAttribute("id"));
		tempCounter = idArray.length-1;
		name[tempCounter] = menuItem.getAttribute("name");
		titleEn[tempCounter] = menuItem.getAttribute("title_en");
		titleGr[tempCounter] = menuItem.getAttribute("title_gr");
		hasMap[tempCounter] = menuItem.getAttribute("map");
		
		for (var j = 0; j < menuItem.children.length; j++){
			//*** Get submenus ***//
			var submenu = menuItem.children[j];
			// Access each of the xml atributes
			if(submenu.getAttribute("id")!="#"){
				// Set arrays with xml's atributes
				idArray.push(submenu.getAttribute("id"));
				tempCounter = idArray.length-1;
				name[tempCounter] = submenu.getAttribute("name");
				titleEn[tempCounter] = submenu.getAttribute("title_en");
				titleGr[tempCounter] = submenu.getAttribute("title_gr");
				hasImage[tempCounter] = submenu.getAttribute("img");
				hasMap[tempCounter] = submenu.getAttribute("map");
			}
			
			for (var k = 0; k < submenu.children.length; k++){
				//*** Get items ***//
				var item = submenu.children[k];
				// Set arrays with xml's atributes
				idArray.push(item.getAttribute("id"));
				tempCounter = idArray.length-1;
				name[tempCounter] = item.getAttribute("name");
				titleEn[tempCounter] = item.getAttribute("title_en");
				titleGr[tempCounter] = item.getAttribute("title_gr");
				isStaticPage[tempCounter] = item.getAttribute("static");
				lat[tempCounter] = item.getAttribute("lat");
				lon[tempCounter] = item.getAttribute("lon");
			}
		}
	}
	
	// load all parts functions
	loadHeader();
	setLanguage(currentLanguage);
}

/* load External File */
function loadPage(fileName) {
	// Call an XMLHttpRequest
	var http = loadXMLDoc();
	http.open("get", fileName, false);
	http.send(null);
	// put response Text in target
	var externalDoc = http.responseText;
	contentIn += '<p>'+externalDoc+'</p>';
}

