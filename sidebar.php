<aside id="sidebar" class="sidebar">
	<?php
		dynamic_sidebar('blog-sidebar-top-widget');
	?>
	<div id="search-mio" class="widget widget_search">
		<form role="search" method="get" id="searchformMio" class="searchform" action="<?php echo home_url('/') ?>">
			<div>
				<input type="hidden" name="post_type" value="post">
				<input type="text" value="" name="s" id="s" placeholder="キーワード検索ができます">
				<button type="submit" id="searchsubmitMio">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</form>
	</div>

	<section id="widget-newpost" class="widget widget_newpost">
		<h4 class="widgettitle">新着記事</h4>
		<ul>
			<?php
				$new_post_args = array(
					'post_type'           => 'post',
					'orderby'             => 'date',
					'order'               => 'DESC',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => 3
				);
				$newpost = new WP_Query($new_post_args);
			?>
			<?php if( $newpost->have_posts() ) : ?>
				<?php while( $newpost->have_posts() ) : $newpost->the_post(); ?>
					<li>
						<div class="left">
							<a href="<?php the_permalink() ?>" class="thumb">
								<?php mio_get_thumbnail('square'); ?>
							</a>
						</div>
						<div class="right">
							<time datetime="<?php the_time('c') ?>"><span class="f-aleg_sc"><?php the_time('Y.m.d') ?></span></time>
							<a href="<?php the_permalink() ?>" class="title"><?= mio_get_excerpt(strip_tags(get_the_title()), 20); ?></a>
						</div>
					</li>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
	</section>
	<!-- /.widget_newpost -->

	<?php get_template_part( 'template-parts/side', 'popular-access' ); ?>

	<section id="widget-category" class="widget widget_categories">
		<h4 class="widgettitle">カテゴリー</h4>
		<ul>
			<?php
				$cat_arg = array(
					'title_li' => '',
					'show_count' => 1
				);
				wp_list_categories( $cat_arg );
			?>
		</ul>
	</section>

	<section id="widget-archive" class="widget widget_archive blog">
		<h4 class="widgettitle">アーカイブ</h4>
		<ul>
			<?php mio_the_archives_list('post'); ?>
		</ul>
	</section>
	<!-- /.widget_archive -->

	<?php
		$tags = get_terms('post_tag', 'hide_empty=1');
		if( $tags && !empty($tags) ) :
	?>
	<section id="widget-tagcloud" class="widget widget_tag_cloud blog">
		<h4 class="widgettitle">タグ</h4>
		<div class="tagcloud">
			<?php

				$str = '';
				foreach( $tags as $val ) {
					$str .= '<a href="'.get_tag_link($val->term_id).'">'.$val->name.'</a>';
					// <span class="count">'.$val->count.'</span>
				}
				echo $str;
			?>
		</div>
	</section>
	<!-- /.widget_archive -->
	<?php endif; ?>

	<?php
		dynamic_sidebar('blog-sidebar-bottom-widget');
	?>
</aside>
<!-- /#sidebar -->
