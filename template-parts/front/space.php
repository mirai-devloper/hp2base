<?php
	global $wphp;
?>
<?php if ( $wphp->free_space_hidden and $wphp->free_space) : ?>
<div id="bannerSpace" class="bannerspace">
	<div class="container">
		<div class="bannerspace__row">
			<?php foreach ($wphp->free_space as $row) : ?>
				<?php if ($row['acf_fc_layout'] === 'フリースペース' and $row['image']) : ?>
					<div class="bannerspace__item">
						<figure class="bannerspace__figure">
							<?php
								$link = $row['url_customer'] ? $row['url'] : $row['url_selector'];

								$image = wp_get_attachment_image($row['image'], 'front-free-thumb');

								$title = '';
								if ($title_text = $row['link_text'] and $title_text) {
									// $visibility = $row['link_text_visibility'];
									// if (!is_bool($visibility)) {
									// 	$visibility = true;
									// }
									$title = sprintf(
										'<figcaption class="%2$s">%1$s</figcaption>',
										strip_tags($title_text),
										'' // $visibility ? 'visible' : 'hidden'
									);
								}

								if ($link) {
									printf(
										'<a href="%1$s" target="%2$s">%3$s</a>',
										esc_url($link),
										$row['link_target'] ? '_blank' : '_self',
										$image.$title
									);
								} else {
									echo $image.$title;
								}
							?>
						</figure>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<!-- /#bannerSpace -->
<?php endif; ?>