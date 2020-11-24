<?php
	$has_blocks = has_blocks(get_post(get_the_ID())) ? 'has-blocks' : '';
	$full_width = (isset($args['full-width']) and $args['full-width']) ? 'full' : '';
?>
<!-- ここから - コンテンツ -->
<main id="blog" class="c-wrap">
	<!-- <div class="container"> -->
		<!-- <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2> -->
	<div class="entry-row <?= $has_blocks; ?> <?= $full_width; ?>">
		<div class="post-wrapper">
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<article class="post-single">
						<div class=""><!-- post-content -->
							<header class="entry-header"><!-- post-header  -->
								<h1 class="title"><?php the_title(); ?></h1>
								<div class="entry-header__row">
									<!-- <div class="cat_tag"> -->
									<div class="category">
										<?php hp_the_cat(array('separate' => '', 'container_before' => '<i class="fa fa-folder"></i>')); ?>
										<?php hp_the_cat(array('separate' => '', 'container_before' => '<i class="fa fa-tags"></i>', 'taxonomy' => 'post_tag', 'container_class' => 'tag')); ?>
									</div>
									<div class="meta">
										<time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>
									</div>
								</div>
							</header>

							<section class="entry-content"><!-- contents-body post-body -->
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
								<?php if (is_active_sidebar('blog-content-bottom')) : ?>
									<div id="entryContentWidgetBottom" class="entry-content-widget-bottom">
										<?php dynamic_sidebar('blog-content-bottom'); ?>
									</div>
								<?php else : ?>
									<?php if (is_user_logged_in()) : ?>
										<p class="text-center" style="border: 1px dotted #666;padding: 1em;color:#888;"><strong>ログイン中のユーザーに表示しています。</strong><br>ここに共通となるウィジェットが設定できるようになりました。<br><a href="<?= admin_url('widgets.php'); ?>" class="btn btn-primary">ウィジェットを編集する</a></p>
									<?php endif; ?>
								<?php endif; ?>
							</section>

							<footer class="entry-footer">
								<?php get_template_part('template-parts/social', 'button'); ?>
							</footer>
						</div>

						<?php
							if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
								?>
								<div class="comments-wrapper section-inner">
									<?php comments_template(); ?>
								</div><!-- .comments-wrapper -->
								<?php
							}
						?>
					</article>
				<?php endwhile; ?>
				<?php hp_single_pager(); ?>
				<div class="post-moreback">
					<a href="<?= get_post_type_archive_link('post'); ?>" class="btn btn-default btn-mid"><i class="fa fa-angle-left"></i><span>一覧へ戻る</span></a>
				</div>
			<?php endif; ?>
		</div>

		<div class="post-sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<!-- /#blog -->
