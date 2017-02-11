
<form id="login-residents-form" method="post">
	<br>
    <input name="forward" type="hidden" value="<?php echo($_GET['forward']); ?>">
    <p><input id="login-email" class="login-input" name="email" type="text" placeholder="Email"></p>
    <p><input id="login-password" class="login-input" name="password" type="password" placeholder="Password"></p>
    <p><input id="login-submit" class="submit-button login-input" name="login_residents_submit" type="submit" value="Log In"></p>

    <p class="after-submit"><a id="forgot-password" class="ignore-target" href="#" onclick="return false;">Forgot Password?</a> | <a  id="create-account" class="ignore-target" href="#" onclick="return false;">Request Account</a></p>
</form>

<form id="request-reset-form" method="post">
	<br><br>
    <p><input id="reset-email" class="login-input" name="reset_email" type="text" placeholder="Email"></p>
    <p><input style="display: inline-block; margin: 0 auto; display:block;" id="reset-tenant-submit" class="submit-button" name="request_reset_submit" type="submit" value="Reset"></p>
    <p class="after-submit"><a id="attempt-login" class="ignore-target" href="#" onclick="return false;">&larr; Back</a></p>
</form>

<form id="create-account-form" method="post">
    <p style="margin-top: -8px; margin-bottom: 8px;">
        <input id="create-first" class="login-input" name='create_first' type='text' required placeholder="First Name" value='<?php if(isset($create_errors)){ echo $_POST['create_first'];}?>' >
        <input id="create-last" class="login-input" name='create_last' type='text' required placeholder="Last Name" value='<?php if(isset($create_errors)){ echo $_POST['create_last'];}?>' >
    </p>

    <p style="margin-top: 0px; margin-bottom: 8px;">
        <input id="create-email" class="login-input" name="create_email" type="email" required placeholder="Email" value='<?php if(isset($create_errors)){ echo $_POST['create_email'];}?>' >
        <input id="create-unit" class="login-input" name='create_unit' type="number" min="0" max="300" required placeholder="Unit" value='<?php if(isset($create_errors)){ echo $_POST['create_unit'];}?>' >
    </p>

	<p style="margin-top: 0; margin-bottom: 8px;">
        <input id="create-password" class="login-input" name='create_password' type='password' required placeholder="Password" value='<?php if(isset($create_errors)){ echo $_POST['create_password'];}?>' ><br>
    	<input style="margin: 0 auto; display:block;" name='password_confirm' type='password' required placeholder="Confirm Password" value='<?php if(isset($create_errors)){ echo $_POST['password_confirm'];}?>'>
    </p>

    <p style="margin-top: 0; margin-bottom: 8px;"><input id="reset-submit" class="submit-button login-input" name="create_account_submit" type="submit" value="Request"></p>
    <p class="after-submit" style="margin-top: 12px; margin-bottom: 0;"><a id="reattempt-login" class="ignore-target" href="#" onclick="return false;">&larr; Back</a></p>
</form>
 
<?php
//check for any errors
if(isset($login_errors)){
    //TODO make like below
	echo($login_errors);
}
if(isset($create_errors)){
	echo '<p class="error">'. $create_errors .'</p>';
}
?>