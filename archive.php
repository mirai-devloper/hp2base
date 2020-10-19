<?php
	$post_type = get_query_var('post_type');

	if (empty($post_type)) {
		if (is_category()) {
			$taxonomy = get_taxonomy('category');
			$post_type = $taxonomy->object_type[0];
		} elseif (is_tax()) {
			$term = get_query_var('taxonomy');
			$taxonomy = get_taxonomy($term);
			$post_type = $taxonomy->object_type[0];
		} elseif (is_archive()) {
			$post_type = get_query_var('post_type');
		} else {
			$post_type = 'post';
		}
	}

	get_header();

	if ($post_type) {
		get_template_part('template-parts/archive/loop', $post_type);
	} else {
		get_template_part('template-parts/archive/loop', 'post');
	}

	get_footer();
