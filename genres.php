<?php
include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'discover';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo GENRES; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>
	<body>
		<?php include 'includes/navigation_left.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
				<div id="genres_wrapper">
					<h3 class="short_title"><?php echo GENRES; ?></h3>
					<div class="genres_overview">
						<?php foreach ($config['genres'] as $genre_key => $genre) { ?>
							<div class="genre_box">
								<div class="genre_box_inner">
									<a href="genre_detail.php?genre_id=<?php echo $genre_key; ?>"><h3><?php echo $genre; ?></h3></a>
								</div>
							</div>
						<?php } ?>
						<div class="cf"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>