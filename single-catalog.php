<?php get_header(); ?>

<!-- ここから - コンテンツ -->
<article>
<div id="catalog" class="c-wrap">
	<div class="container">
		<div class="row catalog-single">
		<?php if( have_posts() ) : ?>
			<?php while( have_posts() ) : the_post(); ?>
				<div class="col-xs-12 col-sm-4">
					<!-- スタイル写真 -->
					<div class="catalog-picture">
					<!-- 写真のボディ -->
					<?php if ($images = HP_Acf::get('catalog_photo_style')) : ?>
						<div class="catalog-picture-body">
							<div class="pic-wrap">
								<?php
									foreach ($images as $k1 => $v1) :
										$img = $v1['sizes'];
								?>
								<div data-catalog-body="<?= 'catalogImage_'.$k1; ?>" class="pic <?= ($k1 === 0) ? 'active' : ''; ?>" style="background-image:url('<?= esc_url_raw($img['catalog-single']); ?>')">
									<!-- <img src="<?= esc_url($img['catalog-single']); ?>" width="<?= esc_attr($img['catalog-single-width']); ?>" height="<?= esc_attr($img['catalog-single-height']); ?>" alt=""> -->
								</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php else : ?>
						<div class="catalog-picture-body not-length">
							<div class="pic-wrap">
							<?php if (has_post_thumbnail(get_the_ID())) : ?>
								<div class="pic active" style="background-image:url('<?= get_the_post_thumbnail_url(get_the_ID(), 'catalog-single'); ?>')"></div>
							<?php else : ?>
								<?php if (is_admin_bar_showing()) : ?>
								<div class="pic active">
									<p style="color: #f00;">システム：画像が設定されていません。<br>編集画面から「写真設定」タブより写真の登録をしてください。<br>「写真設定」が設定されていなくアイキャッチ画像のみが設定されている場合は、アイキャッチ画像が表示されます。</p>
								</div>
								<?php else : ?>
								<div class="pic active">
									<div class="not-picture">
										<span>Not Picture</span>
									</div>
								</div>
								<?php endif; ?>
							<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>

					<?php if ($images = HP_Acf::get('catalog_photo_style')) : ?>
						<div class="catalog-picture-thumbnails">
							<div class="catalog-picture-list">
								<?php foreach ($images as $k2 => $v2) :
									$img = $v2['sizes'];
								?>
									<a href="#" data-catalog-target="<?= 'catalogImage_'.$k2; ?>" class="catalog-picture-list-item <?= ($k2 == 0) ? 'active' : ''; ?>">
										<img src="<?= esc_url($img['thumbnail']); ?>" width="<?= esc_attr($img['thumbnail-width']); ?>" height="<?= esc_attr($img['thumbnail-height']); ?>" alt="">
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					</div>
					<!-- /.catalog-picture -->
					<!-- ここまで - スタイル写真 -->
				</div>
				<!-- ここまで - スタイル写真のラッパー -->

				<div class="col-xs-12 col-sm-8">
					<!-- カタログヘッダー -->
					<header class="catalog-header">
						<!-- タイトル -->
						<h1 class="title"><?php the_title(); ?></h1>
						<?php if ($comment_field = HP_Acf::get('cappeal')) : ?>
						<div class="comment-wrapper">
							<div class="staff-pic">
								<?php hp_stylist_photo(); ?>
								<?php wp_reset_postdata(); ?>
							</div>
							<p class="comment"><?= wp_kses_post($comment_field); ?></p>
						</div>
						<?php endif; ?>
					</header>
					<!-- /.catalog-header -->
					<!-- ここまで - カタログヘッダー -->

					<!-- コンテンツエリア -->
					<section class="catalog-body">
						<table class="catalog-table">
						<?php if ($length = HP_Acf::get('hp_catalog_length', get_the_ID())) : ?>
							<?php
								foreach ($length as $leng)
									$len[] = $leng->name;
								$leng_text = implode('、', $len);
							?>
							<tr>
								<th>長さ</th>
								<td><?= $leng_text; ?></td>
							</tr>
						<?php endif; ?>

						<?php
							$catalog_field = array(
								// 'cnagasa' => '長さ',
								'ccolor' => 'カラー',
								'cparm' => 'パーマ',
								'cimage' => 'イメージ',
								'cnaiyou' => 'メニュー内容',
								'ctime' => '所要時間'
							);
							foreach ($catalog_field as $k => $v) :
						?>
							<?php if ($field = HP_Acf::get($k)) : ?>
							<tr>
								<th><?= $v; ?></th>
								<td><?= esc_html($field); ?></td>
							</tr>
							<?php endif; ?>
						<?php endforeach; ?>
						</table>

						<?php if ($tag_term = wp_get_post_terms(get_the_ID(), 'catalog_tag')) : ?>
						<!-- ヘアカタログのタグ -->
						<div class="catalog-tag-container">
							<ul class="catalog-tag">
							<?php
								the_terms(
									get_the_ID(),
									'catalog_tag',
									'<li class="swiper-slide">',
									'</li>'."\n".'<li class="swiper-slide">',
									'</li>'
								);
							?>
							</ul>
							<div class="cat-tag-scrollbar swiper-scrollbar"></div>
						</div>
						<!-- /.catalog-tag-container -->
						<!-- ここまで - ヘアカタログのタグ -->
						<?php endif; ?>

						<div class="catalog-price">
						<?php
							if ($money = HP_Acf::get('hp_catalog_money')) :
								$price = number_format(mb_ereg_replace('[^0-9]', '', mb_convert_kana($money, 'n')));
						?>
							<p class="price">
								<span class="txt">Price</span>
								<span class="slash">/</span>
								<span class="yen">&yen;</span>
								<span class="numeric"><?= $price ?><?= (HP_Acf::get('ckara')) ? '<span class="kara">~</span>' : ''; ?></span>
							</p>
						<?php else : ?>
							<p class="price" style="color: #f00; font-family: sans-serif; font-size: 12px;">システム：料金項目を再設定してください。</p>
						<?php endif; ?>

							<div class="link">
							<?php
								/*<!-- Web予約ボタン -->*/
								// ヘアカタログの予約チェック
								$reserve_catalog = HP_Acf::get('reserve_catalog');
								$reserve_check = $reserve_catalog !== 'none' ? $reserve_catalog : null;

								// 現在のページのタームを取得
								$reserve_term = get_the_terms(get_the_ID(), 'com_category');

								$staff_reserve_args = array(
									'post_type' => 'staff',
									'tax_query' => array(
										array(
											'taxonomy' => 'com_category',
											'field' => 'id',
											'terms' => $reserve_term[0]->term_id
										)
									)
								);
								$reserve_query = new WP_Query($staff_reserve_args);
								$shop_url = HP_Acf::reserve_url();
							?>

							<?php if ($reserve_check == 'staff') : ?>
								<?php if( $reserve_query->have_posts() ) : $reserve_query->the_post(); ?>
									<?php if($staff_url = HP_Acf::get('reserve_staff')) : ?>
									<a href="<?= esc_url($staff_url); ?>" class="btn btn-default btn-ls" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>
									<?php elseif ($shop_url) : ?>
									<a href="<?= esc_url($shop_url); ?>" class="btn btn-default btn-ls" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>
									<?php endif; ?>
								<?php endif; ?>
							<?php elseif ($reserve_check == 'shop') : ?>
								<?php if ($shop_url) : ?>
									<a href="<?= esc_url($shop_url); ?>" class="btn btn-default btn-ls" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>
								<?php endif; ?>
							<?php endif; ?>

							<?php get_template_part('social', 'button'); ?>
							</div>
							<!-- /.link -->
						</div>
						<!-- /.catalog-price -->
						<!-- ここまで - 料金エリア -->
					</section>
				</div>
				<?php endwhile; ?>
			<?php else : ?>
			<?php endif; ?>
		</div>

		<?php
			$queri_obj = get_queried_object();
			$other_term = get_the_terms($post->ID, 'com_category');
			$style_args = array(
				'post_type' => 'catalog',
				'tax_query' => array(
					array(
						'taxonomy' => 'com_category',
						'field' => 'term_id',
						'terms' => array($other_term[0]->term_id)
					)
				),
				'posts_per_page' => 20,
				'post__not_in' => array($queri_obj->ID),
				'ignore_sticky_posts' => true
			);
			$style_query = new WP_Query($style_args);
			if( $style_query->have_posts() ) :
		?>
		<!-- ヘアカタログ一覧（カルーセル） -->
		<div class="row c-wrap">
			<section class="catalog-footer">
				<h2 class="other-title">Other Styles</h2>

				<!-- 一覧ボタン -->
				<a href="<?= get_term_link($other_term[0]); ?>" class="btn btn-primary btn-sm read-more"><i class="fa fa-angle-right"></i>一覧を見る</a>

				<!-- カルーセル開始 -->
				<div class="other-catalog catalog-swiper">

						<ul class="swiper-wrapper">
						<?php while( $style_query->have_posts() ) : $style_query->the_post(); ?>
						<li class="swiper-slide">
							<a href="<?php the_permalink(); ?>">
								<?php mio_get_thumbnail('catalog-staff'); ?>
							</a>
						</li>
						<?php endwhile; ?>
					</ul>

					<div class="swiper-scrollbar catalog-scrollbar"></div>
				</div>
				<!-- /.other-catalog -->
				<!-- ここまで - カルーセル -->
			</section>
		</div>
		<!-- ここまで - ヘアカタログ（カルーセル） -->
		<?php else : ?>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
