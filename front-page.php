
<?php get_header(); ?>

<?php if($concept = HP_Acf::get('hp_salon_concept', 'option')) : ?>
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

<?php hp_news_view('up'); ?>

<?= View::forge('front/space'); ?>

<?= View::forge('front/blog'); ?>

<?= View::forge('front/catalog'); ?>

<?php
	// Social
	if ( $social_url = HP_Social::option_url('prefix', 'social', 'option')) {
		if ( ! empty($social_url['facebook']) or ! empty($social_url['instagram'])) {
			echo View::forge('front/social', array('data' => $social_url));
		}
	}
?>

<?php hp_news_view('down'); ?>

<?php get_footer(); ?>
