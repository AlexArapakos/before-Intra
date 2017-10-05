-->
<div class="roundRightBorder">

  <b class="roundTop">
	<b class="roundBorderH1"></b>    
	<b class="roundBorderH2"></b>
	<b class="roundBorderH3"></b>
	<b class="roundBorderH4"></b>
  </b>
  
  <div id="rightContent" class="rightContent">
    <div id="rightTextContent"></div>
    <div class="mapContent" id="mapContent">
      <div id="map"></div><br/>
      <div id="statusBar">
		<table id="bar" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tr>
			<td align="left" width="45%"><div id="status"></div></td>
			<td align="center" width="26%"><div id="center">Center: (38, 25)</div></td>
			<td align="center" width="10%"><div id="zoom">Zoom: 6</div></td>
			<td align="center" width="19%"><input type="checkbox" name="measureDistance" id="measureDistance" onclick="enableMeasure()"/>Measure distance</td>
		  </tr>
		</table>
		<br/>
		<table id="measure" align="center" border="0" cellpadding="0" cellspacing="0" width="718">
		  <tr>
			<td align="right" width="130"><input name="resetCounters" value="Reset Counters" onfocus="this.className='buttonLargePress'" onclick="resetCounter()" onblur="this.className='buttonLarge'" class="buttonLarge" type="button"/></td>
			<td align="center" width="130"><input name="removeLastLeg" value="Remove last leg" onfocus="this.className='buttonLargePress'" onclick="removeLastLeg()" onblur="this.className='buttonLarge'" class="buttonLarge" type="button"/> </td>
			<td align="center" width="130"><select name="unit" id="unit" class="mediumSelect" onchange="setUnit()">
			  <option value="K">kilometers</option>
			  <option value="M">miles</option>
			</select></td>
			<td align="center" width="310"><div id="path">Length of path:-, Length of last leg:-</div></td>
		  </tr>
		</table>
	  </div><br/>
	</div>
  </div>

  <b class="roundBottom">
	<b class="roundBorder4"></b>
	<b class="roundBorder3"></b>
	<b class="roundBorder2"></b>
	<b class="roundBorder1"></b>
  </b>

</div>