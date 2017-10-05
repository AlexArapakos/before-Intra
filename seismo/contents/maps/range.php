-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="570">
	<tr>
	  <td align="left">&nbsp;Range</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

<?php 
require_once("../dbQueries/minMaxDepth.php");
$minDepth=getMinDepth();
if($minDepth=="error") 
	die ('<div class="err">Error: Could not get minimum depth value.</div>');
$maxDepth=getMaxDepth();
if($maxDepth=="error") 
	die ('<div class="err">Error: Could not get maximum depth value.</div>');
require_once("../dbQueries/minMaxMag.php");
$minMag=getMinMag();
if($minMag=="error") 
	die ('<div class="err">Error: Could not get minimum magnitude value.</div>');
$maxMag=getMaxMag();
if($maxMag=="error") 
	die ('<div class="err">Error: Could not get maximum magnitude value.</div>');
require_once("../dbQueries/minMaxTime.php");
$minTime=getMinTime();
if($minTime=="error") 
	die ('<div class="err">Error: Could not get minimum time value.</div>');
list($minDay, $minMonth, $minYear) = split('[/]', $minTime);
$currentDate=getdate();	

if ( ($currentDate[mon] == 4) || ($currentDate[mon] == 6) || ($currentDate[mon] == 9) || ($currentDate[mon] == 11) ) 
   	$days = 30;
else if ($currentDate[mon] == 2) 
{
	$days = 28;
	if ( (($currentDate[year]%4) == 0) && ( (($currentDate[year]%100) != 0) || (($currentDate[year]%400) == 0)) )
   		$days = 29;
}
else
	$days = 31;

if ( ($minMonth == 4) || ($minMonth == 6) || ($minMonth == 9) || ($minMonth == 11) )
   	$days1 = 30;
else if ($minMonth == 2) 
{
	$days1 = 28;
   	if ( (($minYear%4) == 0) && ( (($minYear%100) != 0) || (($minYear%400) == 0)) )
		$days1 = 29;
}
else
	$days1 = 31;

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

  <table align="center" border="0" cellpadding="0" cellspacing="5" width="520" >
	<tr>
	  <td align="left"><b>Activated&nbsp;&nbsp;</b></td>
	  <td align="left"><b>Filters</b></td>
	  <td align="left" colspan="3"><b>From</b></td>
	  <td align="left" colspan="3"><b>To</b></td>
	</tr>
	<tr>
	  <td align="center"><input type="checkbox" name ="mag" id="mag" checked /></td>
	  <td align="left">Magnitude</td>
	  <td align="left" colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="minMag" id="minMag" value="<?php echo $minMag; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minMag', <?php echo $minMag; ?>,<?php echo $maxMag; ?>,<?php echo $minMag; ?>,2);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('minMag',0.10,<?php echo $maxMag; ?>,2,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('minMag',0.10,<?php echo $minMag; ?>,2,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="left" colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="maxMag" id="maxMag" value="<?php echo $maxMag; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxMag', <?php echo $maxMag; ?>,<?php echo $maxMag; ?>,<?php echo $minMag; ?>,2);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('maxMag',0.10,<?php echo $maxMag; ?>,2,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('maxMag',0.10,<?php echo $minMag; ?>,2,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center"><input type="checkbox" name ="depth" id="depth" checked /></td>
	  <td align="left">Depth</td>
	  <td align="left" colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="minDepth" id="minDepth" value="0" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minDepth', 0,<?php echo $maxDepth; ?>,0,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('minDepth',1,<?php echo $maxDepth; ?>,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('minDepth',1,0,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="left" colspan="3">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="maxDepth" id="maxDepth" value="<?php echo $maxDepth; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxDepth', <?php echo $maxDepth; ?>,<?php echo $maxDepth; ?>,0,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('maxDepth',1,<?php echo $maxDepth; ?>,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('maxDepth',1,0,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center"><input type="checkbox" name ="lat" checked disabled /></td>
	  <td align="left">Latitude</td>
	  <td align="left" colspan="3">
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
	  <td align="left" colspan="3">
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
	  <td align="center"><input type="checkbox" name ="lon" checked disabled /></td>
	  <td align="left">Longitude</td>
	  <td align="left" colspan="3">
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
	  <td align="left" colspan="3">
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
	<tr>
	  <td align="center"><input type="checkbox" name ="time" id="time" checked /></td>
	  <td align="left">Time</td>
	  <td align="center">
		<select name="yearFrom" id="yearFrom" class="mediumSelected" onChange="setDays('dayFrom','monthFrom','yearFrom')">
		<option value="<?php echo $minYear; ?>" selected="selected"><?php echo $minYear; ?></option>
		
		<?php 	
		for ($i=$minYear+1; $i<$currentDate[year]+1; $i++)
		{
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>
		
		</select>
	  </td>
	  <td align="center">
		<select name="monthFrom" id="monthFrom" class="smallSelect" onChange="setDays('dayFrom','monthFrom','yearFrom')">
		
		<?php 
		for($i=1; $i<13; $i++)
		{
		  if($i==$minMonth)
			echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
		  else
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>

		</select>
	  </td>
	  <td align="center">
		<select name="dayFrom" id="dayFrom" class="smallSelect" onChange="setDays('dayFrom','monthFrom','yearFrom')">
		
		<?php 
		for($i=1; $i<$days1+1; $i++)
		{
		  if($i==$minDay)
			echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
		  else
			echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>

		</select>
	  </td>
	  <td align="center">
		<select name="yearTo" id="yearTo" class="mediumSelected" onChange="setDays('dayTo','monthTo','yearTo')">

		<?php
		for ($i=$minYear; $i<$currentDate[year]+1; $i++)
		{
			if($i==$currentDate[year])
				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			else
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>

		</select>
	  </td>
	  <td align="center">
		<select name="monthTo" id="monthTo" class="smallSelect" onChange="setDays('dayTo','monthTo','yearTo')">

		<?php
		for($i=1; $i<13; $i++)
		{
			if($i==$currentDate[mon])	
				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			else
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?>

		</select>
	  </td>
	  <td align="center">
		<select name="dayTo" id="dayTo" class="smallSelect" onChange="setDays('dayTo','monthTo','yearTo')">

		<?php
		for($i=1; $i<$days+1; $i++)
		{
			if($i==$currentDate[mday])	
				echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			else
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
		?> 
		
		</select>
	  </td>
	</tr>
	<tr><td colspan="8"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td colspan="2"></td>
	  <td align="center" colspan="2"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadRange()" type="button"/></td>
	  <td align="left" colspan="4"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>