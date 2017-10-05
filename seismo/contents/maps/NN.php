-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
	<tr>
	  <td align="left">&nbsp;Nearest Neighbour</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

<?php 
if (isset($_POST["lat"]))	
	$NNLat=$_POST["lat"];
else
	$NNLat=$_POST["maplat"];
if (isset($_POST["lon"]))	
	$NNLon=$_POST["lon"];
else
	$NNLon=$_POST["maplon"];
?>

  <table align="center" border="0" cellpadding="0" cellspacing="5" width="500">
	<tr>
	  <td align="center" colspan="4">Point to find its Nearest Neighbors</td>
	</tr>
	<tr>
	  <td align="right">Latitude:</td>
	  <td align="center">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="lat" id="lat" value="<?php echo $NNLat; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('lat', <?php echo $NNLat; ?>,90,-90,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
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
			<td rowspan="2" width="50"><input style="text-align:right;" name="lon" id="lon" value="<?php echo $NNLon; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('lon', <?php echo $NNLon; ?>,180,-180,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('lon',1,180,5,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('lon',1,-180,5,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center" colspan="4">Number of NN to retrieve:</td>
	</tr>
	<tr>
	  <td align="center" colspan="4">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="nNumber" id="nNumber" value="10" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('nNumber', 10,1000,1,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('nNumber',1,1000,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('nNumber',1,1,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr>
	  <td align="center" colspan="4">Filter results by magnitude greater than:</td>
	</tr>
	<tr>
	  <td align="center" colspan="4">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input style="text-align:right;" name="mag" id="mag" value="5" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('mag', 5,7.5,0,2);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('mag',0.10,7.5,2,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('mag',0.10,0,2,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr><td colspan="4"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td align="right" colspan="2"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadNN()" type="button"/></td>
	  <td align="left" colspan="2"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>