<!-- ここから - コンテンツ -->
<?php while( have_posts() ) : the_post(); ?>

<?php $setmenu = get_field('setmenu'); ?>
<article>
<div id="catalog" class="c-wrap">
	<div class="container">
		<div class="catalog-single">
			<div class="catalog-single__image">
				<div class="catalog-picture">
					<div class="catalog-picture-body">
						<div class="pic-wrap <?= has_post_thumbnail() ? 'not-length' : ''; ?>">
							<?php if ($setmenu['images']) : ?>
								<?php foreach ($setmenu['images'] as $k => $r) : ?>
									<?php
										$active = ($k === 0) ? 'active' : '';
										$image = wp_get_attachment_image_url($r['image'], 'catalog-single');
									?>
									<div data-catalog-body="catalogImage_<?= $k; ?>" class="pic <?= $active; ?>" style="background-image:url(<?= $image; ?>)"></div>
								<?php endforeach; ?>
							<?php elseif (has_post_thumbnail()) : ?>
								<?php
									$image = get_the_post_thumbnail_url(get_the_ID(), 'catalog-single');
								?>
								<div class="pic active" style="background-image:url('<?= $image; ?>')"></div>
							<?php else : ?>
								<div class="pic active">
									<div class="not-picture">
										<span>Not Picture</span>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php if ($setmenu['images']) : ?>
						<div class="catalog-picture-thumbnails">
							<div class="catalog-picture-list">
								<?php foreach ($setmenu['images'] as $k => $r) : ?>
									<?php
										$active = ($k === 0) ? 'active' : '';
									?>
									<a href="#" data-catalog-target="catalogImage_<?= $k; ?>" class="catalog-picture-list-item <?= $active; ?>">
										<?= wp_get_attachment_image($r['image'], 'thumbnail'); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="catalog-single__data">
				<header class="catalog-header">
					<h1 class="title"><?php the_title(); ?></h1>
				</header>
				<!-- /.catalog-header -->

				<!-- コンテンツエリア -->
				<section class="catalog-body">
					<table class="catalog-table">
						<?php
							$fields = array(
								'time_required' => '所要時間',
							);
						?>
						<?php foreach ($fields as $k => $v) : ?>
							<?php if ($field = $setmenu[$k] and $setmenu[$k]) : ?>
								<tr>
									<th><?= $v; ?></th>
									<td><?= esc_html($field); ?></td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>

					<div class="catalog-price">
						<?php if ($setmenu['price']['min']) : ?>
							<?php
								$price_min = money($setmenu['price']['min']);
							?>
							<p class="price">
								<span class="txt">Price</span>
								<span class="slash">/</span>
								<span class="yen">&yen;</span>
								<span class="numeric">
									<?= $price_min; ?>
									<?php if ($setmenu['price']['kara']) : ?>
										<span class="kara">〜</span>
									<?php endif; ?>
								</span>
							</p>
						<?php else : ?>
							<p class="price" style="color: #f00; font-family: sans-serif; font-size: 12px;">システム：料金項目を再設定してください。</p>
						<?php endif; ?>

						<div class="link">
							<?php
								$shop_url = reserve_url();
								if ($setmenu['reserve_url']) {
									echo reserve_button(esc_url($setmenu['reserve_url']));
								} elseif ($shop_url) {
									echo reserve_button(esc_url($shop_url));
								}
							?>

							<?php get_template_part('template-parts/social', 'button'); ?>
						</div>
						<!-- /.link -->
					</div>
					<!-- /.catalog-price -->
					<!-- ここまで - 料金エリア -->
				</section>
			</div>
		</div>
	</div>
</div>
<!-- /#catalog -->
</article>
<!-- ここまで - コンテンツ -->
<?php endwhile; ?>
