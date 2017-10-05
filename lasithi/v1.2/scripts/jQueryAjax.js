// Create Global Arrays
var idArray = new Array();
var lat = new Array();
var lon = new Array();
var nameID = new Array();
var titleEn = new Array();
var titleGr = new Array();
var isStaticPage = new Array();
var hasImage = new Array();
var hasMap = new Array();
//var tempComment = '';

/* jQuery code */
$(document).ready(function(){
	$.ajax({
		type: "GET",
		url: "menu.xml",
		dataType: "xml",
		success: function(xml) {
			// set counter
			var tempCounter=0;
				
			// parse XML
			$(xml).find('menuItem').each(function(){
				//*** Get menuItems ***//
				// Set arrays with xml's atributes
				idArray.push($(this).attr('id'));
				tempCounter = idArray.length-1;
				nameID[tempCounter] = $(this).attr('name');
				titleEn[tempCounter] = $(this).attr('title_en');
				titleGr[tempCounter] = $(this).attr('title_gr');
				hasMap[tempCounter] = $(this).attr('map');
				//tempComment += 'id='+$(this).attr('id')+' tempCounter='+tempCounter+' name='+$(this).attr('name')+' En='+$(this).attr('title_en')+' Gr='+$(this).attr('title_gr')+' map='+$(this).attr('map')+'<br/>';
				$(this).find('submenu').each(function(){
					//*** Get submenus ***//
					if($(this).attr('id')!="#"){
						// Set arrays with xml's atributes
						idArray.push($(this).attr('id'));
						tempCounter = idArray.length-1;
						nameID[tempCounter] = $(this).attr('name');
						titleEn[tempCounter] = $(this).attr('title_en');
						titleGr[tempCounter] = $(this).attr('title_gr');
						hasImage[tempCounter] = $(this).attr('img');
						hasMap[tempCounter] = $(this).attr('map');
						//tempComment += 'id='+$(this).attr('id')+' tempCounter='+tempCounter+' name='+$(this).attr('name')+' En='+$(this).attr('title_en')+' Gr='+$(this).attr('title_gr')+' img='+$(this).attr('img')+' map='+$(this).attr('map')+'<br/>';
					}
					$(this).find('item').each(function(){
						//*** Get items ***//
						// Set arrays with xml's atributes
						idArray.push($(this).attr('id'));
						tempCounter = idArray.length-1;
						nameID[tempCounter] = $(this).attr('name');
						titleEn[tempCounter] = $(this).attr('title_en');
						titleGr[tempCounter] = $(this).attr('title_gr');
						isStaticPage[tempCounter] = $(this).attr('static');
						lat[tempCounter] = $(this).attr('lat');
						lon[tempCounter] = $(this).attr('lon');
						//tempComment += 'id='+$(this).attr('id')+' tempCounter='+tempCounter+' name='+$(this).attr('name')+' En='+$(this).attr('title_en')+' Gr='+$(this).attr('title_gr')+' static='+$(this).attr('static')+' lat='+$(this).attr('lat')+' lon='+$(this).attr('lon')+'<br/>';
					});
					//tempComment += '<br/>';
				});
				//tempComment += '<br/>';
			});
			
			// load all divs functions
			loadHeader();
			setLanguage(currentLanguage);
			//document.getElementById('content').innerHTML = tempComment;
		}
	});
});

// onButtonClick function
function onButtonClick(){
	$("button").click(function(){
		loadNextPage($(this).attr("id"), parseInt($(this).attr("pointer")));
	});
}

