<?php get_header(); ?>



<div id="page-<?php the_ID(); ?>" class="page-normal">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<h2 class="c-title-page">
				<span class="en"><?php the_title(); ?></span>
			</h2>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
