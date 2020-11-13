<?php
/**
 * Template Name: Full width
 * Template Post Type: post
 */
?>
<?php
	get_header();

	get_template_part('template-parts/contents/content', 'post', array('full-width' => true));

	if( !is_user_logged_in() and !isBot() ) {
		set_post_views( get_the_ID() );
	}


	get_footer();