<!-- /#catalog -->
</article>
<!-- ここまで - コンテンツ -->

<div id="otherStaff" class="other-staff">
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-md-2 col-md-offset-2">
				<h2 class="title"><span class="en">OTHER<br class="sp-br"> STYLE</span><span class="jp">スタッフ別スタイル</span></h2>
				<p class="center"><a href="<?= esc_url(get_post_type_archive_link('catalog')); ?>" class="btn btn-default btn-sm"><i class="fa fa-angle-left"></i>一覧に戻る</a></p>
			</div>

			<div class="col-sm-9 col-md-6">
				<div class="other-staff-list swiper-container">
				<?php
					$com_category = 'com_category';
					// $current_staff = get_the_terms(get_the_ID(), $com_category);
					// var_dump($current_staff);
					$other_staff_args = array(
						'pad_counts' => true,
						'hide_empty' => true,
						'fields' => 'ids'
					);

					$other_staff_terms = get_terms($com_category, $other_staff_args);
					$other_staff_array = array_values($other_staff_terms);

					$staff_args = array(
						'post_type' => 'staff',
						'tax_query' => array(
							array(
								'taxonomy' => $com_category,
								'field' => 'term_id',
								'terms' => $other_staff_array
							)
						),
						'posts_per_page'  => -1,
					);

					$staff_query = new WP_Query( $staff_args );
					if( $staff_query->have_posts() ) : ?>
						<ul class="staff-list swiper-wrapper">
						<?php while( $staff_query->have_posts() ) : $staff_query->the_post(); ?>
						<?php
							$staff_other_term = get_the_terms( $post->ID, 'com_category' );
							$staff_term_link = get_term_link($staff_other_term[0]);
						?>
						<li class="swiper-slide">
							<a href="<?= esc_url($staff_term_link); ?>" class="item">
								<div class="thumb"><?php mio_get_thumbnail('square'); ?></div>
								<span class="name"><i class="fa fa-angle-right"></i><?php the_title(); ?></span>
								<span class="manage"><?php hp_stylist_manage(); ?></span>
							</a>
						</li>
						<?php endwhile; ?>
						</ul>
						<div class="staff-list-pagination swiper-pagination"></div>
						<div class="staff-list-next swiper-button-next"></div>
						<div class="staff-list-prev swiper-button-prev"></div>
					<?php else : ?>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /#otherStaff -->


<?php get_footer(); ?>
