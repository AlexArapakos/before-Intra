-->
<div class="squareTitle">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="400">
	<tr>
	  <td align="left">&nbsp;Warehouse</td>
	  <td align="right"><div class="smallText">[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td>
	</tr>
  </table>
</div>

<div class="squareContent">
<form method="post" action="http://195.251.230.57:8988/SeismoWarehouse-Project2-context-root/SeismoAnalysis.jsp" target="_blank">
<input type="hidden" name="authority" id="authority" value="yes" />
  <table align="center" border="0" cellpadding="0" cellspacing="5" width="350">
	<tr>
	  <td colspan="3" align="left">Are you sure you want to continue to see and navigate into the Data Warehouse?</td>
	</tr>
	<tr>
	  <td colspan="3" align="center" height=10%>&nbsp;</td>
	</tr>
	<tr>
	  <td align="right" width="40%"><input name="closeBox" id="closeBox" value="Yes" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="submit();hideForm()" type="button"/></td>
	  <td align="center" width="20%">&nbsp;</td>
	  <td align="left" width="40%"><input name="closeBox" id="closeBox" value="No" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="hideForm()" type="button"/></td>
	</tr>
  </table>
</form>
</div>
	