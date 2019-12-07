<?php
session_start();
/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

?>

<div class="audio-player" style="position: fixed; bottom: 0; height: 111px; width: 100%; background: #fff; box-shadow: 0 -5px 14px rgba(0,0,0,0.16); z-index: 100;">
	<div id="play-btn"></div>
	<div class="audio-wrapper" id="player-container" href="javascript:;">
		<audio id="player" ontimeupdate="initProgressBar();">
		</audio>
	</div>
	<div class="player-controls scrubber">
		<span id="seekObjContainer">
			<progress id="seekObj" value="0" max="1"></progress>
		</span>
		<br>
		<small style="float: left; position: relative; left: 15px;" class="start-time"></small>
		<small style="float: right; position: relative; right: 20px;" class="end-time"></small>
	</div>

</div>

<script type="text/javascript">

$(function() {

	// remove source before setting a new one
	if (('.source_music_player').length) {
		$('.source_music_player').remove();
	}

	if ($.session.get('song_id') && $.session.get('song_name') && $.session.get('artist_name')) {
		var song_id 	= $.session.get('song_id');
		var song_name 	= $.session.get('song_name');
		var artist_name = $.session.get('artist_name');
		var album_id = $.session.get('album_id');
		var artist_id = $.session.get('artist_id');
		var cover = $.session.get('cover');

		$('<source class="source_music_player" src="music/song_'+song_id+'.mp3" type="audio/mp3">').appendTo('audio#player');
		$('<p><a href="album_overview.php?album_id='+album_id+'&artist_id='+artist_id+'">'+song_name+' </a><small>von</small> <a href="artist_detail.php?artist_id='+artist_id+'">'+artist_name+'</a></p>').prependTo('.player-controls.scrubber');
		$('<div class="album-image" style="background-image: url(img/covers/'+cover+')"></div>').appendTo('.audio-player');
	}
});


function initProgressBar() {
	var player = document.getElementById('player');
	var length = player.duration
	var current_time = player.currentTime;

	// calculate total length of value
	var totalLength = calculateTotalValue(length)
	jQuery(".end-time").html(totalLength);

	// calculate current value time
	var currentTime = calculateCurrentValue(current_time);
	jQuery(".start-time").html(currentTime);

	var progressbar = document.getElementById('seekObj');
	progressbar.value = (player.currentTime / player.duration);
	progressbar.addEventListener("click", seek);

	if (player.currentTime == player.duration) {
		$('#play-btn').removeClass('pause');
	}

	function seek(evt) {
		var percent = evt.offsetX / this.offsetWidth;
		player.currentTime = percent * player.duration;
		progressbar.value = percent / 100;
	}
};


function calculateTotalValue(length) {
	var minutes = Math.floor(length / 60),
	seconds_int = length - minutes * 60,
	seconds_str = seconds_int.toString(),
	seconds = seconds_str.substr(0, 2),
	time = minutes + ':' + seconds

	return time;
};


function calculateCurrentValue(currentTime) {
	var current_hour = parseInt(currentTime / 3600) % 24,
	current_minute = parseInt(currentTime / 60) % 60,
	current_seconds_long = currentTime % 60,
	current_seconds = current_seconds_long.toFixed(),
	current_time = (current_minute < 10 ? "0" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);

	return current_time;
};


// init playbar
$(function() {
	function initPlayers(num) {
	  // pass num in if there are multiple audio players e.g 'player' + i
	  for (var i = 0; i < num; i++) {
		(function() {

		  // Variables
		  // ----------------------------------------------------------
		  // audio embed object
		  var playerContainer = document.getElementById('player-container'),
			player = document.getElementById('player'),
			isPlaying = false,
			playBtn = document.getElementById('play-btn');

		  // Controls Listeners
		  // ----------------------------------------------------------
		  if (playBtn != null) {
			playBtn.addEventListener('click', function() {
			  togglePlay();
			});
		  }

		  // Controls & Sounds Methods
		  // ----------------------------------------------------------
		  function togglePlay() {
			if (player.paused === false) {
			  player.pause();
			  isPlaying = false;
			  $('#play-btn').removeClass('pause');

			} else {
			  player.play();
			  $('#play-btn').addClass('pause');
			  isPlaying = true;
			}
		  }
		}());
	  }
  };
	initPlayers(jQuery('#player-container').length);
});

</script>
