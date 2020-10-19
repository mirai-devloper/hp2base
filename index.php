<?php
	get_header();

	if (is_single() or is_singular()) {
		$post_type = get_post_type();
		get_template_part('template-parts/contents/content', $post_type);
	} else {
		get_template_part('template-parts/archive/loop', 'post');
	}

	get_footer();
