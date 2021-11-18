<?php
	$post_type = get_post_type();

	get_header();

	if ($post_type) {
		get_template_part('template-parts/contents/content', $post_type);
	} else {
		get_template_part('template-parts/contents/content', 'post');
	}


	get_footer();
