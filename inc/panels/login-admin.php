<br>
<form id="login-admin-form" method="post">
    <input name="forward" type="hidden" value="<?php echo($_GET['forward']); ?>">
    <p><input id="login-email" class="login-input" name="email" type="text" placeholder="Email"></p>
    <p><input id="login-password" class="login-input" name="password" type="password" placeholder="Password"></p>
    <p><input id="login-submit" class="submit-button login-input" name="login_admin_submit" type="submit" value="Log In"></p>
    <p class="after-submit"><a href="#" id="forgot-password" class="ignore-target" onclick="return false;">Forgot Password?</a></p>
</form>

<form id="request-reset-form" method="post">
	<br><br>
    <p><input id="reset-email" class="login-input" name="reset_email" type="text" placeholder="Email"></p>
    <br />
    <p style=" display: inline-block; margin: 0 auto; display:block;"><input id="reset-admin-submit" class="submit-button login-input" name="request_reset_admin_submit" type="submit" value="Reset"></p>
    <br />
    <p class="after-submit"><a id="attempt-login" class="ignore-target" href="#" onclick="return false;">&larr; Back</a></p>
</form>

<?php
    //TODO make like below
	echo($login_errors);
?>