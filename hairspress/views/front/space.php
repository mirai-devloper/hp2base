<?php $freespace_check = HP_Acf::get('free_space_hidden', 'option'); ?>
<?php if ( $freespace_check and have_rows('free_space', 'option')) : ?>
<div id="freespace" class="c-wrap freespace-wrap">
	<div class="container">
		<div class="row">
			<?php while (have_rows('free_space', 'option')) : the_row(); ?>
				<?php if (get_row_layout() === 'フリースペース' and get_sub_field('image')) : ?>
				<div class="col-sm-4">
					<figure class="freespace">
						<?php
							$url_customer = get_sub_field('url_customer');
							if ($url_customer) {
								$link = get_sub_field('url');
							} else {
								$link = get_sub_field('url_selector');
							}
							$target = '_self';
							if (get_sub_field('link_target')) {
								$target = '_blank';
							}

							$image = '<span class="not-thumb"></span>';
							if ($image_id = get_sub_field('image')) {
								$image = wp_get_attachment_image($image_id, 'front-free-thumb');
							}

							$title = '';
							if ($title_text = get_sub_field('link_text')) {
								$title = sprintf(
									'<figcaption>%1$s</figcaption>',
									strip_tags($title_text)
								);
							}

							if ($link) {
								printf(
									'<a href="%1$s" target="%2$s">%3$s</a>',
									esc_url($link),
									$target,
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
<!-- /#freespace -->
<?php endif; ?>