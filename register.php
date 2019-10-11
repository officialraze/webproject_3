<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';

$required = '*';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo REGISTER; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<div id="register_form_wrapper">
			<div class="login_form_inner">
				<h1 class="title_register"><?php echo NEW_REGISTER; ?></h1>
				<form class="form_login" action="" method="post">
					<div class="login_form_element">
						<input type="text" name="firstname" placeholder="<?php echo FIRSTNAME.$required; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="lastname" placeholder="<?php echo LASTNAME.$required; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="mail" placeholder="<?php echo MAIL.$required; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="username" placeholder="<?php echo USERNAME.$required; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="password" placeholder="<?php echo PASSWORD.$required; ?>">
					</div>
					<div class="login_form_element">
						<input type="text" name="retype_password" placeholder="<?php echo RETYPE_PASSWORD.$required; ?>">
					</div>
					<div class="button_wrap">
						<input class="submit-button-register" type="submit" name="login_submitter" value="<?php echo REGISTER; ?>">
						<a class="submit-button-cancel-register" href="login.php"><?php echo BACK_TO_LOGIN; ?></a>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
