/*
// --------------------------
// Webprojekt 3.0
// Copyright Melvin Lauber & David Clausen
// --------------------------
*/

// basic functions
$(function() {

	// load playbar
	$('#playbar_wrapper_loader').load('includes/playbar.php');

	// show all songs in artist detail
	$('.show_all').click(function() {
		var button = $(this);

		if ($(button).html() == 'Alle anzeigen') {
			$(button).html('Weniger anzeigen');
		}
		else {
			$(button).html('Alle anzeigen');
		}

		var songs_wrapper = $(button).parent().find('.songs_wrapper');

		// show more songs
		$(songs_wrapper).find('.more_songs').slideToggle();
	});

	// check if message isset
	if (window.location.href.indexOf("message=") > -1) {

		if (window.location.href.indexOf("message=true") > -1) {
			var message_value = "true";
			var message_text = "Änderungen erfolgreich gespeichert!";
		}
		else if (window.location.href.indexOf("message=empty_fields") > -1) {
			var message_value = "false";
			var message_text = 'Bitte füllen Sie alle Felder aus!';
		}
		else if (window.location.href.indexOf("message=login_true") > -1) {
			var message_value = "true";
			var message_text = 'Erfolgreich eingeloggt!';
		}
		else if (window.location.href.indexOf("message=logout_true") > -1) {
			var message_value = "true";
			var message_text = 'Erfolgreich abgemeldet!';
		}
		else if (window.location.href.indexOf("message=upload_successfull") > -1) {
			var message_value = "true";
			var message_text = 'Album erfolgreich hinzugefügt!';
		}
		else if (window.location.href.indexOf("message=register_successfull") > -1) {
			var message_value = "true";
			var message_text = 'Erfolgreich registriert!';
		}
		else if (window.location.href.indexOf("message=upload_artist_image_successfull") > -1) {
			var message_value = "true";
			var message_text = 'Künstler Bild erfolgreich hochgeladen!';
		}
		else if (window.location.href.indexOf("message=upload_user_image_successfull") > -1) {
			var message_value = "true";
			var message_text = 'Profil-Bild erfolgreich hochgeladen!';
		}
		else if (window.location.href.indexOf("message=mail_sent") > -1) {
			var message_value = "true";
			var message_text = 'Es wurde Ihnen ein Mail mit einem Link geschickt, mit dem Sie das Passwort zurücksetzen können!';
		}
		else if (window.location.href.indexOf("message=reset_password_successfull") > -1) {
			var message_value = "true";
			var message_text = 'Passwort wurde erfolgreich zurückgesetzt!';
		}
		else if (window.location.href.indexOf("message=cover_not_uploaded") > -1) {
			var message_value = "false";
			var message_text = 'Cover konnte nicht geladen werden!';
		}
		else if (window.location.href.indexOf("message=song_not_uploaded") > -1) {
			var message_value = "false";
			var message_text = 'Songs konnte nicht hochgeladen werden!';
		}
		else if (window.location.href.indexOf("message=login_false") > -1) {
			var message_value = "false";
			var message_text = 'E-Mail oder Passwort ist nicht korrekt!';
		}
		else if (window.location.href.indexOf("message=token_used") > -1) {
			var message_value = "false";
			var message_text = 'Dieser Link wurde bereits verwendet!';
		}
		else if (window.location.href.indexOf("message=no_user_found") > -1) {
			var message_value = "false";
			var message_text = 'Konnte Benutzername oder E-Mail nicht finden!';
		}
		else if (window.location.href.indexOf("message=no_permission") > -1) {
			var message_value = "false";
			var message_text = 'Keine Berechtigung!';
		}
		else {
			var message_value = "false";
			var message_text = "Änderungen wurden nicht übernommen!";
		}

		// add message
		$('<div class="message '+message_value+'">'+message_text+'</div>').prependTo('body');

		// add for smooth animation show up
		setTimeout(function(){
			$('.message').addClass('visible');
		}, 300);

		// remove message after certain time
		setTimeout(function(){
			$('.message').removeClass('visible');
		}, 4000);
    }

	// change img tag with class svg into an svg
    activate('img[src*=".svg"]');
    function activate(string){
        jQuery(string).each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');
        });
    };
});

// show add artist form if toggle is clicked
$(function() {
	$('#is_artist_checker').change(function() {
		$('.add_new_artist_form').slideToggle();
	});

	// super cool image uploader
	$("#submit").hide();
	$("#artist_image, #user_image").on("change", function(){
		$("#submit").show();
	});
});

