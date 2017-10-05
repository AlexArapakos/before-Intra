<?php
	require_once("../functions/showError.php");
	function showRegistrationForm($nickName,$email,$password,$passwordConfirm,$firstName,$lastName,$country,$city,$errorArray,$dbConn)
	{
?>	

-->
<div class="title">Registration</div>

<div class="roundRightContent">
  <p>Please fill the fields below with your data. The fields with an asterisk are required.</p>
  <table border="0" cellpadding="0" align="center" cellspacing="3" width="300">

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3"><div class="err"><b>There where some errors during your registration.</b></div></td></tr>' ?>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3">'.showError($errorArray,'nickName').'</td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Nickname:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $nickName; ?>" maxlength="30" name="nickName" id="nickName" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left">*</td>
	</tr>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3">'.showError($errorArray,'email').'</td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Email:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $email; ?>" maxlength="100" name="email" id="email" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left">*</td>
	</tr>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3">'.showError($errorArray,'password').'</td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Password:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $password; ?>" maxlength="30" name="password" id="password" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="password" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left">*</td>
	</tr>
	<tr>
	  <td align="left" colspan="3">Repeat your password to ensure there is no mistake.</td>
	</tr>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3">'.showError($errorArray,'passwordConfirm').'</td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Password:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $passwordConfirm; ?>" maxlength="30" name="passwordConfirm" id="passwordConfirm" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="password" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left">*</td>
	</tr>
	<tr>
	  <td align="right" width="100"><strong>First name:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $firstName; ?>" maxlength="50" name="firstName" id="firstName" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left"></td>
	</tr>
	<tr>
	  <td align="right" width="100"><strong>Last  name:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $lastName; ?>" maxlength="50" name="lastName" id="lastName" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left"></td>
	</tr>

	<?php if(is_array($errorArray)) echo '<tr><td colspan="3">'.showError($errorArray,'country').'</td></tr>'; ?>

	<tr>
	  <td align="right" width="100"><strong>Country:</strong></td>
	  <td align="left" width="150">
		<select name="country" id="country" class="largeSelect">
		  <option value=""></option>

		  <?php 
		  require_once("../dbQueries/countries.php");
		  $countries=getCountries($dbConn);
		  if($countries!="error")
		  {
			for($row=0; $row<count($countries); $row++)
			{
			  if($countries[$row][0]==$country)
				echo '<option selected="selected" value="'.$countries[$row][0].'">'.$countries[$row][1].'</option>';
			  else
				echo '<option value="'.$countries[$row][0].'">'.$countries[$row][1].'</option>';
			}
		  }
		  ?>
		</select>
	  </td>
	  <td align="left">*</td>
	</tr>
	<tr>
	  <td align="right" width="100"><strong>City:</strong></td>
	  <td align="left" width="150"><input value="<?php echo $city; ?>" maxlength="50" name="city" id="city" onfocus="this.className='textBoxLargeSelected'" onblur="this.className='textBoxLarge'" class="textBoxLarge" type="text" onKeyDown="if(event.keyCode==13) register();"/></td>
	  <td align="left"></td>
	</tr>
	<tr>
	  <td></td>
	  <td align="center"><input name="register" value="Register" onfocus="this.className='buttonPress'" onblur="this.className='buttonNormal'" class="buttonNormal" onclick="register()" type="button"/></td>
	  <td></td>
	</tr>

  </table><br/><br/>

</div>

<?php
	}
?>