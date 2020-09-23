<?php
	$freespace_check = HP_Acf::get('free_space_hidden', 'option');
?>
<?php if ( $freespace_check and have_rows('free_space', 'option')) : ?>
<div id="bannerSpace" class="bannerspace">
	<div class="container">
		<div class="bannerspace__row">
			<?php while (have_rows('free_space', 'option')) : the_row(); ?>
				<?php if (get_row_layout() === 'フリースペース' and get_sub_field('image')) : ?>
				<div class="bannerspace__item">
					<figure class="bannerspace__figure">
						<?php
							$url_customer = get_sub_field('url_customer');
							$link = $url_customer ? get_sub_field('url') : get_sub_field('url_selector');

							$image = '';
							if ($image_id = get_sub_field('image')) {
								$image = wp_get_attachment_image($image_id, 'front-free-thumb');
							}

							$title = '';
							if ($title_text = get_sub_field('link_text') and $title_text) {
								// $visibility = get_sub_field('link_text_visibility');
								// if (!is_bool($visibility)) {
								// 	$visibility = true;
								// }
								$title = sprintf(
									'<figcaption class="%2$s">%1$s</figcaption>',
									strip_tags($title_text),
									'' //$visibility ? 'visible' : 'hidden'
								);
							}

							if ($link) {
								printf(
									'<a href="%1$s" target="%2$s">%3$s</a>',
									esc_url($link),
									get_sub_field('link_target') ? '_blank' : '_self',
									$image.$title
								);
							} else {
								echo $image.$title;
							}
						?>
					</figure>
				</div>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</div>
</div>
<!-- /#bannerSpace -->
<?php endif; ?>