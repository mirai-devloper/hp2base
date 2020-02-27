<!-- ここから - コンテンツ -->
<div id="staff" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page"><span class="en">Staff</span><span class="jp">スタッフ</span></h2>
		
		<div class="row staff-loop">

			<!-- ヘアスタイル一覧 -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
					$staff_args = array(
						'post_type'       => 'staff',
						'posts_per_page'  => 12,
						'paged'           => get_query_var('paged'),
					);
					$staff_query = new WP_Query( $staff_args );
					$max_paged = $staff_query->max_num_pages;
					$found_post = $staff_query->found_posts;
					if( have_posts() ) :
				?>
				<div class="row staff-flex">
				<?php while( have_posts() ) : the_post(); ?>
					<?php if( $found_post < 6 ) : ?>
						<div class="col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-0 col-md-3 item">
					<?php else : ?>
						<div class="col-xs-6 col-sm-4 col-md-3 item">
					<?php endif; ?>
						<article>
							<a href="<?php the_permalink(); ?>" class="thumb">
							<?php if( has_post_thumbnail() ) :
								the_post_thumbnail('staff'); ?>
							<?php else : ?>
								<span class="not-thumb"></span>
							<?php endif; ?></a>
							
							<div class="meta-box">
								<h2 class="staff-name"><a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i><?php the_title_attribute(); ?></a></h2>
								<p class="manage"><?php hp_stylist_manage(); ?></p>
							</div>
							<?php if ( ! (HP_Acf::get('reserve_btn_hidden'))) : ?>
								<?php if ($staff_reserve = HP_Acf::get('reserve_staff')) : ?>
									<div class="reserve">
										<a href="<?= esc_url($staff_reserve); ?>" class="btn btn-default btn-mid" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>
									</div>
								<?php elseif ($shop_reserve = HP_Acf::reserve_url()) : ?>
									<div class="reserve">
										<a href="<?= esc_url($shop_reserve); ?>" class="btn btn-default btn-mid" target="_blank"><i class="fa fa-angle-right"></i>ネット予約はこちら</a>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</article>
					</div>
					<?php endwhile; ?>
				</div>
				<?php pagination(); ?>
				<?php else : ?>
				<div class="warning">
					<p>スタッフページがまだ作成できていないようです。</p>
				</div>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
		<!-- /.staff-loop -->
	</div>
</div>
<!-- /#staff -->
<!-- ここまで - コンテンツ -->
