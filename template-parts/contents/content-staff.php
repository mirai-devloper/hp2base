<!-- ここから - コンテンツ -->
<article>
<div id="staff" class="c-wrap staff-single">
	<div class="container">
		<div class="staff-single__row">
			<?php
				$single_args = array(
					'post_type' => 'staff'
				);
				$query = new WP_Query($single_args);
				if( have_posts() ) : while( have_posts() ) : the_post();
			?>
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

				<?php if( HP_Social::option_url('prefix_staff', 'social_staff', get_the_ID()) ) : ?>
				<div class="staff-social">
					<?= HP_Social::view('prefix_staff', 'social_staff', get_the_ID(), array('class' => 'social-icon')); ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="staff-single__data">
				<!-- スタッフヘッダー -->
				<header class="staff-header">
					<!-- タイトル -->
					<h1 class="title">
						<span class="name"><?php the_title(); ?></span>
						<?php if ($furigana = HP_Acf::get('furigana', get_the_ID())) : ?>
							<span class="kana"><?= $furigana; ?></span>
						<?php endif; ?>
					</h1>

					<?php if ($manage = get_staff_manage()) : ?>
						<p class="manage">
							<span><?= $manage; ?></span>
						</p>
					<?php endif; ?>
					<?php if ( ! (HP_Acf::get('reserve_btn_hidden', get_the_ID()))) : ?>
						<?php if ($staff_reserve = HP_Acf::get('reserve_staff', get_the_ID())) : ?>
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
							$get_profile = function_exists('get_field') ? get_field($key, get_the_id()) : null;
							if( !empty($get_profile) ) {
								$yy = $val === '美容歴' ? '年' : '';
								$profile_table .= '<tr><th>'.$val.'</th><td>'.$get_profile.$yy.'</td></tr>';
							}
						}
						echo $profile_table;
					?>
					<?php
						$staff_blog = get_field('blog_url_for', get_the_id());
						$staff_blog_text = get_field('blog_url_text', get_the_id());
						$staff_blog_category = get_field('blog_url_select', get_the_id());

						$blog_url = NULL;
						if ( strstr($staff_blog, 'URLを入力する') ) {
							if ( !empty($staff_blog_text) ) {
								$blog_url = $staff_blog_text;
							}
						} else {
							if ( !empty($staff_blog_category) ) {
								$link = get_term_link($staff_blog_category, 'category');
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
						$appeal = function_exists('get_field') ? get_field('appeal', get_the_id()) : null;
						if ( !empty($appeal) ) {
							echo '<div class="staff-comment">'.$appeal.'</div>';
						}
					?>
					<!-- /.staff-comment -->
					<!-- ここまで - スタッフコメント -->
				</section>
			</div>
			<?php endwhile; ?>
			<?php else : ?>
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

	$staff_args = array(
		'post_type'       => 'staff',
		'posts_per_page'  => -1,
		'post__not_in' => array($current_id)
	);

	$staff = new WP_Query( $staff_args );
?>
<?php if ( $staff->have_posts() ) : ?>
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
						<?php while( $staff->have_posts() ) : $staff->the_post(); ?>
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