-->
<div class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="480">
	<tr>
	  <td align="left">&nbsp;Coordinates</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div class="squareContent">
  <form>
	<table align="center" border="0" cellpadding="0" cellspacing="5" width="450">
	  <tr>
		<td align="right" width="150">Coordinates type:</td>
		<td align="left" width="150">
		  <select name="coordinateType" id="coordinateType" class="mediumSelect" onchange="showCoordinatesType()">
			<option value="1">Dec Deg</option>
			<option value="2">DMS</option>
			<option value="3">UTM</option>
			<option value="4">MGRS</option>       
		  </select>
		</td>
	  </tr>
	  <tr>
		<td colspan="2">
		  <table id="decDeg" align="center" border="0" cellpadding="0" cellspacing="5" width="300">
		    <tr>
			  <td align="right" width="150">Latitude:</td>
			  <td align="left" width="150"><input value="0.00000" maxlength="20" name="decDegLat" id="decDegLat" onfocus="this.className='textBoxLargeSelected'" onblur="checkValue('decDegLat',38,90,-90,5);this.className='textBoxLarge'" class="textBoxLarge" type="text" this.className="'textBoxSmallNormal'"/></td>
			</tr>
			<tr>
			  <td align="right" width="150">Longitude:</td>
			  <td align="left" width="150"><input value="0.00000" maxlength="20" name="decDegLong" id="decDegLong" onfocus="this.className='textBoxLargeSelected'" onblur="checkValue('decDegLong',25,180,-180,5);this.className='textBoxLarge'" class="textBoxLarge" type="text"/></td>
			</tr>
		  </table>
		  <table id="dms" align="center" border="0" cellpadding="0" cellspacing="5" width="440" style="display:none;">
			<tr>
			  <td align="center" colspan="2" width="200">Degrees</td>
			  <td align="center" width="120">Minutes</td>
			  <td align="center" width="120">Seconds</td>
			</tr>
			<tr>
			  <td align="right" width="80">Latitude:</td>
			  <td align="left" width="120"><input value="0.00000" maxlength="20" name="dmsLatDec" id="dmsLatDec" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLatDec',38,90,-90,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			  <td align="left" width="120"><input value="0" maxlength="20" name="dmsLatMin" id="dmsLatMin" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLatMin',0,59,0,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			  <td align="left" width="120"><input value="0" maxlength="20" name="dmsLatSec" id="dmsLatSec" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLatSec',0,60,0,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			</tr>
			<tr>
			  <td align="right" width="80">Longtitude:</td>
			  <td align="left" width="120"><input value="0.00000" maxlength="20" name="dmsLongDec" id="dmsLongDec" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLongDec',25,180,-180,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			  <td align="left" width="120"><input value="0" maxlength="20" name="dmsLongMin" id="dmsLongMin" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLongMin',0,59,0,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			  <td align="left" width="120"><input value="0" maxlength="20" name="dmsLongSec" id="dmsLongSec" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('dmsLongSec',0,60,0,5);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			</tr>
		  </table>
		  <table id="utm" align="center" border="0" cellpadding="0" cellspacing="5" width="440" style="display:none;">
			<tr>
			  <td align="right" colspan="2" width="150">Zone Number</td>
			  <td align="center" width="50">Hemisphere</td>
			  <td align="center" width="120">Easting</td>
			  <td align="center" width="120">Northing</td>
			</tr>
			<tr>
			  <td align="right" width="100">UTM:</td>
			  <td align="right" width="50"><input value="" maxlength="20" name="utmZone" id="utmZone" onfocus="this.className='textBoxSmallSelected'" onblur="this.className='textBoxSmall'" class="textBoxSmall" type="text"/></td>
			  <td align="center" width="50">
				<select name="utmHem" id="utmHem" class="smallSelect">
				  <option value="N">N</option>
				  <option value="S">S</option>
				</select>
			  </td>
			  <td align="left" width="120"><input value="" maxlength="20" name="utmEast" id="utmEast" onfocus="this.className='textBoxNormalSelected'" onblur="this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			  <td align="left" width="120"><input value="" maxlength="20" name="utmNor" id="utmNor" onfocus="this.className='textBoxNormalSelected'" onblur="this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			</tr>
		  </table>
		  <table id="mgrs" align="center" border="0" cellpadding="0" cellspacing="5" width="300" style="display:none;">
			<tr>
			  <td align="right" width="150">MGRS:</td>
			  <td align="right" width="150"><input value="" maxlength="20" name="mgrsVal" id="mgrsVal" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text"/></td>
			</tr>
		  </table>
		  <table align="center" border="0" cellpadding="0" cellspacing="5" width="300">
		    <tr>
			  <td align="right" width="150">Zoom Level:</td>
			  <td align="left" width="150">
				<select name="zoomVal" id="zoomVal" class="smallSelect">
				<?php 	
				for ($i=0; $i<18; $i++)
				{
					if($i==6)
						echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
					else
						echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
				</select>
			  </td>
			</tr>
		  </table>
		  <table align="center" border="0" cellpadding="0" cellspacing="5" width="300">
			<tr>
			  <td align="center"><input name="savePosition" id="savePosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="moveToCoordinates()" type="button"/></td>
			  <td align="center"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
			</tr>
		  </table>
		</td>
	  </tr>
	</table>
  </form>
</div>
	