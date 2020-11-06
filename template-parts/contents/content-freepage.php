<!-- ここから - コンテンツ -->
<div id="blog" class="c-wrap">
	<div class="container">
		<!-- <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2> -->

		<div class="row">
			<div class="col-xs-12 col-md-10 col-md-push-1">
				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
				<article class="post-single">
					<section class="post-content">
						<header class="post-header">
							<h1 class="title"><?php the_title_attribute(); ?></h1>
						</header>

						<section class="contents-body">
							<?php the_content(); ?>
						</section>

						<footer>
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
							<?php get_template_part('social', 'button'); ?>
						</footer>
					</section>
				</article>
				<?php endwhile; ?>
				<?php else : ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</div>
<!-- /#blog -->
