<br>
<form id="residents-login-form" action="" method="post">
    <input name="forward" type="hidden" value="<?php echo($_GET['forward']); ?>">
    <p><input placeholder="Email" id="login-email" name="email" class="login-input" type="text"></p>
    <p><input placeholder="Password" id="login-password" name="password" class="login-input" type="password"></p>
    <p><input class="submit-button" id="login-submit"  name="residents-login-submit" class="submit-button login-input" id="" class="submit-button" type="submit" value="Log In"></p>
    <a href="#" onclick="return false;" class="ignore-target" href=""><p id="forgot-password">Forgot Password?</p></a>
</form>

<form id="residents-reset-password-form"action="" method="post">
    <input name="forward" type="hidden" value="<?php echo($_GET['forward']); ?>">
    <p><input placeholder="Email" id="reset-email" name="email" class="login-input" type="text"></p>
    <p><input class="submit-button" id="reset-submit"  name="residents-reset-submit" class="submit-button login-input" id="" class="submit-button" type="submit" value="Send Email"></p>
    <a href="#" onclick="return false;" class="ignore-target" href=""><p id="attempt-login">Try Again</p></a>    
</form>

<?php
echo($login_errors);
?>