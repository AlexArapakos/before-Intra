<?php

require_once("contents/functions/countUsers.php");
$usersCount=getOnlineUsers();
if($usersCount>1)
	echo '<br/>'.$usersCount." users are currently on line.";
else
	echo '<br/>'.$usersCount." user is currently on line.";

?>

<form method="POST" action="SeismoSurfer.php">
  <table align="center" border="0" cellpadding="0" cellspacing="3">
	<tr>
	  <td align="center"><br/><input name="logout" id="logout" value="Logout" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" type="submit"/><br/><br/></td>
	</tr>
  </table>
</form>
<!--IE Fix -->
&nbsp;