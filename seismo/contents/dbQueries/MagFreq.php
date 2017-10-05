-->
<div id="squareTitle" class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="50" align="left">

	    <?php 
	    session_start();
	    if(isset($_SESSION['userEmail']) && isset($_SESSION['userName']) && isset($_SESSION['userRole']))
	    {
	    ?>
		  <a href="#" onclick="ClickHereToPrint('MagFreqTable','False')"><img alt="Print table" title="Print table" src="img/print.gif"/></a>
		<?php
		}
        ?>
	  </td>
	  <td align="left">&nbsp;Magnitude Frequency</td>
	  <td width="50" align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div id="squareContent" class="squareContent">
  <div id="MagFreqTable">
	<table align="center" border="0" cellpadding="0" cellspacing="5">
	  <tr>
		<td><b>Show quakes&nbsp;&nbsp;</b></td>
		<td><b>Number of quakes&nbsp;&nbsp;</b></td>
		<td><b>Magnitude</b></td>
	  </tr>
	  
		<?php	
		if(!isset($_POST["source"]))
			die ('<tr><td colspan="2"><div class="err">Error: Could not get source value.</div></td></tr></table>');
		$source=$_POST["source"];
	
		require_once("../dbConnect.php");
		$dbConn=connectToDatabase();
		if($dbConn==false)
		{	
			die ('<tr><td colspan="2"><div class="err">Error: Could not connect to the database.</div></td></tr></table>');
		}
		else
		{
			$query = 'select count(quakeid), magnitude from quake_mag_catalog where source = :source group by magnitude ORDER BY magnitude DESC';

			$statement = oci_parse($dbConn, $query);
			if ($statement) 
			{
				oci_bind_by_name($statement,":source", $source,10,SQLT_CHR);
		
				$r = oci_execute($statement);
				if ($r) 
				{
					$macroCounter=0;
					while ($row = oci_fetch_array ($statement, OCI_BOTH)) 
					{
						echo '<tr><td align="center"><input type="checkbox" name ="mag['.$macroCounter.']" id="mag['.$macroCounter.']" value="'.$row[1].'"/></td>';
						echo '<td align="center">'.$row[0].'</td>';					
						echo '<td align="center">'.str_replace(",", ".", $row[1]).'</td></tr>';
						$macroCounter++;
					}
					echo '<tr><td><input type="hidden" name="counter" id="counter" value="'.$macroCounter.'"></td></tr>';
					oci_free_statement($statement);					
				}
				else
					die ('<tr><td colspan="5"><div class="err">Error: Could not get quake\'s macroseismic data.</div></td></tr></table>');
			}
			else
				die ('<tr><td colspan="5"><div class="err">Error: Could not get quake\'s macroseismic data.</div></td></tr></table>');
		}
		?>
		
	</table>
  </div>
  <table align="center" border="0" cellpadding="0" cellspacing="5">
	<tr>
	  <td align="center"><input name="sawQuakes" id="sawQuakes" value="Show" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="sawQuakeMagFreq()" type="button"/></td>
	  <td>&nbsp;</td>
	  <td align="center"><input name="closeBox" id="closeBox" value="Close" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</div>