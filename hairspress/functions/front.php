<?php

add_action('hairspress_concept', function($concept) {
	if (!empty($concept)) {
?>
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
<?php
	}
});


function hairspress_instagram_banner($hp_theme) {
	$theme_name = str_replace('hp2', '', $hp_theme);
	if (empty($theme_name)) $theme_name = 'mode';

	$filepath = sprintf(
		'common/bnr_instagram_%1$s.jpg',
		$theme_name
	);
	$banner = apply_filters('hairspress_instagram_banner_path', $filepath, $theme_name);
	return $banner;
}
