<div id="js-cookie-box" class="cookie-box cookie-box--hide">
Wir verwenden Cookies auf unserer Website, um die Benutzerfreundlichkeit der Website zu optimieren. 🍪 <span id="js-cookie-button" class="cookie-button">Akzeptieren</span>
</div>

<script type="text/javascript">
	// set cookie
	const cookieBox = document.getElementById('js-cookie-box');
	const cookieButton = document.getElementById('js-cookie-button');

	if (!Cookies.get('cookie-box')) {
		cookieBox.classList.remove('cookie-box--hide');

		cookieButton.onclick = function () {
		Cookies.set('cookie-box', true, { expires: 7 });
		cookieBox.classList.add('cookie-box--hide');
		};
	}
</script>
