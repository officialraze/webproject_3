<?php
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'settings';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo SETTINGS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

        <div class="settings_change">
          <h2 class="settings"><?php echo SETTINGS_CHANGE; ?></h2>

            <!-- Vordefinierte Farben -->
            <div class="choose_colours">
              <h3 class="settings"><?php echo CHANGE_COLOURS; ?></h3>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider round"></span>
              </label>
            </div>

              <h3 class="settings"><?php echo CHANGE_BASICS; ?></h3>
            <!-- Benutzername -->
            <div class="change_username">
              <div class="settings_change_username">
    						<input type="text" name="change_username" placeholder="<?php echo USERNAME; ?>">
    					</div>
            </div>

            <!-- Passwort -->
            <div class="change_pw">
              <div class="settings_change_pw">
    						<input type="text" name="change_pw" placeholder="<?php echo PASSWORD; ?>">
    					</div>
            </div>

            <!-- Email -->
            <div class="change_email">
              <div class="settings_change_mail">
    						<input type="text" name="change_mail" placeholder="<?php echo MAIL; ?>">
    					</div>
            </div>
        </div>
        <div class="language">
          <h2 class="settings"><?php echo LANGUAGE; ?></h2>

          <!-- Language -->
          <div class="choose_language">
						<select name="change_language">
							<option value="deutsch"><?php echo DEUTSCH; ?></option>
							<option value="english"><?php echo ENGLISH; ?></option>
						</select>
          </div>
        </div>
        <div class="logout">

          <h2 class="settings"><?php echo LOGOUT; ?></h2>
          <!-- logout Button -->
          <div class="logout_button">
            <a class="submit-button-logout"href="login.php"><?php echo LOGOUT; ?></a>
          </div>

        </div>

			</div>
		</div>

	</body>
</html>
