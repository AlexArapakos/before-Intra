var currentLanguage='greek';
var contentIn='';
var currentId = "mainMenu";
var currentPointer = false;
var mapVisible = false;
var isPage = false;
var tempFile = '';

/* Close Application */
function closeApp(){
	if(navigator.app){
        navigator.app.exitApp();
	}else if(navigator.device){
		navigator.device.exitApp();
	}
}

// ----------------------------------------------------------------
/* The Loader */
function loadAnyContent(targetID, anyContent) {
	$("#"+targetID).empty();
	$("#"+targetID).html(anyContent);
}

/* Load Header */
function loadHeader() {
	loadAnyContent("header", '<img src="img/logo.jpg"/><a href="#" onclick="closeApp()"><img src="img/arrowBig.gif"/></a>');
}

/* Load Title */
function loadTitle(hasTitle) {
	if(hasTitle==false) loadAnyContent("title", "");
	else if(currentLanguage=='english') loadAnyContent("title", titleEn[currentPointer]);
	else loadAnyContent("title", titleGr[currentPointer]);
}

/* Load Content */
function loadContent() {
	contentIn += '<div id="externalTextContent"></div>';
	loadAnyContent("content", contentIn);
	// load External file
	if(isPage) $('#externalTextContent').load(tempFile);
}

/* Load Footer */
function loadFooter(hasBack, hasGotMap) {
	var temp = '';
	if(hasGotMap!=false) temp += '<a href="#" onclick="showMap()"><img src="img/house.png"/></a>';
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
		contentIn += '<div class="buttonDiv"><button id="'+idArray[id]+'" pointer="'+id+'">'+titleEn[id]+'</button></div>';
	}else{
		contentIn += '<div class="buttonDiv"><button id="'+idArray[id]+'" pointer="'+id+'">'+titleGr[id]+'</button></div>';
	}
}

/* Create Pages */
function createPage() {
	// select Greek or English content
	isPage = true;
	var tempLang = '';
	if(currentLanguage=='greek') tempLang = '_gr';
	else tempLang = '_en';
	// create path of External file
	tempFile = '';
	if(isStaticPage[currentPointer]=='yes'){
		tempFile = 'contents/pages/'+nameID[currentPointer]+tempLang+'.html';
	}else{
		contentIn = '<img src="contents/pics/'+nameID[currentPointer]+'.jpg"/><br/>';
		tempFile = 'contents/txts/'+nameID[currentPointer]+tempLang+'.txt';
	}
}

/* Load Next Page */
function loadNextPage(cid, pointer) {
	contentIn='';
	currentPointer = pointer;
	currentId = cid;
	mapVisible = false;
	isPage = false;
	var hasBackBtn = true;
	if(cid=="mainMenu"){
		// load main menu
		hasBackBtn = false;
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==2) {
				createBtns(i);
			}
		}
	}else if(cid.length==2 && idArray[pointer+1].length==4){
		// load submenu
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==4 && idArray[i].substring(0,2)==cid) {
				createBtns(i);
			}
		}
	}else if(cid.length==2 || cid.length==4){
		// load menu items
		if(cid.length==4 && hasImage[pointer]=='yes') contentIn+='<img src="contents/pics/'+nameID[pointer]+'.gif"/>';
		for(var i=0; i<idArray.length; i++){
			if(idArray[i].length==6 && idArray[i].substring(0,cid.length)==cid) {
				createBtns(i);
			}
		}
	}else{
		// load items
		createPage();
	}
	checkTitleFooter(hasBackBtn);
	loadContent();
	onButtonClick();
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
	document.getElementById("content").style.display='block';
	document.getElementById("contentMap").style.display='none';
}

