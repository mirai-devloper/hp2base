<?php
	global $wphp;

	$site_social = array(
		'instagram' => $wphp->hp_salon_social_instagram,
		'twitter'   => $wphp->hp_salon_social_twitter,
		'facebook'  => $wphp->hp_salon_social_facebook,
		'youtube'   => $wphp->hp_salon_social_youtube,
		'pinterest' => $wphp->hp_salon_social_pinterest,
		'line'      => $wphp->hp_salon_social_line,
	);

	$lists = false;
	foreach ($site_social as $k => $v) {
		if ($lists === false) $lists = '';
		if ($v) {
			$lists .= '<li><a href="'.esc_url($v).'" target="_blank"><span>'.$k.'</span></a></li>';
		}
	}
?>
<?php if (!empty($lists)) : ?>
	<ul class="social-icon">
		<?= $lists; ?>
	</ul>
<?php endif; ?>