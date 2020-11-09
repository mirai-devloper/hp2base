<?php
	$post_type = get_post_type();

	get_header();

	if ($post_type) {
		get_template_part('template-parts/contents/content', $post_type);
	} else {
		get_template_part('template-parts/contents/content', 'post');

		if( !is_user_logged_in() and !isBot() ) {
			set_post_views( get_the_ID() );
		}
	}


	get_footer();
