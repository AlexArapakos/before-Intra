function ClickHereToPrint(itemToPrint,containsMap)
{
	var i = 0;
	var width = 718;
 	var height = 500;
	var left   = (screen.width  - width)/2;
 	var top    = (screen.height - height)/2;
 	var params = 'width='+width+', height='+height;
 	params += ', top='+top+', left='+left;
 	params += ', directories=no';
 	params += ', location=no';
 	params += ', menubar=yes';
 	params += ', resizable=no';
 	params += ', scrollbars=no';
 	params += ', status=no';
 	params += ', toolbar=no';
	if (containsMap=='True')
	{
		map.closeInfoWindow();
		resetCounter();
		if (restor_maximize == 1)
		{
			restoreForm();
			i++;
		}
	}
 	var content_vlue = document.getElementById(itemToPrint).innerHTML; 
	var docprint=window.open("","",params); 
	docprint.document.open(); 
	docprint.document.write('<html><head><title>Print</title>');	
	docprint.document.write('<link rel="stylesheet" type="text/css" href="styles/print.css"/>'); 
	docprint.document.write('<!--[if IE]><link href="styles/styleIE.css" rel="stylesheet" type="text/css"/><![endif]-->');
	docprint.document.write('</head><body onLoad="self.print()">');	
	if(containsMap=='True')
		docprint.document.write('<div id="map">');
	docprint.document.write(content_vlue); 
	if(containsMap=='True')
		docprint.document.write('</div>');
	docprint.document.write('</body></html>'); 
	docprint.document.close(); 
	docprint.focus();
	if (i != 0)
		maximizeForm();
}
