<?php
	$staff_args = array(
		'post_type' => 'staff',
		'posts_per_page' => -1,
		'ignore_sticky_posts' => true
	);
	$staff_query = new WP_Query($staff_args);
	global $front_staff;
	$front_staff = array();
	if ($staff_query->have_posts()) {
		while ($staff_query->have_posts()) {
			$staff_query->the_post();
			$staff_relation = get_field('staff_haircatalog_link');
			$staff_manage = get_field('manage');
			if ($staff_relation and $staff_manage) {
				$front_staff[$staff_relation->term_id] = $staff_manage;
			}
		}
	}
	wp_reset_postdata();

	function front_manage($term_id) {
		global $front_staff;
		if (isset($front_staff[$term_id]) and $front_staff[$term_id]) {
			return sprintf(
				'<span>%s</span>',
				get_staff_manage($front_staff[$term_id])
			);
		}
	}

	$catalog_args = array(
		'post_type'      => 'catalog',
		'posts_per_page' => 20,
		'order'          => 'DESC',
		'orderby'        => 'date',
		'ignore_sticky_posts' => true
	);
	$catalog = new WP_Query($catalog_args);
?>
<?php if( $catalog->have_posts() ) : ?>
<div id="frontCatalog" class="c-wrap front-catalog-wrap">
	<div class="container">
		<h2 class="c-title">
			<span class="en">Catalog</span>
		</h2>
	</div>
	<div class="container-fullid">
		<div class="catalog-container swiper-container">
			<div class="catalog-swiper">
				<div class="swiper-wrapper">
					<?php while( $catalog->have_posts() ) : $catalog->the_post(); ?>
						<div class="swiper-slide">
							<div class="thumb">
								<?= hp_new_flag(); ?>
								<button class="btn-catalog-info"><i class="fa fa-info"></i></button>
								<a href="<?php the_permalink(); ?>">
									<?php mio_get_thumbnail('catalog-thumb'); ?>
									<div class="overlay">
										<div class="text">
											<h3 class="title"><?php the_title(); ?></h3>

											<p class="stylist"><?php
												$cstaff = get_field('cstaff');
												if ($cstaff) {
													echo front_manage($cstaff->term_id);
												}
											?><span class="hidden-xs">：</span><br class="visible-xs"><span class="name"><?= ($cstaff) ? $cstaff->name : '-'; ?></span></p>
										</div>
									</div>
								</a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>

			<!-- Side Button -->
			<div class="catalog-list-prev swiper-button-prev"></div>
			<div class="catalog-list-next swiper-button-next"></div>

			<!-- Scrollbar -->
			<div class="catalog-scrollbar swiper-scrollbar"></div>
		</div>
		<!-- /.catalog-container -->

		<div class="front-catalog__more text-center">
			<a href="<?= get_post_type_archive_link('catalog'); ?>" class="btn btn-primary btn-lm"><i class="fa fa-angle-right"></i><span>カタログ一覧</span></a>
		</div>
	</div>
</div>
<!-- /#frontCatalog -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>