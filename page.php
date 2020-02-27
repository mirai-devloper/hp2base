<?php get_header(); ?>

<!-- ここから - コンテンツ -->
<div id="pageDefault" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page"><span class="en"><?php single_post_title(); ?></span></h2>

		<div class="page-default">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- /#menu -->

<?php get_footer(); ?>
