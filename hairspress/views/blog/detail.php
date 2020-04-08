<!-- ここから - コンテンツ -->
<main id="blog" class="c-wrap">
	<div class="container">
		<!-- <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2> -->

		<div class="row">
			<div class="col-xs-12 col-md-9">
				<?php
					if( !is_user_logged_in() and !isBot() ) {
						set_post_views( get_the_ID() );
					}
				?>
				<?php if( have_posts() ) : ?>
					<?php while( have_posts() ) : the_post(); ?>
						<article class="post-single">
							<div class="post-content">
								<header class="post-header">
									<h1 class="title"><?php the_title_attribute(); ?></h1>
									<div class="meta">
										<time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>
									</div>
									<div class="cat_tag clearfix">
										<?php hp_the_cat(array('separate' => '', 'container_before' => '<i class="fa fa-folder"></i>')); ?>
										<?php hp_the_cat(array('separate' => '', 'container_before' => '<i class="fa fa-tags"></i>', 'taxonomy' => 'post_tag', 'container_class' => 'tag')); ?>
									</div>
								</header>

								<section class="contents-body post-body">
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
								</section>

								<footer>
									<?php get_template_part('social', 'button'); ?>
								</footer>
							</div>
						</article>
					<?php endwhile; ?>
					<?php hp_single_pager(); ?>
					<div class="post-moreback">
						<a href="<?= get_post_type_archive_link('post'); ?>" class="btn btn-default btn-mid"><i class="fa fa-angle-left"></i><span>一覧へ戻る</span></a>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! isFacebook()) : ?>
			<div class="col-xs-12 col-md-3">
				<?php get_sidebar(); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</main>
<!-- /#blog -->