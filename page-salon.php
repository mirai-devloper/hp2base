<?php
/*
Template Name: Access pages
*/
get_header(); ?>

<!-- ここから - コンテンツ -->
<div id="salon" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page"><span class="en">Salon Info</span><span class="jp">サロンについて</span></h2>

		<div id="opentime" class="row salon-info">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<?php
					$salon_name = HP_Acf::get('hp_salon_name', 'option');
					$salon_name_kana = HP_Acf::get('hp_salon_name_kana', 'option');
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
					$salon_tel = HP_Acf::get('hp_salon_telephone', 'option');
					$salon_freedial = HP_Acf::get('hp_salon_freedial', 'option');
					if ($salon_tel or $salon_freedial) :
				?>
					<tr>
						<th>TEL</th>
						<td>
						<?php if ($salon_tel) : ?>
						<a href="tel:<?= esc_attr($salon_tel); ?>"><?= esc_html($salon_tel); ?></a>
							<?php if (HP_Acf::get('hp_salon_freedial_region', 'option') and HP_Acf::get('hp_salon_telephone', 'option')) : ?>
							<div class="freedial-region-salon-page">※ 県外からおかけの方は、上記番号からおかけください。</div>
							<?php endif; ?><?= ($salon_freedial) ? '<br>' : ''; ?>
						<?php endif; ?>
						<?php if ($salon_freedial) : ?>
						<a href="tel:<?= esc_attr($salon_freedial); ?>"><?= esc_html($salon_freedial); ?></a>
						<?php endif; ?>
						</td>
					</tr>
				<?php endif; ?>

				<?php
					$salon_postalcode = HP_Acf::get('hp_salon_postalcode', 'option');
					$salon_address = HP_Acf::get('hp_salon_address', 'option');
					if ($salon_postalcode or $salon_address) :
				?>
					<tr>
						<th>ACCESS</th>
						<td>
							<?= ($salon_postalcode) ? '〒'.esc_html($salon_postalcode).'　' : ''; ?><?= esc_html($salon_address); ?>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ($salon_opentime = HP_Acf::get('hairs_access_opens', 'option')) : ?>
					<tr>
						<th>OPEN</th>
						<td><?= wp_kses_post($salon_opentime); ?></td>
					</tr>
				<?php endif; ?>

				<?php if ($salon_holiday = HP_Acf::get('hp_salon_holiday', 'option')) : ?>
					<tr>
						<th>CLOSE</th>
						<td><?= esc_html($salon_holiday); ?></td>
					</tr>
				<?php endif; ?>
				</table>
			</div>
		</div>
		<!-- /.row -->

		<?php
			$salon_photo = HP_Acf::get('hp_salon_shop_photo', 'option');
			$salon_map_image = HP_Acf::get('hairs_mapimg_url', 'option');
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

		<?php if ($googlemap = HP_Googlemap::mapdata()) : ?>
		<div id="accessmap" class="row salon-access-map">
			<div class="col-xs-12">
				<div class="salon-access-flex">
					<h2 class="salon-access-title"><span class="en">Access</span></h2>
					<?= HP_Googlemap::link(['class' => 'mapApp btn btn-default btn-ls', 'icon' => '<i class="fa fa-angle-right"></i>']); ?>
				</div>

				<?php if ($location = HP_Acf::get('hp_salon_google_map', 'option')) : ?>
				<div class="acf-map">
					<?php
						$zoom = 16;
						if ($_zoom = HP_Acf::get('hp_salon_google_map_zoom', 'option'))
							$zoom = $_zoom;
					?>
					<div class="marker" data-lat="<?= esc_attr($location['lat']); ?>" data-lng="<?= esc_attr($location['lng']); ?>" data-zoom="<?= esc_attr($zoom); ?>">
						<?php if ($logo_id = HP_Acf::get('hp_salon_logo', 'option')) : ?>
						<?= wp_get_attachment_image($logo_id, 'logo'); ?>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
		<?php endif; ?>
		<?php if ($route = HP_Acf::get('hairs_route_text', 'option')) : ?>
			<div class="salon-access-route"><?= wp_kses_post($route); ?></div>
		<?php endif; ?>
	</div>
	<!-- /.container -->
</div>
<!-- /#menu -->

<?php get_footer(); ?>
