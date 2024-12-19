<?php
	global $wphp, $hp_nav_menu;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php if ( is_single() or is_singular()) : ?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<?php else : ?>
<head>
<?php endif; ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php
	// <meta name="apple-itunes-app" content="app-id=724108890,app-argument=reservia://param=1">
	?>
	<?= google_search_console(); ?>

	<!-- <script src="https://kit.fontawesome.com/47c26e3652.js" crossorigin="anonymous"></script> -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= get_theme_file_uri('font-awesome/css/font-awesome.min.css'); ?>">
	<?php wp_head(); ?>

  <?php if ($ga4 = ga_ga4_id() and $ga4) : ?>
    <script>var ga4_id = '<?= $ga4; ?>';</script>
  <?php endif; ?>
	<?php if ($tc = ga_tracking_code() and $tc) : ?>
	<script>var tracking_id = '<?= $tc; ?>';</script>
	<?php endif; ?>
  <?php if (ga_tracking_code() or ga_ga4_id()) : ?>
  <!-- Google Tag Manager -->
	<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-KLD699"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KLD699');</script>
	<!-- End Google Tag Manager -->
  <?php endif; ?>
</head>
<body <?php body_class(\Demo::body_class()); ?>>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v6.0&appId=1505451772876041&autoLogAppEvents=1"></script>

<!-- ドロワーメニュー用のオーバーレイ -->
<div id="drawerOverlay" class="hidden-md hidden-lg"></div>

<!-- ドロワー用コンテンツボックス -->
<div id="drawer"><div id="drawerContent"><div class="drawer-content-back">
<div class="pointer"></div>
<!-- ヘッダー -->
<header>
	<div id="header" class="header">
	<div class="header-top">
		<div class="container-fullid header-top__inner">
			<div class="header-top__row">
				<div class="header-top__title">
					<h1 class="site-title"><?php
						bloginfo('description');
						if (get_bloginfo('description') and get_bloginfo('name'))
						{
							echo ' | ';
						}
						bloginfo('name');
					?></h1>
				</div>
				<div class="header-top__nav">
					<?php get_template_part('template-parts/site-social'); ?>
					<?php
						if ($access = get_page_by_path('access')) {
							$pages = $access->ID;
						} elseif ($salon = get_page_by_path('salon')) {
							$pages = $salon->ID;
						}
					?>
					<?php if (isset($pages)) : ?>
					<ul class="subnavi">
						<li>
							<a href="<?= get_permalink($pages); ?>#opentime"><i class="fa fa-clock-o"></i><span>営業時間</span></a>
						</li>
						<li>
							<a href="<?= get_permalink($pages); ?>#accessmap"><i class="fa fa-map-marker"></i><span>アクセス</span></a>
						</li>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="header-middle">
		<div class="container-fullid header-middle__inner">
			<div class="header-middle__row">
				<div class="header-middle__logo">
					<div class="site-logo">
						<a href="<?= home_url('/'); ?>"><?php get_logo_id() ? the_logo() : bloginfo('title'); ?></a>
					</div>
				</div>

				<?php
					$salon_tel = $wphp->hp_salon_telephone;
					if ($freedial = $wphp->hp_salon_freedial) {
						$salon_tel = $freedial;
					}

					$reserve_url = reserve_url();
				?>
				<?php if ($salon_tel or $reserve_url) : ?>
				<div class="header-middle__button">
					<div class="header-button-area">
						<ul class="header-contact">
							<?php if ($salon_tel) : ?>
							<li>
								<a href="tel:<?= esc_attr($salon_tel); ?>" class="btn btn-default btn-xl tel-link">
									<i class="fa fa-phone"></i><span><?= esc_html($salon_tel); ?></span>
								</a>
							</li>
							<?php endif; ?>
							<?php if ($reserve_url) : ?>
							<li>
								<a href="<?= esc_url($reserve_url); ?>" class="btn btn-default btn-xl" target="_blank"><i class="fa fa-desktop"></i><span>かんたんネット予約</span></a>
							</li>
							<?php endif; ?>
						</ul>
						<?php if ($wphp->hp_salon_freedial_region and $wphp->hp_salon_telephone) : ?>
							<div class="freedial-region"><i class="fa fa-phone"></i>県外からおかけの方は、<a href="tel:<?= $wphp->hp_salon_telephone; ?>" class="tel-link"><?= $wphp->hp_salon_telephone; ?></a>へおかけください。</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- /.container -->
	</div>

	<div id="gNavi" class="gnavi-block hidden-xs hidden-sm visible-md visible-lg">
		<div class="container-fullid">
			<div class="">
				<nav>
					<?php
						$nav_args = array(
							// 'theme_location' => 'primary-menu',
							'ul_class' => array(
								'class' => 'gnavi list-table',
							),
						);
						// hp_nav_menu($nav_args);
						echo $hp_nav_menu->menu_list($nav_args);
					?>
				</nav>
			</div>
		</div>
	</div>
	<!-- /#gNavi -->
</header>

<!-- MainVisual -->
<?php do_action('hairspress_slider'); ?>


<?php if($salon_tel or $reserve_url) : ?>
	<div id="spContact" class="contact-sp">
		<ul class="contact">
			<?php if($salon_tel) : ?>
				<li class="tel">
					<?= html_tag('a', array('href' => 'tel:'.esc_attr($salon_tel)), '<i class="fa fa-phone"></i><span>電話で予約</span>'); ?>
				</li>
			<?php endif; ?>
			<?php if($reserve_url) : ?>
				<li class="web-reserve">
					<?= html_tag('a', array('href' => esc_attr($reserve_url), 'target' => '_blank'), '<i class="fa fa-mobile"></i><span>ネットで予約</span>'); ?>
				</li>
			<?php endif; ?>
		</ul>
	</div>
	<?php if ($wphp->hp_salon_freedial_region and $wphp->hp_salon_telephone) : ?>
		<div class="freedial-region-sp">
			<i class="fa fa-phone"></i>県外からおかけの方は、<?= html_tag('a', array('href' => 'tel:'.esc_attr($wphp->hp_salon_telephone)), esc_html($wphp->hp_salon_telephone)); ?>へおかけください。
		</div>
	<?php endif; ?>
	<!-- /#spContact -->
<?php endif; ?>

<?php if( ! is_front_page() ) : ?>
<!-- パンくずリスト -->
<div id="breadcrumb" class="breadcrumb">
	<div class="container">
		<div class="row">
			<div class="bread-container">
				<!-- ※モバイルに合わせてカルーセルにしてます -->
				<?php breadcrumbs(array('class' => 'bread-list list-inline swiper-wrapper')); ?>
			</div>
		</div>
	</div>
</div>
<!-- /#breadcrumb -->
<?php endif; ?>
