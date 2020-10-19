<?php
	global $wphp;
?>
<?php get_header(); ?>

<?php if ($concept = $wphp->hp_salon_concept and !empty($concept)) : ?>
<div id="concept">
	<div class="container">
		<div class="concept">
			<div class="logo">
				<?php the_logo(); ?>
			</div>

			<div class="text">
				<?= $concept; ?>
			</div>
		</div>
	</div>
</div>
<!-- /#concept -->
<?php endif; ?>

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
