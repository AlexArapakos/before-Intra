-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
	<tr>
	  <td align="left">&nbsp;Select sites</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">

<?php
require_once("../dbQueries/minMaxPopulation.php");
$minPop=getMinPop();
if($minPop=="error") 
	die ('<div class="err">Error: Could not get minimum depth value.</div>');
$maxPop=getMaxPop();
if($maxPop=="error") 
	die ('<div class="err">Error: Could not get maximum depth value.</div>');
?>
	
  <table align="center" border="0" cellpadding="0" cellspacing="5" width="350">
	<tr>
	  <td align="left" colspan="4">Select sites with population</td>
	</tr>
	<tr>
	  <td align="center" width="50">between</td>
	  <td align="center" width="100">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input name="minPop" id="minPop" value="<?php echo $minPop; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('minPop', <?php echo $minPop; ?>,<?php echo $maxPop; ?>,<?php echo $minPop; ?>,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('minPop',1,<?php echo $maxPop; ?>,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('minPop',1,<?php echo $minPop; ?>,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	  <td align="center" width="50">and</td>
	  <td align="center" width="100">
		<table border="0" cellpadding="0" cellspacing="0" height="20">
		  <tr>
			<td rowspan="2" width="50"><input name="maxPop" id="maxPop" value="<?php echo $maxPop; ?>" maxlength="10" onfocus="this.className='textBoxNormalSelected'" onblur="checkValue('maxPop', <?php echo $maxPop; ?>,<?php echo $maxPop; ?>,<?php echo $minPop; ?>,0);this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
			<td><a href="#" onmousedown="add('maxPop',1,<?php echo $maxPop; ?>,0,500)" onmouseup="stopSpin()" class="upArrowNormal" onfocus="this.className='upArrowPressed'" onblur="this.className='upArrowNormal'" onmouseover="this.className='upArrowHover'" onmouseout="stopSpin();this.className='upArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		  <tr>
			<td><a href="#" onmousedown="sub('maxPop',1,<?php echo $minPop; ?>,0,500)" onmouseup="stopSpin()" class="downArrowNormal" onfocus="this.className='downArrowPressed'" onblur="this.className='downArrowNormal'" onmouseover="this.className='downArrowHover'" onmouseout="stopSpin();this.className='downArrowNormal'">&nbsp;&nbsp;&nbsp;&nbsp;</a></td>
		  </tr>
		</table>
	  </td>
	</tr>
	<tr><td colspan="4"><hr color='#356AA0'/></td></tr>
	<tr>
	  <td align="center" colspan="2"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadSites()" type="button"/></td>
	  <td align="center" colspan="2"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>
