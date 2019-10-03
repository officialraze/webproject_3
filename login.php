<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

include 'includes/start.php';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo LOGIN; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="login_form_wrapper">
			<div class="login_form_inner">
				<h1 class="title_login"><?php echo PLEASE_LOGIN; ?></h1>
				<form class="form_login" action="" method="post">
					<div class="login_form_element">
						<input type="text" name="username" placeholder="<?php echo USERNAME_MAIL; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="password" placeholder="<?php echo PASSWORD; ?>">
					</div>

					<input class="submit-button" type="submit" name="login_submitter" value="<?php echo LOGIN; ?>">
					<a class="submit-button-cancel"href="register.php"><?php echo REGISTER; ?></a>
				</form>
			</div>
		</div>
	</body>
</html>
