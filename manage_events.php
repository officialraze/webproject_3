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
$_SESSION['active'] 			= 'artists';
$_SESSION['active_meta_nav']	= 'discover';

$artist_id = $_SESSION['user']['id'];

// check if user isset in url
if (isset($_GET['artist_id']) && !empty($_GET['artist_id'])) {
	$artist = $_GET['artist_id'];
}
else {
	header('Location: idnex.php');
}

$statement_is_artist = $pdo->prepare("SELECT * FROM `artist` WHERE (`user_id` = :user_id) AND (`artist_id` = :artist_id)");
$statement_is_artist->execute(array(':user_id' => $artist_id, ':artist_id' => $artist));

// check if user is the same as artist (security check)
if ($statement_is_artist->rowCount() <= 0) {
	header('Location: artist_detail.php?artist_id='.$artist.'&message=no_permission');
}
else {
	$edit_events_query = "SELECT * FROM `events` WHERE `artist_id_link` = $artist";
}

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo MANAGE_EVENTS; ?></title>

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
				<a class="back_link" href="artist_detail.php?artist_id=<?php echo $artist; ?>"><?php echo BACK; ?></a>
				<h3 class="short_title"><?php echo MANAGE_EVENTS; ?></h3>

				<div class="manage_songs_wrap">
					<?php foreach ($pdo->query($edit_events_query) as $events) { ?>
						<div class="event_element">
							<input class="event_name triplet" type="text" value="<?php echo htmlspecialchars_decode($events['event_name']); ?>" name="event_name">
							<input class="place triplet" type="text" value="<?php echo htmlspecialchars_decode($events['place']); ?>" name="place">
							<input class="event_date triplet" type="date" value="<?php echo htmlspecialchars_decode($events['event_date']); ?>" name="event_date">
							<input class="event_id" type="hidden" value="<?php echo htmlspecialchars_decode($events['id']); ?>" name="hidden_event_id">
							<a class="follow_button save_event"><?php echo SAVE; ?></a>
							<div class="cf"></div>
						</div>
					<?php } ?>
				</div>

				<div class="add_event_wrap">
					<h3 class="short_title"><?php echo ADD_EVENT; ?></h3>
					<form class="new_event_form" action="classes/class.artist.php" method="post">
						<input class="triplet" type="text" name="new_event_name" value="" placeholder="<?php echo NAME_OF_EVENT; ?>">
						<input class="triplet" type="text" name="new_place" value="" placeholder="<?php echo PLACE_OF_EVENT; ?>">
						<input class="triplet" type="date" name="new_event_date" value="" placeholder="<?php echo DATE_OF_EVENT; ?>">
						<input type="hidden" name="new_event_form" value="true">
						<input class="submit-button" type="submit" name="save_new_event" value="<?php echo SAVE; ?>">
						<div class="cf"></div>
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript">

			$('.save_event').click(function() {

				// set vars
				var button = $(this);
				var event_name = $(button).parent().find('.event_name').val();
				var place = $(button).parent().find('.place').val();
				var event_date = $(button).parent().find('.event_date').val();
				var event_id = $(button).parent().find('.event_id').val();

				$.ajax({
					url: 'classes/class.artist.php',
					type: "POST",
					data: {
						event_name_val: event_name,
						place_val: place,
						event_date_val: event_date,
						event_id_val: event_id,
					},
					success: function(response) {
						// add message
						$('<div class="message true">Änderungen erfolgreich gespeichert!</div>').prependTo('body');

						// add for smoothing
						setTimeout(function(){
							$('.message').addClass('visible');
						}, 300);

						// remove message after certain time
						setTimeout(function(){
							$('.message').removeClass('visible');
						}, 4000);
					}
				});
			});

		</script>
	</body>
</html>
