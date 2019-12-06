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
unset($_SESSION['active']);
$_SESSION['active'] 			= 'events';
$_SESSION['active_meta_nav']	= 'discover';

// get all events
$get_events_query = "SELECT * FROM `events` events
					 INNER JOIN `artist` artist ON artist.artist_id = events.artist_id_link";

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo EVENTS; ?></title>

		<?php include 'includes/meta_data.php'; ?>
	</head>

	<body class="<?php echo $body_class; ?>">
		<?php include 'includes/navigation_left.php'; ?>
		<?php include 'includes/cookie_banner.php'; ?>
		<div id="playbar_wrapper_loader"></div>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>
				<h3 class="short_title"><?php echo NEAR_CONCERTS; ?></h3>
				<div id="events_table">
				<table class="concerts_near_you">
					<tbody>
						<tr class="event_table">
							<th class="artist_name_concert"><?php echo ARTISTS; ?></th>
							<th class="concert_when"><?php echo DATE; ?></th>
							<th class="concert_where"><?php echo WHERE; ?></th>
						</tr>
						<?php foreach ($pdo->query($get_events_query) as $event) { ?>
							<tr class="event_table">
								<td class="artist_name_concert event_table"><?php echo $event['artist_firstname'].' '.$event['artist_lastname']; ?></td>
								<td class="concert_when event_table">
									<?php
									$date = new DateTime($event['event_date']);
									echo $date->format('d.m.Y');
									?>
								</td>
								<td class="concert_where event_table"><?php echo $event['place']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</body>
