<?php
	$sliders = get_transient('hairspress_front_slider');
	if ($sliders === false) {
		$sliders = get_field('hp_slider_settings', 'option');
		set_transient('hairspress_front_slider', $sliders, 3600);
		if ($hpSlider = get_field('hpSlider', 'option') and $hpSlider) {
			$sliders = array();
			if (isset($hpSlider['images'])) {
				foreach ($hpSlider['images'] as $slider) {
					$sliders[] = array(
						'id' => $slider['image']
					);
				}
				set_transient('hairspress_front_slider', $sliders, 3600);
			}
		}
	}

?>
<?php if ( ! empty($sliders)) : ?>
<div id="mainVisual">
	<div class="container-hps">
		<div class="slider__wrapper">
			<div id="hpSlider" class="slider__content">
				<div class="pogoSlider pogoSlider-inner">
					<?php foreach ($sliders as $slider) : ?>
						<?php
							$meta = get_post($slider['id']);
						?>
						<div class="pogoSlider-slide">
							<div class="slider__content-item">
								<?= wp_get_attachment_image($slider['id'], 'mio-slider-large'); ?>
							</div>
							<?php if (isset($meta->post_content) and ! empty($meta->post_content)) : ?>
								<p class="pogoSlider-slide-element pogoSlider-slider-description" data-in="slideRight" data-out="slideLeft" data-duration="750" data-delay="500">
									<?= esc_html($meta->post_content); ?>
								</p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>