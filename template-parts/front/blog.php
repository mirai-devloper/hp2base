<?php
	$blog = get_transient('hairspress_front_blog');
	if ($blog === false) {
		$blog_args = array(
			'post_type'           => 'post',
			'order'               => 'DESC',
			'orderby'             => 'date',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true
		);
		$blog = new WP_Query($blog_args);
		set_transient('hairspress_front_blog', $blog, 180);
	}
?>
<?php if($blog->have_posts()) : ?>
<div id="frontBlog" class="front-blog">
	<div class="container">
		<h2 class="c-title"><span class="en">Blog</span></h2>

		<div class="front-blog__row">
		<?php while( $blog->have_posts() ) : $blog->the_post(); ?>
			<div class="front-blog__item">
				<article class="front-blog__article">
					<a href="<?php the_permalink(); ?>" class="front-blog__article-link">
						<?= hp_new_flag(); ?>
						<div class="thumb"><?php mio_get_thumbnail('front-free-thumb'); ?></div>
						<div class="body">
							<h2 class="title"><?php the_title_attribute(); ?></h2>
							<time datetime="<?php the_time('c'); ?>" class="datetime"><?php the_time('Y.m.d'); ?></time>
						</div>
					</a>
				</article>
			</div>
		<?php endwhile; ?>
		</div>

		<div class="row">
			<div class="front-blog__more">
				<a href="<?= get_post_type_archive_link('post'); ?>" class="btn btn-primary btn-lm"><i class="fa fa-angle-right"></i><span>サロンブログ一覧</span></a>
			</div>
		</div>
	</div>
</div>
<!-- /#frontBlog -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>