
<?php get_header(); ?>

<?php if($concept = HP_Acf::get('hp_salon_concept', 'option')) : ?>
<div id="concept">
	<div class="container">
		<div class="concept">
			<div class="logo">
				<?php the_logo(); ?>
			</div>

			<div class="text">
				<?= $concept; ?>
			</div>
		</div>
	</div>
</div>
<!-- /#concept -->
<?php endif; ?>

<?php hp_news_view('up'); ?>


<?php if ( $freespace_check = HP_Acf::get('free_space_hidden', 'option') and have_rows('free_space', 'option')) : ?>
<div id="freespace" class="c-wrap freespace-wrap">
	<div class="container">
		<div class="row">
			<?php while (have_rows('free_space', 'option')) : the_row(); ?>
				<?php if (get_row_layout() === 'フリースペース' and get_sub_field('image')) : ?>
				<div class="col-sm-4">
					<figure class="freespace">
						<?php
							$url_customer = get_sub_field('url_customer');
							if ($url_customer) {
								$link = get_sub_field('url');
							} else {
								$link = get_sub_field('url_selector');
							}
							$target = '_self';
							if (get_sub_field('link_target')) {
								$target = '_blank';
							}
						?>
						<?php if ($link) : ?>
						<a href="<?= esc_url($link) ?>" target="<?= $target; ?>">
						<?php endif; ?>
							<?php if ($image = get_sub_field('image')) : ?>
							<?= wp_get_attachment_image($image, 'front-free-thumb'); ?>
							<?php else : ?>
							<span class="not-thumb"></span>
							<?php endif; ?>
							<?php if ($title = get_sub_field('link_text')) : ?>
							<figcaption><?= strip_tags($title); ?></figcaption>
							<?php endif; ?>
						<?php if ($link) : ?>
						</a>
						<?php endif; ?>
					</figure>
				</div>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<!-- /#freespace -->
<?php endif; ?>

<?php
	$post_args = array(
		'post_type'      => 'post',
		'order'          => 'DESC',
		'orderby'        => 'date',
		'posts_per_page' => 4,
		'ignore_sticky_posts' => true
	);
	$front_post = new WP_Query($post_args);
?>
<?php if( $front_post->have_posts() ) : ?>
<div id="frontBlog" class="c-wrap front-blog-wrap">
	<div class="container">
		<h2 class="c-title"><span class="en">Blog</span></h2>

		<div class="row">
		<?php while( $front_post->have_posts() ) : $front_post->the_post(); ?>
			<?php if( ! is_sticky()) : ?>
			<div class="col-sm-6 col-md-3">
				<article class="front-blog">
					<a href="<?php the_permalink(); ?>" class="inner">
						<?php echo hp_new_flag(); ?>
						<span class="thumb"><?php mio_get_thumbnail('front-free-thumb'); ?></span>
						<div class="body">
							<h2 class="title"><?php the_title_attribute(); ?></h2>
							<time datetime="<?php the_time('c'); ?>" class="datetime"><?php the_time('Y.m.d'); ?></time>
						</div>
					</a>
				</article>
			</div>
			<?php endif; ?>
		<?php endwhile; ?>
		</div>

		<div class="row">
			<div class="col-xs-12 front-blog-link">
				<?php
					$blog_link = ($pos = get_option('page_for_posts')) ? get_permalink($pos) : home_url();
				?>
				<a href="<?= esc_url($blog_link); ?>" class="btn btn-primary btn-lm"><i class="fa fa-angle-right"></i><span>サロンブログ一覧</span></a>
			</div>
		</div>
	</div>
</div>
<!-- /#frontBlog -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php
	$catalog_args = array(
		'post_type'      => 'catalog',
		'posts_per_page' => 20,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'ignore_sticky_posts' => true
	);
	$catalog_query = new WP_Query($catalog_args);
	if( $catalog_query->have_posts() ) :
