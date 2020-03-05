<?php
add_filter('wp_print_footer_scripts', function() {
	get_template_part('template/js-catalog-search');
}, 12);
?>
<!-- ここから - コンテンツ -->
<div id="catalog" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page">
			<span class="en">Catalog</span>
			<span class="jp">カタログ</span>
		</h2>

		<div class="stylist-category">
			<h3 id="catalogSearchToggle" class="title"><i class="fa fa-list"></i> ヘアスタイルを探す <i class="fa toggle fa-toggle-down"></i></h3>

			<?php //hp_stylist_term(); ?>
			<?php hp_catalog_search(); ?>
		</div>
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
											<?php mio_get_catalog_thumb('catalog-loop'); ?>
										</div>
										<div class="meta-box">
											<h2 class="style-name"><i class="fa fa-angle-right"></i><?php the_title_attribute(); ?></h2>

											<hr class="border-catalog">

											<ul class="meta">
												<li class="manage"><?php hp_stylist_manage(); ?></li>
												<li class="staff"><?php hp_stylist_name(); ?></li>
											</ul>
										</div>
									</a>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					<?php pagination(); ?>
        <?php else : ?>
          <?php if( is_tax('catalog_length') || is_tax('catalog_tag') || is_tax('com_category') ) : ?>
            <div class="row">
              <p style="padding: 42px 0;">お探しのヘアカタログが見つかりませんでした。</p>
            </div>
          <?php else : ?>
            <div class="row">
              <p style="padding: 42px 0;">ヘアカタログの投稿がありません</p>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</div>
<!-- ここまで - コンテンツ -->
