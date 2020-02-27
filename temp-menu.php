<?php
	$title_str = 'hp-menupage-'.get_the_ID();
	$menu_list = get_field('hp_menu_list');
	$remarks = get_field('hp_menu_other_text');
?>
<?php if ($menu_list and ! empty($menu_list)) : ?>
<div id="<?= $title_str; ?>" class="col-xs-12">
  <h3 class="menu-title">
		<span class="en"><?php the_title_attribute(); ?></span>
		<?php if ($kana = get_field('hp_menu_kananame', get_the_ID()) and ! empty($kana)) : ?>
			<span class="ja"><span class="slash">/</span><?= strip_tags($kana); ?></span>
		<?php endif; ?>
	</h3>

  <div class="menu-container">
		<?php foreach ((array) $menu_list as $menu) : ?>
		<div class="menu-flex">
			<div class="menu-left">
				<span class="menu-name"><i class="fa fa-angle-right"></i><?= $menu['menu_name']; ?></span>
				<?php if ( ! empty($menu['menu_etc_text'])) : ?>
					<span class="menu-etc-text"><?= $menu['menu_etc_text'] ?></span>
				<?php endif; ?>
			</div>
			<div class="menu-right">
				<?php if ( ! empty($menu['menu_time'])) : ?>
				<div class="menu-time">
						<span class="menu-time-text">施術時間</span><span class="menu-time-num"><?= $menu['menu_time'] ?>分</span>
				</div>
				<?php endif; ?>
				<div class="menu-price">
					<?php if ( ! empty($menu['menu_price'])) : ?>
						<span class="yen">&yen;</span>
						<span class="money"><?= number_format($menu['menu_price']) ?></span>
						<?php if ($menu['menu_kara']) : ?>
							<span class="kara">〜</span>
							<?php if (! empty($menu['menu_price_end'])) : ?>
								<span class="money"><?= number_format($menu['menu_price_end']); ?></span>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>

		<?php if ( ! empty($remarks)) : ?>
		<div class="menu-other-text"><?= $remarks ?></div>
		<?php endif; ?>
  </div>
</div>
<?php endif; ?>