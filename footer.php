<footer id="footer">
	<?php if(HP_Social::option_url('prefix', 'social', 'option')) : ?>
	<div id="footerSocialButton" class="footer-social-button-wrap">
		<div class="container">
			<div class="row">
				<?= HP_Social::view('prefix', 'social', 'option', array('class' => 'social-icon list-inline')); ?>

				<div id="pagetop" class="pagetop-wrap">
					<a href="#drawer" class="pagetop btn btn-radius btn-shark"><i class="fa fa-angle-up"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /#footerSocialButton -->
	<?php endif; ?>

	<div id="footerContact" class="c-wrap footer-contact-wrap">
		<div class="container">
			<div class="row">
				<dl class="footer-contact">
					<dt>ご予約・お問い合わせ</dt>
					<?php if ($address = HP_Acf::get('hp_salon_address', 'option')) : ?>
						<dd>
							<?= esc_html($address); ?>
							<?php if (HP_Googlemap::mapdata()) : ?>
								&nbsp;[<?= HP_Googlemap::link(['text' => 'Google map']); ?>]
							<?php endif; ?>
						</dd>
					<?php endif; ?>

					<?php if ($opentime = HP_Acf::get('hairs_opens_text', 'option')) : ?>
						<dd><?= $opentime; ?></dd>
					<?php endif; ?>

					<?php if ($holiday = HP_Acf::get('hp_salon_holiday', 'option')) : ?>
						<dd>定休日　<?= $holiday; ?></dd>
					<?php endif; ?>
				</dl>

				<?php
					$salon_tel = HP_Acf::get('hp_salon_telephone', 'option');
					if ($freedial = HP_Acf::get('hp_salon_freedial', 'option'))
						$salon_tel = $freedial;

					$reserve_url = HP_Acf::reserve_url();
				?>
				<?php if ($salon_tel or $reserve_url) : ?>
				<div class="footer-link">
					<?php if ($salon_tel) : ?>
					<a href="tel:<?= esc_attr($salon_tel); ?>" class="btn btn-default btn-xl tel-link">
						<i class="fa fa-phone"></i><span><?= esc_html($salon_tel); ?></span>
					</a>
					<?php endif; ?>

					<?php if ($reserve_url) : ?>
						<a href="<?= esc_url($reserve_url); ?>" class="btn btn-default btn-xl"><i class="fa fa-desktop"></i><span>かんたんネット予約</span></a>
					<?php endif; ?>
				</div>
					<?php if (HP_Acf::get('hp_salon_freedial_region', 'option') and HP_Acf::get('hp_salon_telephone', 'option')) : ?>
						<?php $tel = HP_Acf::get('hp_salon_telephone', 'option'); ?>
					<div class="freedial-region-footer"><i class="fa fa-phone"></i>県外からおかけの方は、<a href="tel:<?= esc_attr($tel); ?>" class="tel-link"><?= esc_html($tel); ?></a>へおかけください。</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- /#footerContact -->

	<div id="footerNavi" class="footer-navi-wrap">
		<div class="container-fullid">
			<div class="row">
				<div class="col-md-9">
					<?php if( hp_nav_menu(array('theme_location' => 'primary-menu', 'echo' => 0)) ) : ?>
					<nav>
						<?php
							$nav_args = array(
								'theme_location' => 'primary-menu',
								'ul_class' => 'list-inline foot-navi'
							);
							hp_nav_menu($nav_args);
						?>
					</nav>
					<?php endif; ?>
				</div>

				<div class="col-md-3 footer-logo">
					<?php if(get_logo_id()) : ?>
					<a href="<?= esc_url(home_url()); ?>"><?php the_logo(); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<p class="copyright"><small>&copy; <?= HP_Options::year(); ?> <?= HP_Acf::copyright(); ?> All Rights Reserved.</small></p>
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
				<?= HP_Social::view('prefix', 'social', 'option', array('class' => 'social-icon drawer-social')); ?>
			</nav>
		</div>
	</div>
</div>

<?php
	$salon_tel = get_field('hp_salon_telephone', 'option');
	$freedial_false_tel = $salon_tel;
	if ($freedial = get_field('hp_salon_freedial', 'option'))
	{
		$salon_tel = $freedial;
	}

	$reserve_url = HP_Acf::reserve_url();

	$freedial_region = get_field('hp_salon_freedial_region', 'option');
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
			<a href="<?= esc_url($reserve_url); ?>" class="reserve">
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
