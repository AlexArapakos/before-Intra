-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
	<tr>
	  <td align="left">&nbsp;Quake <?php $quake=$_GET["quake"]; echo $quake; ?></td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

  <table align="center" border="0" cellpadding="0" cellspacing="0" width="530">
	<tr>
	  <td align="center" colspan="2" height="30"><b>Macrosesmic data</b> for <b>quake&nbsp;<?php echo $quake; ?></b>&nbsp;are too many to be displayed.</td>
	</tr>
	<tr>
	  <td align="center" colspan="2">You can see the macrosesmic data for this quake</td>
	</tr>
	<tr align="center">
	  <td align="right" width="155">with <b>intensity</b> between</td>
	  <td align="left">
		<table id="between" width="310">
		  <tr>
			<td align="left">
			  <table border="0" cellpadding="0" cellspacing="0" height="20">
				<tr>
				  <td rowspan="2" width="50"><input style="text-align:right;" name="minIntensity" id="minIntensity" value="1" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minIntensity', 1, 9.5, 1, 1);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
				  <td><a href="#" onmousedown="add('minIntensity',0.5,9.5,1,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
				</tr>
				<tr>
				  <td><a href="#" onmousedown="sub('minIntensity',0.5,1,1,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
				</tr>
			  </table>
			</td>
			<td align="left">and</td>
			<td align="left">
			  <table border="0" cellpadding="0" cellspacing="0" height="20">
				<tr>
				  <td rowspan="2" width="50"><input style="text-align:right;" name="maxIntensity" id="maxIntensity" value="10" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxIntensity', 10, 10, 1.5, 1);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
				  <td><a href="#" onmousedown="add('maxIntensity',0.5,10,1,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
				</tr>
				<tr>
				  <td><a href="#" onmousedown="sub('maxIntensity',0.5,1.5,1,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
				</tr>
			  </table>
			</td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr><td colspan="2"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td align="right"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadMacroData(<?php echo $quake; ?>,1)" type="button"/></td>
	  <td align="center"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>