<?php

/*--- ロゴに関する関数 ---*/
function get_logo_id() {
	global $wphp;
	return $wphp->hp_salon_logo;
}
function get_logo($size = 'logo') {
	$img_id = get_logo_id();
	$attachment = wp_get_attachment_image_src($img_id, $size);
	return $attachment;
}
function the_logo($size = 'logo') {
	global $wphp;

	$salon_logo = $wphp->hp_salon_logo;
	$logo = apply_filters('hairspress_salon_logo', $salon_logo);
	$attachment = wp_get_attachment_image($logo, $size);
	if($attachment) {
		echo $attachment;
	}
}

/*--- コンセプトに関する関数 ---*/
function get_concept() {
	global $wphp;
	return $wphp->hp_salon_concept;
}
function the_concept() {
	echo get_concept();
}

function copyright() {
	global $wphp;

	if ($copyright = $wphp->hp_salon_name and $copyright) {
		return $copyright;
	}

	return 'HairsPress';
}

function copyright_year() {
	global $wphp;
	$year = $wphp->hp_install_year;
	$to_year = (int) date_i18n('Y');
	$output = sprintf(
		'<span>%1$s%2$s</span>',
		$year,
		($year < $to_year ? '-' . $to_year : '')
	);

	return $output;
}

add_action('after_theme_setup', function() {
	global $wphp;

	if (!$wphp->hp_install_year) {
		update_option('hp_install_year', date_i18n('Y'));
	}
});


function money($num) {
	return number_format(mb_ereg_replace('[^0-9]', '', mb_convert_kana($num, 'n')));
}


function reserve_button($url = null, $text = 'ネット予約はこちら', $attr = array()) {
	if (empty($url)) return;

	$defaults = array(
		'href' => $url,
		'class' => 'btn btn-default btn-ls',
		'target' => '_blank',
	);
	$attr = wp_parse_args($attr, $defaults);

	$icons = array(
		'right' => '<i class="fa fa-angle-right"></i>',
		'pc' => '<i class="fa fa-desktop"></i>',
	);
	return html_tag('a', $attr, $icons['right'].$text);
	// return sprintf(
	// 	'<a href="%s" class="btn btn-default btn-ls" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>',
	// 	esc_url($url)
	// );
}

function reserve_url() {
	global $wphp;
	$system = $wphp->hp_webreserve_system;
	$reservia = $wphp->hp_salon_reservia;
	$url = $wphp->hp_salon_reserved;

	$result = null;

	switch ($system) {
		case 'reservia':
			if (!empty($reservia) and ctype_digit($reservia)) {
				$result = "https://cs.appnt.me/shops/{$reservia}/reserve";
			}
			break;
		case 'reservia_new':
			if (!empty($reservia) and ctype_digit($reservia)) {
				// https://reservia.jp/reserve/login/5687
				// $result = "https://reservia.jp/shop/reserve/{$reservia}";
				$result = "https://reservia.jp/reserve/login/{$reservia}";
			}
			break;
		case 'other':
			if ($url) {
				$result = $url;
			}
			break;
		default:
			// default
			break;
	}

	return $result;
}