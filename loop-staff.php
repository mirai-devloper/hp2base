<!-- ここから - コンテンツ -->
<div id="staff" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page">
			<span class="en">Staff</span>
			<span class="jp">スタッフ</span>
		</h2>

		<div class="row ">
			<!-- スタッフ一覧 -->
			<div class="staff-loop">
				<?php if( have_posts() ) : ?>
					<div class="staff-flex">
						<?php while( have_posts() ) : the_post(); ?>
							<div class="item">
								<article>
									<a href="<?php the_permalink(); ?>" class="staff-flex__link">
										<div class="thumb">
											<?php if( has_post_thumbnail() ) : ?>
												<div class="thumb-box">
													<?php the_post_thumbnail('staff'); ?>
												</div>
											<?php else : ?>
												<span class="not-thumb"></span>
											<?php endif; ?>
										</div>
										<div class="meta-box">
											<h2 class="staff-name"><i class="fa fa-angle-right"></i><?php the_title_attribute(); ?></h2>
											<p class="manage"><?php hp_stylist_manage(); ?></p>
										</div>
									</a>

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
			</div>
		</div>
		<!-- /.staff-loop -->
	</div>
</div>
<!-- /#staff -->
<!-- ここまで - コンテンツ -->
