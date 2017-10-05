-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="480">
	<tr>
	  <td align="left">&nbsp;Top-N</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

<?php 
if ((isset($_POST["minlat"])) && (isset($_POST["maxlat"])) && (isset($_POST["minlon"])) && (isset($_POST["maxlon"])))
{
	$minLat=$_POST["minlat"];
	$maxLat=$_POST["maxlat"];
	$minLon=$_POST["minlon"];
	$maxLon=$_POST["maxlon"];
}
else
{
	if (($_POST["zoom"]==0) || ($_POST["zoom"]==1))
	{
		$minLat='-90';
		$maxLat='90';
		$minLon='-180';
		$maxLon='180';
		$modLat = 0;
		$modLon = 0;
	}
	else if ($_POST["zoom"]==2)
	{
		$modLat = 64;
		$modLon = 128;
	}
	else if ($_POST["zoom"]==3)
	{
		$modLat = 32;
		$modLon = 64;
	}
	else if ($_POST["zoom"]==4)
	{
		$modLat = 16;
		$modLon = 32;
	}
	else if ($_POST["zoom"]==5)
	{
		$modLat = 8;
		$modLon = 16;
	}
	else if ($_POST["zoom"]==6)
	{
		$modLat = 4;
		$modLon = 8;
	}
	else if ($_POST["zoom"]==7)
	{
		$modLat = 2;
		$modLon = 4;
	}
	else if ($_POST["zoom"]==8)
	{
		$modLat = 1;
		$modLon = 2;
	}
	else if ($_POST["zoom"]==9)
	{
		$modLat = 0.5;
		$modLon = 1;
	}
	else if ($_POST["zoom"]==10)
	{
		$modLat = 0.25;
		$modLon = 0.5;
	}
	else if ($_POST["zoom"]==11)
	{
		$modLat = 0.125;
		$modLon = 0.25;
	}
	else if ($_POST["zoom"]==12)
	{
		$modLat = 0.0625;
		$modLon = 0.125;
	}
	else if ($_POST["zoom"]==13)
	{
		$modLat = 0.03125;
		$modLon = 0.0625;
	}
	else if ($_POST["zoom"]==14)
	{
		$modLat = 0.015625;
		$modLon = 0.03125;
	}
	else if ($_POST["zoom"]==15)
	{
		$modLat = 0.0078125;
		$modLon = 0.015625;
	}
	else if ($_POST["zoom"]==16)
	{
		$modLat = 0.00390625;
		$modLon = 0.0078125;
	}
	else if ($_POST["zoom"]==17)
	{
		$modLat = 0.001953125;
		$modLon = 0.00390625;
	}
	else if ($_POST["zoom"]==18)
	{
		$modLat = 0.0009765625;
		$modLon = 0.001953125;
	}
	else if ($_POST["zoom"]==19)
	{
		$modLat = 0.00048828125;
		$modLon = 0.0009765625;
	}
	
	$minLat = $_POST["maplat"] - $modLat;
	$maxLat = $_POST["maplat"] + $modLat;
	$minLon = $_POST["maplon"] - $modLon;
	$maxLon = $_POST["maplon"] + $modLon;
}
?>

  <table align="center" border="0" cellpadding="0" cellspacing="5" width="430">
	<tr>
	  <td align="right" colspan="2">Find the&nbsp;&nbsp;</td>
	  <td align="left" colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="topN" id="topN" value="10" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('topN', 10,1000,1,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('topN',1,1000,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('topN',1,1,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center" colspan="5">most&nbsp;&nbsp;&nbsp;&nbsp;
		<select name="quakeType" id="quakeType" class="mediumSelect">
		  <option value="0">strong</option>
		  <option value="1">weak</option>
		  <option value="2">deep</option>
		  <option value="3">shallow</option>
		  <option value="4">recent</option>
		  <option value="5">old</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;earthquakes
	  </td>
	</tr>
	<tr>
	  <td align="center"><b>Area</b></td>
	  <td align="center" colspan="2"><b>From</b></td>
	  <td align="center" colspan="2"><b>To</b></td>
	</tr>
	<tr>
	  <td align="center">Latitude</td>
	  <td align="center" colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="minLat" id="minLat" value="<?php echo $minLat; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minLat', <?php echo $minLat; ?>,90,-90,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('minLat',1,90,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('minLat',1,-90,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="center" colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="maxLat" id="maxLat" value="<?php echo $maxLat; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxLat', <?php echo $maxLat; ?>,90,-90,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('maxLat',1,90,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('maxLat',1,-90,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center">Longtitude</td>
	  <td align="center" colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="minLon" id="minLon" value="<?php echo $minLon; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minLon', <?php echo $minLon; ?>,180,-180,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('minLon',1,180,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('minLon',1,-180,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="center" colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="maxLon" id="maxLon" value="<?php echo $maxLon; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxLon', <?php echo $maxLon; ?>,180,-180,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('maxLon',1,180,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('maxLon',1,-180,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr><td colspan="5"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td align="right" colspan="2"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadTopN()" type="button"/></td>
	  <td></td>
	  <td align="left" colspan="2"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>
