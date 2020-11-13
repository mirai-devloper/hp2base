<!-- ここから - コンテンツ -->

<div id="blog" class="c-wrap blog-archive">
	<div class="container">
		<h2 class="c-title-page">
			<span class="en">Blog</span>
			<span class="jp">ブログ</span>
		</h2>

		<div class="row blog-wrapper">
			<div class="col-xs-12 col-md-9">
				<?php hp_search_found(); ?>
				<?php if ( have_posts() ) : ?>
					<div class="post-archive-row">
						<?php while ( have_posts() ) : the_post(); ?>
							<article class="post-archive">
								<a href="<?php the_permalink(); ?>" class="post-link">
									<div class="thumb">
										<?php mio_get_thumbnail('square'); ?>
									</div>
									<div class="post-content">
										<div class="post-header">
											<h3 class="title"><?php the_title(); ?></h3>
											<div class="meta">
												<time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>

												<?php hp_cat_parent(array('anchor' => false)); ?>
											</div>
										</div>
										<?php //get_template_part('social', 'count'); ?>
										<div class="content"><?php the_excerpt(); ?></div>
										<div class="more">
											<div class="btn btn-default btn-sl">
												<span>つづきを読む</span><i class="fa fa-angle-right"></i>
											</div>
										</div>
									</div>
								</a>
							</article>
						<?php endwhile; ?>
					</div>
					<?php pagination(); ?>
				<?php else : ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>

			<div class="col-xs-12 col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<!-- /#blog -->