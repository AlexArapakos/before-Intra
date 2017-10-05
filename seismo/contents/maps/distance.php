-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
	<tr>
	  <td align="left">&nbsp;Distance - Based</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

<?php 
require_once("../dbQueries/minMaxMag.php");
$minMag=getMinMag();
if($minMag=="error") 
	die ('<div class="err">Error: Could not get minimum magnitude value.</div>');
$maxMag=getMaxMag();
if($maxMag=="error") 
	die ('<div class="err">Error: Could not get maximum magnitude value.</div>');

if (isset($_POST["lat"]))	
	$DLat=$_POST["lat"];
else
	$DLat=$_POST["maplat"];
if (isset($_POST["lon"]))	
	$DLon=$_POST["lon"];
else
	$DLon=$_POST["maplon"];
?>

  <table align="center" border="0" cellpadding="0" cellspacing="5" width="500">
	<tr>
	  <td align="center" colspan="4">Find all quakes of magnitude greater than:</td>
	</tr>
	<tr>
	  <td align="center" colspan="4">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="mag" id="mag" value="5" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('mag', 5,<?php echo $maxMag; ?>,<?php echo $minMag; ?>,2);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('mag',0.1,<?php echo $maxMag; ?>,2,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('mag',0.1,<?php echo $minMag; ?>,2,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center" colspan="4">and a maximum distance (km):</td>
	</tr>
	<tr>
	  <td align="center" colspan="4">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="dist" id="dist" value="100" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dist', 100,1000,1,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('dist',1,1000,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('dist',1,1,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center" colspan="4">from the point</td>
	</tr>
	<tr>
	  <td align="right">Latitude:</td>
	  <td align="center">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="lat" id="lat" value="<?php echo $DLat; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('lat', <?php echo $DLat; ?>,90,-90,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('lat',1,90,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('lat',1,-90,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="right">Longitude:</td>
	  <td align="center">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="lon" id="lon" value="<?php echo $DLon; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('lon', <?php echo $DLon; ?>,180,-180,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('lon',1,180,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('lon',1,-180,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr><td colspan="4"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td align="right" colspan="2"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadDistance()" type="button"/></td>
	  <td align="left" colspan="2"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>
