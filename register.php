<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo REGISTER; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="register_form_wrapper">
			<div class="login_form_inner">
				<h1 class="title_register"><?php echo NEW_REGISTER; ?></h1>
				<form class="form_login" action="" method="post">
					<div class="login_form_element">
						<input type="text" name="FIRSTNAME" placeholder="<?php echo FIRSTNAME; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="LASTNAME" placeholder="<?php echo LASTNAME; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="mail" placeholder="<?php echo MAIL; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="username" placeholder="<?php echo USERNAME; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="password" placeholder="<?php echo PASSWORD; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="retype_password" placeholder="<?php echo RETYPE_PASSWORD; ?>">
					</div>
					<a class="submit-button-cancel-register" href="login.php"><?php echo BACK_TO_LOGIN; ?></a>
					<input class="submit-button-register" type="submit" name="login_submitter" value="<?php echo REGISTER; ?>">
				</form>
			</div>
		</div>
	</body>
</html>
