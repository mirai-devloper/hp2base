<?php
add_filter('wp_print_footer_scripts', function() {
	get_template_part('template-parts/catalog-search-js');
}, 12);
?>
<!-- ここから - コンテンツ -->
<div id="catalog" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page">
			<span class="en">Catalog</span>
			<span class="jp">カタログ</span>
		</h2>

    <?php if( have_posts() ) : ?>
      <div class="stylist-category">
        <h3 id="catalogSearchToggle" class="title"><i class="fa fa-list"></i> ヘアスタイルを探す <i class="fa toggle fa-toggle-down"></i></h3>

        <?php //hp_stylist_term(); ?>
        <?php hp_catalog_search(); ?>
        <?php //get_template_part('template-parts/catalog-search'); ?>
      </div>
      <div class="row ">
        <!-- ヘアスタイル一覧 -->
        <div class="scroller-body catalog-archive">
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
            <?php wp_reset_postdata(); ?>
          </div>
          <?php pagination(); ?>
        </div>
      </div>
    <?php else : ?>
      <div class="row">
        <div class="scroller-body catalog-archive">
          <?php if( is_tax('catalog_length') || is_tax('catalog_tag') || is_tax('com_category') ) : ?>
            <p style="padding: 42px 0;text-align:center;">お探しのヘアカタログが見つかりませんでした。</p>
          <?php else : ?>
            <p style="padding: 42px 0;text-align:center;">ヘアカタログの投稿がありません</p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<!-- ここまで - コンテンツ -->
