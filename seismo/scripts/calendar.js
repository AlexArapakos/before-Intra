function setDays(day,month,year) 
{
	var y = document.getElementById(year).options[document.getElementById(year).selectedIndex].value;
  	var m = document.getElementById(month).selectedIndex;
  	var days;
  
  	if ( (m == 3) || (m == 5) || (m == 8) || (m == 10) ) 
	{
    	days = 30;
  	}
  	else if (m == 1) 
	{
    	if ( (Math.floor(y/4) == (y/4)) && ((Math.floor(y/100) != (y/100)) || (Math.floor(y/400) == (y/400))) )
      		days = 29
    	else
      		days = 28
  	}
  	else 
	{
  		days = 31;
  	}
	
  	if (days > document.getElementById(day).length) 
	{
    	for (i = document.getElementById(day).length; i < days; i++) 
		{
      		document.getElementById(day).length = days;
      		document.getElementById(day).options[i].text = i + 1;
      		document.getElementById(day).options[i].value = i + 1;
    	}
  	}
  
  	if (days < document.getElementById(day).length) 
	{
    	document.getElementById(day).length = days;
    	if (document.getElementById(day).selectedIndex == -1) 
      		document.getElementById(day).selectedIndex = days - 1;
  	}
}
