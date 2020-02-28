<div id="frontSocial" class="front-social">
	<div class="container">
		<h2 class="c-title"><span class="en">Social</span></h2>
		<div class="front-social__row">
			<?php if( $facebook = $data['facebook'] and ! empty($facebook) ) : ?>
				<div class="front-social__item">
					<h4 class="title"><span class="en">Facebook</span></h4>
					<div class="content">
						<div class="fb-page" data-href="<?= $facebook; ?>" data-tabs="" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?= $facebook; ?>" class="fb-xfbml-parse-ignore"><a href="<?= $facebook; ?>"><?php bloginfo('name'); ?></a></blockquote></div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($instagram = $data['instagram'] and ! empty($instagram)) : ?>
				<div class="front-social__item">
					<h4 class="title"><span class="en">Instagram</span></h4>
					<div class="content">
						<div class="instagram-banner">
							<?php
								$hp_theme = get_option('options_hp_theme_name');
								$theme_name = 'mode';
								if ($hp_theme) {
									$theme_name = str_replace('hp2', '', $hp_theme);
								}
							?>
							<a href="<?= esc_url($instagram); ?>" target="_blank"><?= Asset::img("common/bnr_instagram_{$theme_name}.jpg"); ?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- /#frontSocial -->