<?php
	global $wphp;
?>
<?php get_header(); ?>

<?php
	$concept = $wphp->hp_salon_concept;
	do_action('hairspress_concept', $concept);
?>


<?php
	if ($wphp->options_topics_name === 'up') {
		get_template_part('template-parts/front/news');
	}
?>

<?php get_template_part('template-parts/front/space'); ?>

<?php get_template_part('template-parts/front/blog'); ?>

<?php get_template_part('template-parts/front/catalog'); ?>

<?php
	// Social
	if (!empty($wphp->hp_salon_social_facebook) or !empty($wphp->hp_salon_social_instagram)) {
		get_template_part('template-parts/front/social');
	}
?>

<?php
	if ($wphp->options_topics_name === 'down') {
		get_template_part('template-parts/front/news');
	}
?>

<?php get_footer(); ?>
