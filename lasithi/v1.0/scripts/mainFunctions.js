var currentLanguage='greek';
var contentIn='';
var currentId = "mainMenu";
var currentPointer = false;
var mapVisible = false;

// ----------------------------------------------------------------
/* The Loader */
function loadAnyContent(targetID, anyContent) {
	var target=document.getElementById(targetID);
	target.innerHTML = anyContent;
}

/* Load Header */
function loadHeader() {
	loadAnyContent("header", '<img src="img/logo.jpg"/>');
}

/* Load Title */
function loadTitle(hasTitle) {
	if(hasTitle==false) loadAnyContent("title", "");
	else if(currentLanguage=='english') loadAnyContent("title", titleEn[currentPointer]);
	else loadAnyContent("title", titleGr[currentPointer]);
}

/* Load Content */
function loadContent() {
	loadAnyContent("content", contentIn);
}

/* Load Footer */
function loadFooter(hasBack, hasGotMap) {
	var temp = '';
	if(hasGotMap!=false) temp += '<a href="#" onclick="loadMap()"><img src="img/house.png"/></a>';
	if(hasBack!=false) temp += '<a href="#" onclick="loadPrevPage()"><img src="img/arrowBig.gif"/></a>';
	else temp += '<a href="#" onclick="setLanguage(\'greek\')"><img src="img/oracle.gif"/></a><a href="#" onclick="setLanguage(\'english\')"><img src="img/php.gif"/></a>';
	loadAnyContent("footer", temp);
}

// ----------------------------------------------------------------
/* Set Language */
function setLanguage(language) {
	currentLanguage = language;
	loadNextPage(currentId, currentPointer);
}

/* Check If Target Has Back_btns, Map & Title */
function checkTitleFooter(hasTitleFooter) {
	if(hasTitleFooter==false){
		loadFooter(false, false);
		loadTitle(false);
	}else{
		var gotMap = false;
		if(hasMap[currentPointer]=='yes') gotMap=true;
		else if(lat[currentPointer]!='#' && idArray[currentPointer].length==6) gotMap=true;
		loadFooter(true, gotMap);
		loadTitle(true);
	}
}

/* Create Menu Buttons */
function createBtns(id) {
	if(currentLanguage=="english"){
		contentIn += '<div id="'+idArray[id]+'" name ="'+name[id]+'" class="button"><button onclick="loadNextPage(\''+idArray[id]+'\', '+id+')">'+titleEn[id]+'</button></div>';
	}else{
		contentIn += '<div id="'+idArray[id]+'" name ="'+name[id]+'" class="button"><button onclick="loadNextPage(\''+idArray[id]+'\', '+id+')">'+titleGr[id]+'</button></div>';
	}
}

/* Create Pages */
function createPage() {
	// select Greek or English content
	var tempLang = '';
	if(currentLanguage=='greek') tempLang = '_gr';
	else tempLang = '_en';
	// create path of External file
	var tempFile = '';
	if(isStaticPage[currentPointer]=='yes'){
		tempFile = 'contents/pages/'+name[currentPointer]+tempLang+'.html';
	}else{
		contentIn = '<img src="contents/pics/'+name[currentPointer]+'.jpg"/><br/>';
		tempFile = 'contents/txts/'+name[currentPointer]+tempLang+'.txt';
	}
	// load External file
	loadPage(tempFile);
}

/* Load Next Page */
function loadNextPage(cid, pointer) {
	contentIn='';
	currentPointer = pointer;
	currentId = cid;
	mapVisible = false;
	if(cid=="mainMenu"){
		// load main menu
		checkTitleFooter(false);
		//contentIn = 'main menu<br/>';
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==2) {
				createBtns(i);
			}
		}
	}else if(cid.length==2 && idArray[pointer+1].length==4){
		// load submenu
		checkTitleFooter(true);
		//contentIn = 'submenu<br/>';
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==4 && idArray[i].substring(0,2)==cid) {
				createBtns(i);
			}
		}
	}else if(cid.length==2 || cid.length==4){
		// load menu items
		checkTitleFooter(true);
		//contentIn = 'menu items<br/>';
		if(cid.length==4 && hasImage[pointer]=='yes') contentIn+='<img src="contents/pics/'+name[pointer]+'.gif"/>';
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==6 && idArray[i].substring(0,cid.length)==cid) {
				createBtns(i);
			}
		}
	}else{
		// load items
		checkTitleFooter(true);
		createPage();
	}
	loadContent();
}

/* Load Prev Page */
function loadPrevPage() {
	var tempId = currentId.substring(0,currentId.length-2);
	var tempPointer = false;
	if(currentId.length!=2){
		for(var i=0; i<idArray.length; i++){
			if(idArray[i]==tempId) tempPointer = i;
		}
		if(tempPointer==false){
			tempId = currentId.substring(0,currentId.length-4);
			for(var i=0; i<idArray.length; i++){
				if(idArray[i]==tempId) tempPointer = i;
			}
		}
	}else{
		tempId = "mainMenu";
	}
	loadNextPage(tempId, tempPointer);
}

// ----------------------------------------------------------------
/* Load Map */
function loadMap() {
	mapVisible = !mapVisible;
	if(mapVisible==true) createMap();
	else loadNextPage(currentId, currentPointer);
}

/* Create Map */
function createMap(){
	loadAnyContent("content", 'map');
}

