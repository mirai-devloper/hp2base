<?php
	get_header();

	$taxonomy = get_query_var('taxonomy');
	$post_type = 'post';

	if ($taxonomy == 'com_category' || $taxonomy == 'catalog_length' || $taxonomy == 'catalog_tag') {
		$post_type = 'catalog';
	} elseif ($taxonomy == 'channel_category') {
		$post_type = 'channel';
	} elseif ($taxonomy == 'manage') {
		$post_type = 'staff';
	} elseif ($taxonomy == 'menu-contents_type' || $taxonomy == 'menu-contents_category') {
		$post_type = 'menu-contents';
	} else {
		$post_type = 'post';
	}
	get_template_part('template-parts/archive/loop', $post_type);

	get_footer();
