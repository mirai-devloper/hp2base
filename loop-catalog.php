<?php
add_filter('wp_print_footer_scripts', function() {
	get_template_part('template/js-catalog-search');
}, 12);
?>
<!-- ここから - コンテンツ -->
<div id="catalog" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page"><span class="en">Catalog</span><span class="jp">カタログ</span></h2>

    <div class="row catalog-loop">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="stylist-category">
          <h3 id="catalogSearchToggle" class="title"><i class="fa fa-list"></i> ヘアスタイルを探す <i class="fa toggle fa-toggle-down"></i></--></h3>

          <?php //hp_stylist_term(); ?>
          <?php hp_catalog_search(); ?>
        </div>
      </div>


      <!-- ヘアスタイル一覧 -->
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroller-body catalog-archive">
        <?php if( have_posts() ) : ?>
        <div class="row">
          <?php while( have_posts() ) : the_post(); ?>

          <!-- <div class="col-xs-6 col-sm-4 col-md-3 item"> -->
          <div class="item">
            <article>
              <a href="<?php the_permalink(); ?>" class="thumb"><?php mio_get_catalog_thumb('catalog-loop'); ?></a>
              <div class="meta-box">
                <h2 class="style-name"><a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i><?php the_title_attribute(); ?></a></h2>

                <hr class="border-catalog">

                <ul class="list-inline meta">
                  <li class="manage"><?php hp_stylist_manage(); ?></li>
                  <li class="staff"><?php hp_stylist_name(); ?></li>
                </ul>
              </div>
            </article>
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
