<?php
//Get total non-active users
$stmt = $db->query("SELECT * FROM users WHERE `active` = 'false'");

$total_non_active = $stmt->rowCount();

?>

<div class="control-panel">
	<div class="control-panel-inner">
		<h2>Administrator Panel</h2>
		<div class="sub-menu">
			<div data-form="main-settings" title="Settings" id="control-settings" class="option"></div>
			<div data-form="main-announcements" title="Announcements" id="control-announcements" class="option"></div>
			<div data-form="main-user" title="Users" id="control-user" class="option"><div class="non-active"><?php echo $total_non_active ?></div></div>
			<a title="Logout" href="inc/logout.php"><div data-form="confirmation-logout" title="Logout" class="option" id="control-logout"></div></a>
		</div>
	</div>
</div>
