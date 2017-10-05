<?php
require_once("../functions/showError.php");
function forgotPasswordForm($email,$errorString)
{
?>
-->
<div class="title">Password Reminder</div>

<div class="roundRightContent">
  <p>Please enter your username below and we will email you your password.</p>
  <table border="0" cellpadding="0" align="center" cellspacing="3" width="300">

	<?php if($errorString!="") echo '<tr><td colspan="2"><div class="err">'.$errorString.'</div></td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Email:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $email; ?>" maxlength="100" name="email" id="email" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) retrieve();"/></td>
	</tr>
	<tr>
	  <td></td>
	  <td align="center"><input name="retrieve" value="Retrieve" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="retrieve()" type="button"/></td>
	</tr>
  </table><br/><br/>
</div>

<?php
}
?>