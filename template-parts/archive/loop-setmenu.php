<!-- ここから - コンテンツ -->
<div id="setmenu" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page">
			<span class="en">Setmenu</span>
			<span class="jp">セットメニュー</span>
		</h2>

		<div class="row ">
			<!-- ヘアスタイル一覧 -->
			<div class="scroller-body catalog-archive">
				<?php if( have_posts() ) : ?>
					<div class="catalog-loop">
						<?php while( have_posts() ) : the_post(); ?>
							<div class="catalog-loop__item">
								<div class="catalog-loop__item-inner">
									<a href="<?php the_permalink(); ?>" class="catalog-loop__item-link">
										<div class="thumb">
											<?= setmenu_thumbnail('catalog-loop'); ?>
										</div>
										<div class="meta-box">
											<h3 class="style-name"><i class="fa fa-angle-right"></i><?php the_title(); ?></h3>
										</div>
									</a>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<?php pagination(); ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</div>
</div>
<!-- ここまで - コンテンツ -->
