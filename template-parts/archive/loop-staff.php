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
											<h2 class="staff-name"><i class="fa fa-angle-right"></i><?= get_staff_name(); ?></h2>
                      <?php if ($manage = get_staff_manage(get_field('manage'))) : ?>
                        <p class="manage">
                          <span><?= $manage; ?></span>
                        </p>
                      <?php endif; ?>
										</div>
									</a>

									<?php if (!get_field('reserve_btn_hidden')) : ?>
										<?php if ($staff_reserve = get_field('reserve_staff')) : ?>
											<div class="reserve">
												<?= reserve_button(esc_url($staff_reserve), 'ネット予約はこちら', array('class' => 'btn btn-default btn-mid')); ?>
											</div>
										<?php elseif ($shop_reserve = reserve_url()) : ?>
											<div class="reserve">
												<?= reserve_button(esc_url($shop_reserve), 'ネット予約はこちら', array('class' => 'btn btn-default btn-mid')); ?>
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