// like songs (add/remove)
$(function() {
	$('.like_wrapper').each(function() {
		var button = $(this);

		$(button).click(function() {
			$(button).toggleClass('liked');
			var song_id = $(this).data('song');

			if (button.hasClass('liked')) {
				var saved_song = 'like';
			}
			else {
				var saved_song = 'no_like';
			}

			$.ajax({
				url: 'classes/class.user.php',
				type: "POST",
				data: {
					save_song: saved_song,
					song_id: song_id,
				},
				success: function(response) {
					console.log(response);
				}
			});
		});
	});
});


// add song to playlist
$(function() {

	$('.add_to_playlist_button').click(function() {
		var playlist_id = $(this).data('playlist_id');
		var song_id = $(this).data('song_id');
		var playlist_checker = $(this).data('playlist_checker');

		$.ajax({
			url: 'classes/class.playlist.php',
			type: "POST",
			data: {
				playlist_id_link: playlist_id,
				song_id: song_id,
				playlist_checker_val: playlist_checker,
			},
			success: function(response) {

			}
		});
	});
});


// follow / unfollow artist
$(function() {

	var button = $('.change_follow_state');
	$(button).click(function() {
		$(button).toggleClass('is_following');
		var artist_id = $(this).data('artist');

		if (button.hasClass('is_following')) {
			var follow_artist = 'follow_artist';
			$(button).text('Folge ich');
		}
		else {
			var follow_artist = 'unfollow_artist';
			$(button).text('Folgen');
		}

		$.ajax({
			url: 'classes/class.artist.php',
			type: "POST",
			data: {
				follow_unfollow: follow_artist,
				artist: artist_id,
			},
			success: function(response) {
				console.log(response);
			}
		});
	});
});

// play song if play button is clicked
$(function() {
	$('.play_song_class').click(function() {
		var song_id = $(this).data('song');
		var song_name = $(this).data('song_name');
		var artist_name = $(this).data('artist_name');
		var artist_id = $(this).data('artist_id');
		var album_id = $(this).data('album_id');
		var cover = $(this).data('cover');

		// set jquery sessions for playbar
		$.session.set('song_id', song_id);
		$.session.set('song_name', song_name);
		$.session.set('artist_name', artist_name);
		$.session.set('artist_id', artist_id);
		$.session.set('album_id', album_id);
		$.session.set('cover', cover);

		// load playbar again for setting new song data
		$('#playbar_wrapper_loader').load('includes/playbar.php');
		setTimeout(function(){
			$('#play-btn').trigger('click');
		}, 300);
	});
});


// this is for the cookie banner
!function(e){var n=!1;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var o=window.Cookies,t=window.Cookies=e();t.noConflict=function(){return window.Cookies=o,t}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var o=arguments[e];for(var t in o)n[t]=o[t]}return n}function n(o){function t(n,r,i){var c;if("undefined"!=typeof document){if(arguments.length>1){if("number"==typeof(i=e({path:"/"},t.defaults,i)).expires){var a=new Date;a.setMilliseconds(a.getMilliseconds()+864e5*i.expires),i.expires=a}i.expires=i.expires?i.expires.toUTCString():"";try{/^[\{\[]/.test(c=JSON.stringify(r))&&(r=c)}catch(e){}r=o.write?o.write(r,n):encodeURIComponent(String(r)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=(n=(n=encodeURIComponent(String(n))).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent)).replace(/[\(\)]/g,escape);var s="";for(var f in i)i[f]&&(s+="; "+f,!0!==i[f]&&(s+="="+i[f]));return document.cookie=n+"="+r+s}n||(c={});for(var p=document.cookie?document.cookie.split("; "):[],d=/(%[0-9A-Z]{2})+/g,u=0;u<p.length;u++){var l=p[u].split("="),C=l.slice(1).join("=");this.json||'"'!==C.charAt(0)||(C=C.slice(1,-1));try{var g=l[0].replace(d,decodeURIComponent);if(C=o.read?o.read(C,g):o(C,g)||C.replace(d,decodeURIComponent),this.json)try{C=JSON.parse(C)}catch(e){}if(n===g){c=C;break}n||(c[g]=C)}catch(e){}}return c}}return t.set=t,t.get=function(e){return t.call(t,e)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(n,o){t(n,"",e(o,{expires:-1}))},t.withConverter=n,t}return n(function(){})});