?>
<div id="frontCatalog" class="c-wrap front-catalog-wrap">
	<div class="container">
		<h2 class="c-title"><span class="en">Catalog</span></h2>
	</div>
	<div class="container-fullid">
		<!-- <div class="row"> -->
		<div class="catalog-container swiper-container">
			<div class="catalog-swiper">
				<div class="swiper-wrapper">
					<?php while( $catalog_query->have_posts() ) : $catalog_query->the_post(); ?>
					<div class="swiper-slide">
						<div class="thumb">
							<?= hp_new_flag(); ?>
							<button class="btn-catalog-info"><i class="fa fa-info"></i></button>
							<a href="<?php the_permalink(); ?>">
								<?php mio_get_thumbnail('catalog-thumb'); ?>
								<div class="overlay">
									<div class="text">
										<h3 class="title"><?php the_title_attribute(); ?></h3>

										<p class="stylist"><?php hp_stylist_manage(); ?><span class="hidden-xs">：</span><br class="visible-xs"><span class="name"><?php hp_stylist_name(); ?></span></p>
									</div>
								</div>
							</a>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>

			<!-- Side Button -->
			<div class="catalog-list-prev swiper-button-prev"></div>
			<div class="catalog-list-next swiper-button-next"></div>

			<!-- Scrollbar -->
			<div class="catalog-scrollbar swiper-scrollbar"></div>
		</div>
		<!-- /.catalog-container -->

		<div class="row">
			<div class="col-xs-12 front-blog-link">
				<?php
					$pos = get_option('page_for_posts');
					$catalog_link = get_post_type_archive_link('catalog');
				?>
				<a href="<?php echo esc_url($catalog_link); ?>" class="btn btn-primary btn-lm"><i class="fa fa-angle-right"></i><span>カタログ一覧</span></a>
			</div>
		</div>
	</div>
	<!-- </div> -->
</div>
<!-- /#frontCatalog -->
<?php else : ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php if ( $social_url = HP_Social::option_url('prefix', 'social', 'option')) : ?>
<?php if ( ! empty($social_url['facebook']) or ! empty($social_url['instagram'])) : ?>
<div id="frontSocial" class="c-wrap front-social-wrap">
	<div class="container">
		<h2 class="c-title"><span class="en">Social</span></h2>
		<div class="row">
			<?php
				// $token = get_option('instagram_field');
				// $permission = get_option('instagram_permision');
			?>
			<?php
				if( $facebook = $social_url['facebook'] and ! empty($facebook) ) :
					$instacheck = empty($social_url['instagram']) ? 'col-sm-offset-3' : '';
			?>
			<div class="col-sm-6 col-md-6 <?= $instacheck; ?> facebook-plugin">
				<h4 class="social-heading"><span class="en">Facebook</span></h4>
				<div class="fb-page" data-href="<?= $facebook; ?>" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?= $facebook; ?>" class="fb-xfbml-parse-ignore"><a href="<?= $facebook; ?>">Facebook Page</a></blockquote></div>
			</div>
			<?php endif; ?>

			<?php
				if ($instagram = $social_url['instagram'] and ! empty($instagram)) :
					$fbcheck = empty($social_url['facebook']) ? 'col-sm-offset-3' : '';
			?>
			<div class="col-sm-6 col-md-6 <?= $fbcheck; ?>">
				<h4 class="social-heading"><span class="en">Instagram</span></h4>
				<div class="instagram-banner">
				<?php
					$hp_theme = get_option('options_hp_theme_name');
					$theme_name = 'mode';
					switch ($hp_theme)
					{
						default:
						case 'hp2mode':
							$theme_name = 'mode';
							break;
						case 'hp2antique':
							$theme_name = 'antique';
							break;
						case 'hp2organic':
							$theme_name = 'organic';
							break;
						case 'hp2sweet':
							$theme_name = 'sweet';
							break;
					}
				?>
					<a href="<?= esc_url($social_url['instagram']); ?>" target="_blank"><img src="<?= Assets::img('common/bnr_instagram_'.$theme_name.'.jpg'); ?>" alt=""></a>
				</div>
			</div>
<style>
.instagram-banner {
	padding-top: 8px;
}
.instagram-banner img {
	max-width: 100%;
	width: 100%;
	height: auto;
}
</style>
			<?php endif; ?>

			<?php
				// if( ! empty($token) and ($permission !== 'none' and ! empty($permission)) ) :
				// 	$fbcheck = empty($social_url['facebook']) ? 'col-sm-offset-3' : '';
			?>
			<!-- <div class="col-sm-6 col-md-6 <?= $fbcheck; ?>">
				<h4 class="social-heading"><span class="en">Instagram</span></h4>
				<div id="instagramJson">
					<div class="nowloading"><i class="fa fa-spinner fa-pulse"></i></div>
				</div>
			</div> -->
			<?php //endif; ?>
		</div>
	</div>
</div>
<!-- /#frontSocial -->
<?php endif; ?>
<?php endif; ?>



<?php hp_news_view('down'); ?>

<?php get_footer(); ?>
