var spinTimer;

function checkValue(controlName, defaultValue, maxValue, minValue,decimalPlaces)
{
	var control= document.getElementById(controlName);
	var anum=/(^-?\d+$)|(^-?\d+\.\d+$)/;
	if (anum.test(control.value))
	{
		if( parseFloat(control.value)>maxValue)
			control.value=maxValue.toFixed(decimalPlaces);
		else if ( parseFloat(control.value)<minValue)
			control.value=minValue.toFixed(decimalPlaces);
		else
			control.value=parseFloat(control.value).toFixed(decimalPlaces);
	}
	else
		control.value = defaultValue.toFixed(decimalPlaces);	
}

function stopSpin()
{
	clearTimeout(spinTimer);	
}

function add(controlName, addValue, maxValue, decimalPlaces,timeout)
{
	var spinButton = document.getElementById(controlName);
	var spinButtonValue = parseFloat(spinButton.value);
	
	if(maxValue >= spinButtonValue + addValue)
		spinButton.value = (spinButtonValue + addValue).toFixed(decimalPlaces);
	else
		spinButton.value = maxValue.toFixed(decimalPlaces);
	
	var newTimeout=(timeout>100)?timeout-50:50;
		
	spinTimer = setTimeout("add('"+controlName+"',"+addValue+","+maxValue+","+decimalPlaces+","+newTimeout+")",newTimeout);
}

function sub(controlName, subValue, minValue, decimalPlaces,timeout)
{
	var spinButton = document.getElementById(controlName);
	var spinButtonValue = parseFloat(spinButton.value);
	
	if(minValue <= spinButtonValue - subValue)
		spinButton.value =(spinButtonValue - subValue).toFixed(decimalPlaces);
	else
		spinButton.value = minValue.toFixed(decimalPlaces);
		
	var newTimeout=(timeout>100)?timeout-50:50;
		
	spinTimer = setTimeout("sub('"+controlName+"',"+subValue+","+minValue+","+decimalPlaces+","+newTimeout+")",newTimeout);
}
