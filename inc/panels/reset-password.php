<form action="" method="post">
	<br><br>
	<p><input name="reset_password_code" id="reset-password-code" type="hidden" value='<?php echo $_GET["code"]?>'></p>
	<p><input name="reset_password_email" id="reset-password-email" type="hidden" value='<?php echo $_GET["email"]?>'></p>
	<p style="margin-top: 0; margin-bottom: 8px;">
		<input required placeholder="Password" type='password' min="4" name='reset_password' id="reset-password" class="login-input" value='<?php if(isset($reset_errors)){ echo $_POST['reset_password'];}?>'><br>
		<input required placeholder="Confirm Password" type='password' name='reset_password_confirm' id="reset-confirm" class="login-input" value='<?php if(isset($reset_errors)){ echo $_POST['reset_password_confirm'];}?>'>
	</p>
    <p><input name="reset_password_submit" id="code-enter-submit" class="submit-button login-input" type="submit" value="Submit"></p>
    
	<?php
	if(isset($reset_errors)){
		echo '<p class="error">'. $reset_errors .'</p>';
	}
	?>
</form>