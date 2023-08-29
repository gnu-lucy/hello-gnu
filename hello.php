<?php
/**
 * @package Hello_GNU
 * @version 1.7.2-gnu
 */
/*
Plugin Name: Hello GNU
Plugin URI: https://github.com/gnu-lucy/hello-gnu
Description: This is not just a plugin, it symbolizes the spirit of GNU. When activated you will see lyrics from <cite>The Free Software Song</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg, GNU/Lucy
Version: 1.7.2-gnu
Author URI: https://twitter.com/gnu_lucy
*/

function hello_gnu() {
	/** These are the lyrics to The Free Software Song */
	$lyrics = "Join us now and share the software; You'll be free, hackers, you'll be free.
Hoarders can get piles of money, that is true, hackers, that is true.
But they cannot help their neighbors; That's not good, hackers, that's not good.
When we have enough free software at our call, hackers, at our call,
We'll kick out those dirty licenses ever more, hackers, ever more.";

	$lang = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = 'lang="en"';
	}

	printf(
		'<p id="gnu"><span class="screen-reader-text">%s </span><span dir="ltr" %s></span></p>',
		__( 'Quote from The Free Software Song, by Richard Stallman:', 'hello-gnu' ),
		$lang
	);

	// Display the lyrics repeatedly in javascript.
	echo "<script>
		let lyrics = `$lyrics`;
		lyrics = lyrics.split('\\n');

		const sleep = (delay) => new Promise((resolve) => setTimeout(resolve, delay));

		(async function() {
			while(true) {
				for(let i = 0; i < lyrics.length; i++) {
					document.getElementById('gnu').children[1].textContent = lyrics[i];
					await sleep(7800);  // This song is in a rhythm of 7/8.
				}
			}
		})();
	</script>";
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'hello_gnu' );

// We need some CSS to position the paragraph.
function gnu_css() {
	echo "
	<style type='text/css'>
	#gnu {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #gnu {
		float: left;
	}
	.block-editor-page #gnu {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#gnu,
		.rtl #gnu {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'gnu_css' );
