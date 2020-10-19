<?php
	$pop_args = array(
		'post_type' => 'post',
		'posts_per_page' => 20,
		// 'meta_key' => 'post_views_count',
		// 'meta_value_num' => '100',
		// 'meta_compare' => '>=',
		'meta_query' => array(
			'view_count' => array(
				'key' => 'post_views_count',
				'value' => 1,
				'type' => 'numeric',
				'compare' => '>'
			)
		),
		'date_query' => array(
			array(
				'inclusive' => true,
				'after' => date('Y/n/j', strtotime('-1 month'))
			)
		),
		'orderby' => array(
			// 'date' => 'DESC',
			'view_count' => 'DESC',
		),
		// 'order' => 'DESC',
		'ignore_sticky_posts' => true
	);
	$pop_posts = new WP_Query( $pop_args );
	$pop_count = 0;
?>
<?php if( $pop_posts->have_posts() ) : ?>
<section id="widget-popular" class="widget widget_popular">
	<h4 class="widgettitle">人気の記事</h4>
	<ul>
	<?php while ( $pop_posts->have_posts() ) : $pop_posts->the_post(); ?>
		<?php if ($pop_count > 3) break; ?>
		<li>
			<div class="left">
				<a href="<?php the_permalink() ?>" class="thumb">
					<?php mio_get_thumbnail('square') ?>
				</a>
			</div>
			<div class="right">
				<time datetime="<?php the_time('c') ?>"><span class="f-aleg_sc"><?php the_time('Y.m.d') ?></span></time>
				<a href="<?php the_permalink() ?>" class="title"><?php echo mio_get_excerpt(strip_tags(get_the_title()), 25); ?></a>
				<span class="pop_view">Views: <?= get_post_meta(get_the_ID(), 'post_views_count', true) ?></span>
			</div>
		</li>
		<?php ++$pop_count; ?>
	<?php endwhile; ?>
	</ul>
</section>
<!-- /.widget_newpost -->
<?php else : ?>
<section id="widget-popular" class="widget widget_popular">
	<h4 class="widgettitle">人気の記事</h4>
	<ul>
		<li>
			<p style="font-size: 14px; text-align: center;">集計中</p>
		</li>
	</ul>
</section>
<!-- /.widget_newpost -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
<style>
.pop_view {
	display: block;
	font-size: 10px;
	color: #a8a8a8;
}
</style>