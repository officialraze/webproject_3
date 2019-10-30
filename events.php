<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'events';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo EVENTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>

	<body class="<?php echo $body_class; ?>">
		<!-- navigation left -->
		<?php include 'includes/navigation_left.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
				<h3 class="short_title"><?php echo NEAR_CONCERTS; ?></h3>

				<table class="concerts_near_you">
					<tbody>
							<tr>
								<th class="artist_name_concert"><?php echo ARTISTS; ?></th>
								<th class="concert_when"><?php echo DATE; ?></th>
								<th class="concert_where"><?php echo WHERE; ?></th>
							</tr>
							<tr>
								<td class="artist_name_concert">raze.exe</td>
								<td class="concert_when">25.04.2021</td>
								<td class="concert_where">Zürich, Lexikon</td>
							</tr>
							<tr>
								<td class="artist_name_concert">Virtual Riot</td>
								<td class="concert_when">14.03.2021</td>
								<td class="concert_where">Basel, Hallenstadion</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
