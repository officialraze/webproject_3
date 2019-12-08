<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

include 'includes/start.php';

// check if logged in
if(isset($_SESSION['user']['id'])) {
	header('Location: index.php');
}

// check if token isset, if not -> passwort reset page
if (isset($_GET['token'])) {
	$token = $_GET['token'];
}
else {
	header('Location: password_reset.php');
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo CHANGE_PASSWORD; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<div id="login_form_wrapper">
			<div class="login_form_inner">
				<h1 class="title_login"><?php echo CHANGE_PASSWORD; ?></h1>
				<form class="form_login" action="classes/class.user.php" method="post">
					<div class="form_element">
						<input type="text" name="password1" placeholder="<?php echo PASSWORD; ?>">
					</div>
					<div class="form_element">
						<input type="text" name="password2" placeholder="<?php echo RETYPE_PASSWORD; ?>">
					</div>
					<input type="hidden" name="password_reset_form_validate" value="true">
					<input type="hidden" name="password_token" value="<?php echo $token; ?>">
					<div class="button_wrap password_reset">
						<input class="submit-button" type="submit" name="login_submitter" value="<?php echo CHANGE_PASSWORD; ?>">
						<a class="submit-button-cancel"href="login.php"><?php echo BACK_TO_LOGIN; ?></a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
