-->

<?php
	session_start();
	$temp=$_SESSION['userEmail'];
	echo '<input name="userName" id="userName" type="hidden" value="'.$temp.'"/>';
?>

<div class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="350">
	<tr>
	  <td align="left">&nbsp;Load position</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div class="squareContent">
  <form>
	<table align="center" border="0" cellpadding="0" cellspacing="5" width="300">
	  <tr>
		<td align="right" width="150">Select position:</td>
		<td align="left" width="150">

		<?php
		require_once("../dbQueries/getUsersPositions.php");
		$pos=getCurrentUserPositions($temp);
		
		if ($pos)
		{
			echo '<select name="loadPositionName" id="loadPositionName" class="largeSelect">';
			foreach ($pos as $positionName => $value) 
			{
				echo '<option value="'.$value.'">'.$value.'</option>';        
			}
			echo '</select>';
		}
		else
		{
			echo '<b class="err" name="loadPositionName" id="loadPositionName">No positions found</b>';
		}
		?>
		
		</td>
	  </tr>
	  <tr>
		<td align="center"><input name="savePosition" id="loadPosition" value="OK" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="loadSelectedPosition()" type="button"/></td>
		<td align="center"><input name="closeBox" id="closeBox" value="Cancel" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	  </tr>
	  <tr>
		<td align="left" colspan="2"><div id="boxStatusBar"></div></td>
	  </tr>
	</table>
  </form>
</div>
