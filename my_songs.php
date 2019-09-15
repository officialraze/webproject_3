<?php
include 'includes/start.php';

// unset session and set new active element
unset($_SESSION['active']);
$_SESSION['active'] = 'my_songs';

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Web Player | <?php echo HOME; ?></title>

		<!-- load all styles -->
		<link rel="stylesheet" href="css/styles.css">
		<script src="js/jquery.min.js" charset="utf-8"></script>
		<script src="js/functions.js" charset="utf-8"></script>
		<?php // TODO: ADD THIS PLEASE IN FINAL VERSION FOR SHOWING THE CORRECT FONT --> LOCAL INSTALLED FONT LOADS FASTER :) ?>
		<!-- <link href="https://fonts.googleapis.com/css?family=DM+Sans:400,700&display=swap" rel="stylesheet"> -->
	</head>

	<body>
		<!-- navigation left -->
		<?php include 'includes/navigation_left.php'; ?>

		<div class="main_content_wrapper">
			<div class="main_content_inner">
				<!-- search and main nav -->
				<?php include 'includes/search_navi.php'; ?>

				<h3 class="short_title"><?php echo MY_SONGS; ?></h3>

				<?php
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me/tracks?market=ES&limit=10&offset=5');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


				$headers = array();
				$headers[] = 'Accept: application/json';
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: Bearer BQDY4khNzOSnOGlQyU9s5PYbdFCiH_xK4Cb9agD6MUXIOn8StvQHDYuJCVDh4VVD4LY4RLIMXzThZzdwTCGmbtU9xzezkMvz-OFetWuoZxLLqqbiWwq_Q7mbx7kSpqA46eOe1wLOBPcSPU9EvIE8Qa6HZQ';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

				$result = curl_exec($ch);
				if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
				}
				curl_close($ch);

				echo "<pre>";print_r($result);echo "</pre>";
				?>

			</div>
		</div>
	</body>
