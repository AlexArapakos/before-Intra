-->
<?php
	session_start();
	$temp=$_SESSION['userEmail'];
	echo '<input name="userName" id="userName" type="hidden" value="'.$temp.'"/>';
?>

<div class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="350">
	<tr>
	  <td align="left">&nbsp;Save Position</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div class="squareContent">
  <form>
	<table align="center" border="0" cellpadding="0" cellspacing="5" width="300">
	  <tr>
		<td align="left"><input type="radio" name="positionRadio" id="newPosition"  checked="checked" onclick="hideShowSavePosition()"/>New position</td>
		<td align="left"><input type="radio" name="positionRadio" id="replacePosition" onclick="hideShowSavePosition()"/>Replace position</td>
	  </tr>
	  <tr>
		<td align="right" width="150"><input value="" maxlength="30" name="newPositionName" id="newPositionName" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text"/></td>
		<td align="left" width="150">

		<?php
		require_once("../dbQueries/getUsersPositions.php");
		$pos=getCurrentUserPositions($temp);
		
		if ($pos) 
		{
			echo '<select name="replacePositionName" id="replacePositionName" class="largeSelect" style="visibility:hidden;">';
			foreach ($pos as $positionName => $value) 
			{
				echo '<option value="'.$value.'">'.$value.'</option>';        
			}
			echo '</select>';
		}
		else
		{
			echo '<b class="err" name="replacePositionName" id="replacePositionName" style="visibility:hidden;">No positions found</b>';
		}
		?>
		
		</td>
	  </tr>
	  <tr>
		<td align="center"><input name="savePosition" id="savePosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="saveCurrentPosition()" type="button"/></td>
		<td align="center"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	  </tr>
	  <tr>
		<td align="left" colspan="2"><div id="boxStatusBar"></div></td>
	  </tr>
	</table>
  </form>
</div>
