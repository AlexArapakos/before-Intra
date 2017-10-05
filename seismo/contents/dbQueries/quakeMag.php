-->
<div id="squareTitle" class="squareTitle">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="550">
  <tr>
    <td align="left">&nbsp;Quake <?php $quakeID=$_POST["quakeID"]; echo $quakeID; ?></td>
    <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
  </tr>
</table>
</div>

<div id="squareContent" class="squareContent">

<table align="center" border="0" cellpadding="0" cellspacing="5" width="500">
  <tr>
    <td align="center"><b>Magnitude ID</b></td>
	<td align="center"><b>Magnitude</b></td>
	<td align="center"><b>Type</b></td>
	<td align="center"><b>Calculated</b></td>
	<td align="center"><b>Mag Agency</b></td>
  </tr>
  
<?php
	setlocale(LC_ALL,"En-Us");
	require_once("../dbConnect.php");
	$dbConn=connectToDatabase();
	if($dbConn==false)
	{	
		die ('<div class="err">Error: Could not connect to the database.</div>');
	}
	else
	{
		$query = 'SELECT magid, magnitude, magtype, calculated, mag_agency FROM mag_view m WHERE m.quakeid =:quakeID';

  		$statement = oci_parse($dbConn, $query);
  		if ($statement) 
		{
			oci_bind_by_name($statement,":quakeID", $quakeID);
		
      		$r = oci_execute($statement);
  			if ($r) 
			{
				$macroCounter=0;
    			while ($row = oci_fetch_array ($statement, OCI_BOTH)) 
				{
					$macroCounter++;
					echo '<tr><td align="center">'.$row[0].'</td>';
					echo '<td align="center">'.str_replace(",", ".",$row[1]).'</td>';
					echo '<td align="center">'.$row[2].'</td>';	
					if ($row[3]==0)	
						echo '<td align="center">False</td>';
					else
						echo '<td align="center">True</td>';
					if (!empty($row[4]))
						echo '<td align="center">'.$row[4].'</td></tr>';
					else
						echo '<td align="center">Uknown</td></tr>';									
				}
				oci_free_statement($statement);
				if(	$macroCounter==0)
					echo '<tr><td colspan="5">There is no macroseismic data for this quake.</td></tr>'; 	
			}
			else
				die ('<tr><td colspan="5"><div class="err">Error: Could not get quake\'s macroseismic data.</div></td></tr>');
		}
		else
			die ('<tr><td colspan="5"><div class="err">Error: Could not get quake\'s macroseismic data.</div></td></tr>');
	}
?>

  <tr><td align="center" colspan="5">&nbsp;&nbsp;</td></tr>
  <tr>
    <td align="center" colspan="5"><input name="closeBox" id="closeBox" value="Close" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"></td>
  </tr>
</table>

</div>