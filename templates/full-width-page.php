<?php
/**
 * Template Name: Full width
 * Template Post Type: page
 */
?>
<?php get_header(); ?>

<main id="main" class="layout-main">
	<?php while (have_posts()) : the_post(); ?>
		<article id="pageFullWidth" class="pfw">
			<section class="pfw-content">
				<div class="pfw-content__inner">
					<div class="pfw-container">
						<?php the_content(); ?>
					</div>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
