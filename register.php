<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber
// --------------------------
*/

// includes
include 'language/de.php';
include 'config.php';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo REGISTER; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet">
	</head>
	<body>
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
					<a class="submit-button-cancel-register"href="register.php"><?php echo REGISTER; ?></a>
					<input class="submit-button-register" type="submit" name="login_submitter" value="<?php echo LOGIN; ?>">
				</form>
			</div>
		</div>
	</body>
</html>
