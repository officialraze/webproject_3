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

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo LOGIN; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<div id="login_form_wrapper">
			<div class="login_form_inner">
				<h1 class="title_login"><?php echo PLEASE_LOGIN; ?></h1>
				<form class="form_login" action="classes/class.user.php" method="post">
					<div class="form_element">
						<input type="text" name="username" placeholder="<?php echo USERNAME_MAIL; ?>">
					</div>
					<div class="form_element">
						<input type="password" name="password" placeholder="<?php echo PASSWORD; ?>">
					</div>
					<div class="form_element password_reset">
						<a href="password_reset.php"><?php echo PASSWORD_FORGOT; ?></a>
					</div>
					<input type="hidden" name="login_form" value="true">
					<div class="button_wrap login">
						<input class="submit-button" type="submit" name="login_submitter" value="<?php echo LOGIN; ?>">
						<a class="submit-button-cancel"href="register.php"><?php echo REGISTER; ?></a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
