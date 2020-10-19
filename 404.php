<!--################################################################
################4444#########0000000000###################4444######
##############444444#######00000000000000###############444444######
############44444444#######00000####00000#############44444444######
##########4444##4444#######0000######0000###########4444##4444######
########4444####4444#######0000######0000#########4444####4444######
######4444######4444#######0000######0000#######4444######4444######
####4444########4444#######0000######0000#####4444########4444######
###44444444444444444444####0000######0000####44444444444444444444###
###44444444444444444444####0000######0000####44444444444444444444###
################4444#######00000####00000#################4444######
################4444#######00000000000000#################4444######
################4444#########0000000000###################4444######
#################################################################-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
	<?= Asset::css('404.css'); ?>
<style>
html,body {
	background-color: #fff;
}
</style>
</head>
<body <?php body_class(); ?>>
<div id="notFound" class="not-found">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php
					$logo = function_exists('get_field') ? get_field('hp_salon_logo', 'option') : '';
					if( !empty($logo) ) {
						$image_obj = wp_get_attachment_image_src( $logo, 'logo' );
						$image = sprintf(
							'<img src="%1$s" width="%2$s" height="%3$s" alt="%4$s">',
							esc_url($image_obj[0]),
							esc_attr($image_obj[1]),
							esc_attr($image_obj[2]),
							esc_attr(get_bloginfo())
						);
					} else {
						$image = get_bloginfo();
					}
				?>
				<h1><a href="<?= home_url('/'); ?>"><?= $image; ?></a></h1>
				<div class="error-body">
					<div class="error-head">
						<h2><span class="en">404 Not Found</span></h2>
						<p>ページが見つかりません</p>
						<?php if( is_user_logged_in() ) : ?>
							<div class="login">
								<p>ログイン中の場合は、<a href="<?= get_admin_url(); ?>">管理画面へ戻る</a></p>
							</div>
						<?php endif; ?>
					</div>

					<div class="error-content">
						<h3><span>何をお探しですか？</span></h3>
						<p>お探しのページが見つからなかったようです。</p>
						<p>URLをご入力頂いた場合は、入力頂いたURLをよくお確かめの上、再度アクセスしてみてください。<br>
							リンクから来られた場合は、ページもしくは記事が削除された可能性があります。</p>
							<p>お手数ではございますが、<a href="<?= home_url('/'); ?>">トップページへ戻る</a>か、下記のメニューよりお探し頂ますようお願い致します。</p>
					</div>

					<div class="error-menu">
						<?php
							$args = array(
								'theme_location' => 'primary-menu',
								'container' => 'div',
								'container_class' => 'e-gnavi',
								'items_wrap' => '<h3>サイトメニュー</h3><ul id = "%1$s" class = "%2$s">%3$s</ul>',
							);
							wp_nav_menu( $args );
						?>

						<?php
							$blog_args = array(
								'post_type' => 'post',
								'showposts' => 5
							);
							$blog = new WP_Query($blog_args);
						?>
						<?php if( $blog->have_posts() ) : ?>
							<div class="e-blog">
								<h3>ブログの新着</h3>
								<ul>
								<?php while( $blog->have_posts() ) : $blog->the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php
							$catalog_args = array(
								'post_type' => 'catalog',
								'showposts' => 5
							);
							$catalog = new WP_Query($catalog_args);
						?>
						<?php if( $catalog->have_posts() ) : ?>
							<div class="e-catalog">
								<h3>ヘアカタログの新着</h3>
								<ul>
								<?php while( $catalog->have_posts() ) : $catalog->the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fullid copycolor clearfix">
		<!-- <div class="row"> -->
			<div class="col-xs-12">
				<p class="col-xs-12 copyright"><small>&copy; <?= copyright_year(); ?> <?= copyright(); ?> All Rights Reserved.</small></p>
			</div>
		<!-- </div> -->
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
