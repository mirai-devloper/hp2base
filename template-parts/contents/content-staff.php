<?php
	$staff = get_staff();
?>
<!-- ここから - コンテンツ -->
<article>
<div id="staff" class="c-wrap staff-single">
	<div class="container">
		<div class="staff-single__row">
			<?php if( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
					<div class="staff-single__picture">
						<!-- スタッフ写真 -->
						<div class="staff-picture">
							<div class="pic">
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail('catalog-single'); ?>
							<?php else : ?>
								<span class="not-thumb"></span>
							<?php endif; ?>
							</div>
						</div>
						<!-- /.staff-picture -->
						<!-- ここまで - スタッフ写真 -->

						<?php if($social = get_staff_social($staff->social)) : ?>
							<div class="staff-social">
								<ul class="social-icon">
									<li><?= implode('</li><li>', $social); ?></li>
								</ul>
							</div>
						<?php endif; ?>
					</div>

					<div class="staff-single__data">
						<!-- スタッフヘッダー -->
						<header class="staff-header">
							<!-- タイトル -->
							<h1 class="title">
								<span class="name"><?= get_staff_name(); ?></span>
								<?php if ($staff->furigana) : ?>
									<span class="kana"><?= $staff->furigana; ?></span>
								<?php endif; ?>
							</h1>

							<?php if ($manage = get_staff_manage($staff->manage)) : ?>
								<p class="manage">
									<span><?= $manage; ?></span>
								</p>
							<?php endif; ?>
							<?php if ( ! $staff->reserve_btn_hidden) : ?>
								<?php if ($staff_reserve = $staff->reserve_staff) : ?>
									<div class="reserve">
										<?= reserve_button(esc_url($staff_reserve), 'ネット予約はこちら', array('class' => 'btn btn-default btn-mid')); ?>
									</div>
								<?php elseif ($shop_reserve = reserve_url()) : ?>
									<div class="reserve">
										<?= reserve_button(esc_url($shop_reserve), 'ネット予約はこちら', array('class' => 'btn btn-default btn-mid')); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</header>
						<!-- /.staff-header -->
						<!-- ここまで - スタッフヘッダー -->

						<!-- コンテンツエリア -->
						<section class="staff-body">
							<!-- スタイル情報のテーブル -->
							<table class="staff-table">
							<?php
								$profile_args = array(
									'beauty_history' => '美容歴',
									'hobby' => '趣味',
									'good_image' => '得意なイメージ',
									'good_technology' => '得意な技術'
								);

								$profile_table = '';
								foreach( $profile_args as $key => $val ) {
									$get_profile = $staff->$key;
									if( !empty($get_profile) ) {
										$yy = $val === '美容歴' ? '年' : '';
										$profile_table .= '<tr><th>'.$val.'</th><td>'.$get_profile.$yy.'</td></tr>';
									}
								}
								echo $profile_table;
							?>
							<?php
								$staff_blog = $staff->blog_url_for;
								$staff_blog_text = $staff->blog_url_text;
								$staff_blog_category = $staff->blog_url_select;

								$blog_url = NULL;
								if ($staff->blog_url_for == 'URLを入力する') {
									if ( !empty($staff->blog_url_text) ) {
										$blog_url = $staff->blog_url_text;
									}
								} else {
									if ( !empty($staff->blog_url_select) ) {
										$link = get_term_link($staff->blog_url_select, 'category');
										$blog_url = $link;
									}
								}
							?>
							<?php if ( !empty($blog_url) ) : ?>
								<tr class="blog">
									<th>ブログ</th>
									<td>
										<a href="<?= esc_url($blog_url); ?>"><?= esc_url($blog_url); ?></a>
									</td>
								</tr>
							<?php endif; ?>
							</table>
							<!-- /.staff-table -->
							<!-- ここまで - スタッフ情報のテーブル -->

							<!-- スタッフコメント -->
							<?php
								if ( !empty($staff->appeal) ) {
									echo '<div class="staff-comment">'.$staff->appeal.'</div>';
								}
							?>
							<!-- /.staff-comment -->
							<!-- ここまで - スタッフコメント -->
						</section>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		<!-- /.staff-single -->

		<?php
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
				// 'post__not_in' => array($queri_obj->ID)
			);
			$style_query = new WP_Query($style_args);
		?>
		<?php if ( $style_query->have_posts() ) : ?>
			<!-- ヘアカタログ一覧（カルーセル） -->
			<div class="row c-wrap">
				<section class="catalog-footer">
					<h2 class="other-title">Other Styles</h2>

					<!-- 一覧ボタン -->
					<a href="<?= get_term_link($other_term[0]); ?>" class="btn btn-primary btn-sm read-more"><i class="fa fa-angle-right"></i>一覧を見る</a>

					<!-- カルーセル開始 -->
					<div class="other-catalog catalog-swiper staff-other-catalog">
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
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</div>
<!-- /#staff -->
</article>
<!-- ここまで - コンテンツ -->

<?php
	$current_id = get_queried_object_id();

	$other_staff_args = array(
		'post_type'       => 'staff',
		'posts_per_page'  => -1,
		'post__not_in' => array($current_id)
	);

	$other_staff = new WP_Query( $other_staff_args );
?>
<?php if ( $other_staff->have_posts() ) : ?>
<div id="otherStaff" class="other-staff">
	<div class="container">
		<div class="row">
			<div class="col-sm-3 col-md-2 col-md-offset-2">
				<h2 class="title">
					<span class="en">OTHER<br class="sp-br"> STAFF</span>
					<span class="jp">その他のスタッフ</span>
				</h2>
				<p class="center">
					<a href="<?=get_post_type_archive_link('staff'); ?>" class="btn btn-default btn-sm"><i class="fa fa-angle-left"></i>一覧に戻る</a>
				</p>
			</div>

			<div class="col-sm-9 col-md-6">
				<div class="other-staff-list swiper-container">
					<ul class="staff-list swiper-wrapper">
						<?php while( $other_staff->have_posts() ) : $other_staff->the_post(); ?>
							<li class="swiper-slide">
								<a href="<?php the_permalink(); ?>" class="item">
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
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /#otherStaff -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>