<?php
	global $wphp;

	$sliders = get_transient('hairspress_front_hpSlider');
	if ($sliders === false) {
		$hpSlider = $wphp->hpSlider;
		if ($hpSlider and isset($hpSlider['images'])) {
			$sliders = $hpSlider['images'];
			set_transient('hairspress_front_hpSlider', $sliders, 300);
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
							if (isset($slider['id'])) {
								$slider_id = $slider['id'];
							} elseif (isset($slider['image'])) {
								$slider_id = $slider['image'];
							}
							// $meta = get_post($slider_id);
						?>
						<div class="pogoSlider-slide">
							<div class="slider__content-item">
								<?= wp_get_attachment_image($slider_id, 'mio-slider-large'); ?>
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