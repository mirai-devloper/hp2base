<?php
	global $wphp;

	$footer_social = false;

	if (
		$wphp->hp_salon_social_facebook
		or $wphp->hp_salon_social_instagram
		or $wphp->hp_salon_social_twitter
		or $wphp->hp_salon_social_line
		or $wphp->hp_salon_social_youtube
		or $wphp->hp_salon_social_pinterest
	) {
		$footer_social = true;
	}
?>
<footer id="footer">
	<?php if($footer_social) : ?>
		<div id="footerSocialButton" class="footer-social-button-wrap">
			<div class="container">
				<?php get_template_part('template-parts/site-social'); ?>
				<div id="pagetop" class="pagetop-wrap">
					<a href="#drawer" class="pagetop btn btn-radius btn-shark"><i class="fa fa-angle-up"></i></a>
				</div>
			</div>
		</div>
		<!-- /#footerSocialButton -->
	<?php endif; ?>

	<div id="footerContact" class="c-wrap footer-contact-wrap">
		<div class="container">
			<dl class="footer-contact">
				<dt>ご予約・お問い合わせ</dt>
				<?php if ($address = $wphp->hp_salon_address) : ?>
					<dd>
						<?= esc_html($address); ?>
						<?php if ($mapdata = $wphp->hp_salon_google_map) : ?>
							&nbsp;[<?= google_map_link(['text' => 'Google map']); ?>]
						<?php endif; ?>
					</dd>
				<?php endif; ?>

				<?php if ($opentime = $wphp->hairs_opens_text) : ?>
					<dd><?= $opentime; ?></dd>
				<?php endif; ?>

				<?php if ($holiday = $wphp->hp_salon_holiday) : ?>
					<dd>定休日　<?= $holiday; ?></dd>
				<?php endif; ?>
			</dl>

			<?php
				$salon_tel = $wphp->hp_salon_telephone;
				if ($freedial = $wphp->hp_salon_telephone) {
					$salon_tel = $freedial;
				}

				$reserve_url = reserve_url();
			?>
			<?php if ($salon_tel or $reserve_url) : ?>
				<div class="footer-link">
					<?php if ($salon_tel) : ?>
						<a href="tel:<?= $salon_tel; ?>" class="btn btn-default btn-xl tel-link">
							<i class="fa fa-phone"></i><span><?= $salon_tel; ?></span>
						</a>
					<?php endif; ?>

					<?php if ($reserve_url) : ?>
						<a href="<?= esc_url($reserve_url); ?>" class="btn btn-default btn-xl" target="_blank">
							<i class="fa fa-desktop"></i><span>かんたんネット予約</span>
						</a>
					<?php endif; ?>
				</div>
				<?php if ($wphp->hp_salon_freedial_region and $wphp->hp_salon_telephone) : ?>
					<div class="freedial-region-footer">
						<i class="fa fa-phone"></i>県外からおかけの方は、<a href="tel:<?= esc_attr($wphp->hp_salon_telephone); ?>" class="tel-link"><?= esc_html($wphp->hp_salon_telephone); ?></a>へおかけください。
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<!-- /#footerContact -->

	<div id="footerNavi" class="footer-navi-wrap">
		<div class="container-fullid">
			<div class="footer-navi__row">
				<div class="footer-navi__main">
					<?php
						$nav_args = array(
							'theme_location' => 'primary-menu',
							'ul_class' => 'list-inline foot-navi'
						);
						hp_nav_menu($nav_args);
					?>
				</div>

				<div class="footer-navi__logo footer-logo">
					<?php if(get_logo_id()) : ?>
						<a href="<?= home_url('/'); ?>"><?php the_logo(); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<p class="copyright"><small>&copy; <?= copyright_year(); ?> <?= copyright(); ?> All Rights Reserved.</small></p>
		</div>
	</div>
</footer>

</div></div></div><!-- /#drawer -->

<!-- ドロワーメニュー -->
<div id="drawerNavi" class="drawer-navi drawer-right hidden-md hidden-lg">
	<!-- ドロワーメニューボタン -->
	<button id="btnDrawer" class="drawer-btn hidden-md hidden-lg">
		<div class="bars">
			<span class="bar"></span>
			<span class="bar"></span>
			<span class="bar"></span>
		</div>
		<span class="text">MENU</span>
	</button>

	<div class="logo-area">
		Page Menu
		<button id="btnDrawerClose" class="drawer-btn-close"><i class="fa fa-close"></i></button>
	</div>

	<div class="drawer-inner">
		<div class="drawer-back">
			<nav>
				<?php
					$nav_args = array(
						'theme_location' => 'primary-menu',
						'ul_class' => 'drawer-gnavi'
					);
					hp_nav_menu($nav_args);
				?>

				<?php
					if ($access = get_page_by_path('access'))
						$pages = $access->ID;

					else if ($salon = get_page_by_path('salon'))
						$pages = $salon->ID;
				?>
				<?php if (isset($pages)) : ?>
				<ul class="drawer-subnavi">
					<li><a href="<?= get_permalink($pages); ?>#opentime"><i class="fa fa-clock-o"></i><span>営業時間</span></a></li>
					<li><a href="<?= get_permalink($pages); ?>#accessmap"><i class="fa fa-map-marker"></i><span>アクセス</span></a></li>
				</ul>
				<?php endif; ?>
				<?php get_template_part('template-parts/site-social'); ?>
			</nav>
		</div>
	</div>
</div>

<?php
	$salon_tel = $wphp->hp_salon_telephone;
	$freedial_false_tel = $salon_tel;
	if ($freedial = $wphp->hp_salon_freedial and $freedial)
	{
		$salon_tel = $freedial;
	}

	$reserve_url = reserve_url();

	$freedial_region = $wphp->hp_salon_freedial_region;
?>
<?php if ($salon_tel or $reserve_url) : ?>
<div id="spFixedContact" class="sp-fixed-contact">
	<div class="sp-fixed-contact-inner">
		<?php if ($salon_tel) : ?>
		<div class="item">
			<a href="tel:<?= $salon_tel; ?>" class="tel">
				<i class="fa fa-phone"></i><span class="txt">電話で予約</span>
			</a>
		</div>
		<?php endif; ?>

		<?php if ($freedial_region and $freedial_false_tel) : ?>
		<div class="item">
			<div class="freedial-false">
				<a href="tel:<?= $freedial_false_tel; ?>" class="kengai">
					<i class="fa fa-phone"></i><span class="txt">県外からお掛けの方</span>
				</a>
			</div>
		</div>
		<?php endif; ?>

		<?php if ($reserve_url) : ?>
		<div class="item">
			<a href="<?= esc_url($reserve_url); ?>" class="reserve" target="_blank">
				<i class="fa fa-mobile"></i><span class="txt">ネットで予約</span>
			</a>
		</div>
		<?php endif; ?>
	</div>
</div>
<!-- /#spFixedContact -->
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/object-fit-images/3.2.4/ofi.min.js"></script>
<script>objectFitImages();</script>
<?php Demo::init(); // デモモード ?>
<?php wp_footer(); ?>
</body>
</html>
