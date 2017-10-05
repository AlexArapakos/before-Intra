<?php
	require_once("contents/functions/showError.php");
	require_once("contents/functions/countUsers.php");
	function showLoginForm($userName,$password,$remember,$errorArray)
	{
		$usersCount=getOnlineUsers();
		if($usersCount>1)
			echo '<br/>'.$usersCount." users are currently on line.";
		else
			echo '<br/>'.$usersCount." user is currently on line.";
?>

<form method="POST" action="SeismoSurfer.php">
  <table align="center" border="0" cellpadding="0" cellspacing="3">

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3"><div class="err"><b>There where some errors during your login.</b></div></td></tr>'; ?>

	<tr>
	  <td colspan="3" align="right"><div class="smallText">[E-mail Address]</div></td>
	</tr>
	<tr>
	  <td align="right"><strong>UserName:</strong></td>
	  <td align="left" width="120"><input value="<?php echo $userName; ?>" maxlength="100" name="nameLogin" id="nameLogin" onfocus="this.className='textBoxNormalSelected'" onblur="this.className='textBoxNormal'" class="textBoxNormal" type="text"/></td>
	</tr>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="2">'.showError($errorArray,'nameLogin').'</td></tr>'; ?>

	<tr>
	  <td colspan="3" align="right"><div class="smallText">[<a href="#" onclick="loadRightLeftContent('contents/users/forgotPassword.php','none','none',false)">Forgot Password?</a>]</div></td>
	</tr>
	<tr>
	  <td align="right"><strong>Password:</strong></td>
	  <td align="left"  width="120"><input value="<?php echo $password; ?>" maxlength="30" name="passLogin" id="passLogin" onfocus="this.className='textBoxNormalSelected'" onblur="this.className='textBoxNormal'" class="textBoxNormal" type="password"/></td>
	</tr>
	<tr>
	  <td colspan="2" align="center"><input type="checkbox" name="remindPassword" id="remindPassword" value="YES" <?php if ($remember=="YES") echo 'checked="checked"' ?>/>Remember Password</td>
	</tr>
	<tr>
	  <td colspan="2" align="right">
		<table align="center" border="0" cellpadding="0" cellspacing="3">
		  <tr>
			<td align="center"><input name="login" value="Login" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" type="submit"/></td>
			<td align="center"><input name="register" value="Register" onfocus="this.className='buttonPress'" onclick="loadRightLeftContent('contents/users/register.php','contents/users/registerMenu.php','none',false)" onblur="this.className='buttonNormal'" class="buttonNormal" type="button"/></td>
		  </tr>
		</table>
	  </td>
	</tr>
  </table>
</form>
<!--IE Fix -->
&nbsp; 
<?php
	}
?>
