<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';
include 'includes/check_login.php';

// unset session and set new active element
$_SESSION['active']				= 'discover';
$_SESSION['active_meta_nav']	= 'discover';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/playbar.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<div class="site_loader">
					<?php include 'home.php'; ?>
				</div>
			</div>
		</div>

		<script>
			$(function() {
				$('.site_load_button').click(function() {
					var link = $(this).data('url');
					$('.site_loader').load(link);
				});

				// load if url isset
				var url      = window.location.href;
				var urlsplit = url.split(".php#")[1];
				if (urlsplit) {
					$('.site_loader').load(urlsplit);
				}
			});
		</script>

	</body>
</html>
