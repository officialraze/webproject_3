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
		<title>Web Player | <?php echo LOGIN; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet">
	</head>
	<body>
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
