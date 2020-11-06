<!-- ここから - コンテンツ -->
<?php while( have_posts() ) : the_post(); ?>

<?php $menuContents = get_field('menu_contents'); ?>
<article>
<div id="menuContents" class="c-wrap">
	<div class="container">
		<div class="catalog-single">
			<div class="catalog-single__image">
				<div class="catalog-picture">
					<div class="catalog-picture-body">
						<div class="pic-wrap <?= has_post_thumbnail() ? 'not-length' : ''; ?>">
							<?php if ($menuContents['images']) : ?>
								<?php foreach ($menuContents['images'] as $k => $r) : ?>
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

					<?php if ($menuContents['images']) : ?>
						<div class="catalog-picture-thumbnails">
							<div class="catalog-picture-list">
								<?php foreach ($menuContents['images'] as $k => $r) : ?>
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
					<?php if ($menuContents['comment']) : ?>
						<div class="comment-wrapper">
							<p class="comment comment-full"><?= rtrim($menuContents['comment'], "<br>"); ?></p>
						</div>
					<?php endif; ?>
				</header>
				<!-- /.catalog-header -->

				<!-- コンテンツエリア -->
				<section class="catalog-body">
					<table class="catalog-table">
						<?php if ($type = menucontents_type()) : ?>
							<tr>
								<th>タイプ</th>
								<td><?= $type; ?></td>
							</tr>
						<?php endif; ?>
						<?php if ($category = menucontents_category()) : ?>
							<tr>
								<th>カテゴリー</th>
								<td><?= $category; ?></td>
							</tr>
						<?php endif; ?>
						<?php
							$fields = array(
								'nayami' => 'お悩み',
								'kouka' => '効果',
								'time_required' => '所要時間',
							);
						?>
						<?php foreach ($fields as $k => $v) : ?>
							<?php if ($field = $menuContents[$k] and $menuContents[$k]) : ?>
								<tr>
									<th><?= $v; ?></th>
									<td>
										<?= esc_html($field); ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					</table>

					<div class="catalog-price">
						<?php if ($menuContents['price']['min']) : ?>
							<?php
								$price_min = money($menuContents['price']['min']);
							?>
							<p class="price">
								<span class="txt">Price</span>
								<span class="slash">/</span>
								<span class="yen">&yen;</span>
								<span class="numeric">
									<?= $price_min; ?>
									<?php if ($menuContents['price']['kara']) : ?>
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
								if ($menuContents['reserve_url']) {
									echo reserve_button(esc_url($menuContents['reserve_url']));
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
