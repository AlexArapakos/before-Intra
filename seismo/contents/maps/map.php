-->
<div id="maxRestoreDiv">
<div class="title">
  <table id="maxRestoreBar" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	  <td width="14%" align="left">
		<?php
		session_start();
		if(($_SESSION['userEmail']) && ($_SESSION['userName']) && ($_SESSION['userRole']))
		  echo '<a href="#" onclick="ClickHereToPrint(\'map\',\'True\')">&nbsp;<img alt="Print map" title="Print map" src="img/print.gif"/></a>';
		?>
	  </td>
	  <td align="center">Map</td>
	  <td align="right" width="14%">
		<?php 
		if(($_SESSION['userEmail']) && ($_SESSION['userName']) && ($_SESSION['userRole']))
		  echo '<div class="smallText" id="maxRestore">[<a href="#" onclick="maximizeForm()">Maximize</a>]&nbsp;</div>';
		?>
	  </td>
	</tr>
  </table>
</div>
</div>

<div class="roundRightContent">
  <table align="center" border="0" cellpadding="0" cellspacing="5" id="roundRightContentBar" width="100%">
	<tr>
	  <td align="right" width="16%" rowspan=2 valign="middle">Top 5 events of the:&nbsp;&nbsp;</td>
	  <td align="left" width="20%" rowspan=2 valign="middle">
		<a href="#" onclick="loadTopEvents('day')" id="day">day</a>&nbsp;
		<a href="#" onclick="loadTopEvents('week')" id="week">week</a>&nbsp;
		<a href="#" onclick="loadTopEvents('month')" id="month">month</a>&nbsp;
		<a href="#" onclick="loadTopEvents('year')" id="year">year</a>
	  </td>
	  <td align="right" width="5%">Magnitude:</td>
	  <td align="left" width="31%">
		<img height=22 width=14 alt="Marker A" title="Marker A" src="img/markerA.png"/>>7,&nbsp;
		<img height=22 width=14 alt="Marker B" title="Marker B" src="img/markerB.png"/>: 6-7,&nbsp;
		<img height=22 width=14 alt="Marker C" title="Marker C" src="img/markerC.png"/>: 5-6,&nbsp;
		<img height=22 width=14 alt="Marker D" title="Marker D" src="img/markerD.png"/>: 4-5,&nbsp;
		<img height=22 width=14 alt="Marker E" title="Marker E" src="img/markerE.png"/><4.
	  </td>
	  <td align="right" width="5%" rowspan=2 valign="middle">Source:&nbsp;&nbsp;</td>
	  <td align="left" width="14%" rowspan=2 valign="middle"><select name="source" id="source" class="mediumSelect">
		<option value="GI-NOA">GI-NOA</option>
		<option value="NEIC">NEIC</option>
	  </select></td>
	</tr>
	<tr>
	  <td align="right">Intensity:</td>
	  <td align="left">
		<img alt="Red Marker" title="Red Marker" src="img/macroRed.png"/>>7,&nbsp;
		<img alt="Yellow Marker" title="Yellow Marker" src="img/macroYellow.png"/>: 6-7,&nbsp;
		<img alt="Blue Marker" title="Blue Marker" src="img/macroBlue.png"/>: 5-6,&nbsp;
		<img alt="Green Marker" title="Green Marker" src="img/macroGreen.png"/>: 4-5,&nbsp;
		<img alt="White Marker" title="White Marker" src="img/macroWhite.png"/><4.
	  </td>
	</tr>
  </table>
  <table align="center" border="0" width="100%">
	<tr>
		<td align="left"><?php require_once("topMapMenu.php"); ?></td>
	</tr>
  </table>
</div>