<?php
/**
 * Template Name: Full width
 * Template Post Type: post, page
 */
?>
<?php get_header(); ?>

<main id="main" class="layout-main">
	<?php while (have_posts()) : the_post(); ?>
		<?php
			$excerpt = get_the_excerpt();
		?>
		<article id="pageFullWidth" class="pfw">
			<header class="pfw-header">
				<div class="pfw-container">
					<h1 class="pfw-header__title"><?php the_title(); ?></h1>
				</div>
			</header>
			<section class="pfw-content">
				<div class="pfw-content__inner">
					<div class="pfw-container">
						<?php if ($excerpt !== '') echo $excerpt; ?>
						<?php the_content(); ?>
					</div>
				</div>
			</section>
			<footer class="pfw-footer">

			</footer>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
