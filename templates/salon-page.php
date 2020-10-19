<?php
	global $wphp;
?>
<!-- ここから - コンテンツ -->
<div id="salon" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page">
			<span class="en">Salon Info</span><span class="jp">サロンについて</span>
		</h2>

		<div id="opentime" class="row salon-info">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<?php
					$salon_name = $wphp->hp_salon_name;
					$salon_name_kana = $wphp->hp_salon_name_kana;
					if ($salon_name or $salon_name_kana) :
				?>
					<h3 class="salon-name">
						<?php if ($salon_name) : ?>
							<span class="en"><?= $salon_name; ?></span>
						<?php endif; ?>
						<?php if ($salon_name_kana) : ?>
							<?php $slash = ($salon_name and ! empty($salon_name)) ? '<span class="slash">/</span>' : ''; ?>
							<span class="jp"><?= $slash.esc_html($salon_name_kana); ?></span>
						<?php endif; ?>
					</h3>
				<?php endif; ?>

				<table class="salon-info-table">
				<?php
					$salon_tel = $wphp->hp_salon_telephone;
					$salon_freedial = $wphp->hp_salon_freedial;
					if ($salon_tel or $salon_freedial) :
				?>
					<tr>
						<th>TEL</th>
						<td>
							<?php if ($salon_tel) : ?>
								<a href="tel:<?= esc_attr($salon_tel); ?>"><?= esc_html($salon_tel); ?></a>
								<?php if ($wphp->hp_salon_freedial_region and $wphp->hp_salon_telephone) : ?>
									<div class="freedial-region-salon-page">※ 県外からおかけの方は、上記番号からおかけください。</div>
								<?php endif; ?><?= ($salon_freedial) ? '<br>' : ''; ?>
							<?php endif; ?>
							<?php if ($salon_freedial) : ?>
								<a href="tel:<?= esc_attr($salon_freedial); ?>"><?= $salon_freedial; ?></a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ($salon_address = $wphp->hp_salon_address) : ?>
					<tr>
						<th>ACCESS</th>
						<td>
							<?php
								if ($wphp->hp_salon_postalcode) {
									echo '〒'.$wphp->hp_salon_postalcode.'　';
								}
								echo $salon_address;
							?>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ($salon_opentime = $wphp->hairs_access_opens) : ?>
					<tr>
						<th>OPEN</th>
						<td><?= $salon_opentime; ?></td>
					</tr>
				<?php endif; ?>

				<?php if ($salon_holiday = $wphp->hp_salon_holiday) : ?>
					<tr>
						<th>CLOSE</th>
						<td><?= $salon_holiday; ?></td>
					</tr>
				<?php endif; ?>
				</table>
			</div>
		</div>
		<!-- /.row -->

		<?php
			$salon_photo = $wphp->hp_salon_shop_photo;
			$salon_map_image = $wphp->hairs_mapimg_url;
			if ($salon_photo or $salon_map_image) :
		?>
			<div class="row salon-photo-map">
				<?php if ($salon_photo) : ?>
					<div class="col-xs-12 col-sm-6">
						<div class="item"><?= wp_get_attachment_image($salon_photo, 'salon-info'); ?></div>
					</div>
				<?php endif; ?>

				<?php if ($salon_map_image) : ?>
					<div class="col-xs-12 col-sm-6">
						<div class="item"><?= wp_get_attachment_image($salon_map_image, 'salon-info-map'); ?></div>
					</div>
				<?php endif; ?>
			</div>
			<!-- /.row -->
		<?php endif; ?>

		<?php if ($googlemap = $wphp->hp_salon_google_map) : ?>
			<div id="accessmap" class="row salon-access-map">
				<div class="col-xs-12">
					<div class="salon-access-flex">
						<h2 class="salon-access-title">
							<span class="en">Access</span>
						</h2>
						<?= google_map_link(array('class' => 'mapApp btn btn-default btn-ls', 'icon' => '<i class="fa fa-angle-right"></i>')); ?>
					</div>

					<div class="acf-map">
						<?php
							$zoom = 16;
							if ($_zoom = $wphp->hp_salon_google_map_zoom) {
								$zoom = $_zoom;
							}
						?>
						<div class="marker" data-lat="<?= esc_attr($googlemap['lat']); ?>" data-lng="<?= esc_attr($googlemap['lng']); ?>" data-zoom="<?= esc_attr($zoom); ?>">
							<?php if ($logo_id = $wphp->hp_salon_logo) : ?>
								<?= wp_get_attachment_image($logo_id, 'logo'); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($route = $wphp->hairs_route_text) : ?>
			<div class="salon-access-route"><?= $route; ?></div>
		<?php endif; ?>
	</div>
	<!-- /.container -->
</div>
<!-- /#menu -->