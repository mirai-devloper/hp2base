<?php
	$has_blocks = has_blocks(get_post(get_the_ID())) ? 'has-blocks' : '';
?>
<!-- ここから - コンテンツ -->
<main id="freepage" class="c-wrap page-freepage <?= $has_blocks; ?>">
	<!-- <div class="container"> -->
		<!-- <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2> -->
	<div class="<?= $has_blocks; ?>">
		<article class="post-wrapper">
			<?php while (have_posts()) : the_post(); ?>
				<?php if ($has_blocks !== 'has-blocks') : ?>
					<header class="entry-header"><!-- post-header  -->
						<h1 class="title"><?php the_title(); ?></h1>
					</header>
				<?php endif; ?>
				<div class="entry-content"><!-- contents-body post-body -->
					<?php the_content(); ?>
					<?php
						$pages_args = array(
							'before' => '<div class="link-pages-wrapper"><span class="link-pages-title">ページ</span>',
							'after' => '</div>',
							'link_before' => '<span>',
							'link_after' => '</span>',
							'separator' => ''
						);
						wp_link_pages( $pages_args );
					?>
				</div>
			<?php endwhile; ?>
		</article>
	</div>
</main>
<!-- /#blog -->
