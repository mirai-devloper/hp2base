<?php //var_dump($wp_query->query, $wp_query->query_vars); ?>
<!-- ここから - コンテンツ -->

<div id="blog" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2>

    <div class="row blog-wrapper">
      <div class="col-xs-12 col-md-9">
        <?php hp_search_found(); ?>
        <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
        <article class="post-archive">
          <?php if( mio_is_mobile() ) : ?>
          <a href="<?php the_permalink(); ?>" class="post-link">
            <div class="post-content clearfix">
              <div class="post-header">
                <h3 class="title"><?php the_title_attribute(); ?></h3>
                <div class="meta">
                  <time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>

                  <?php hp_cat_parent(array('anchor' => false)); ?>
                </div>
              </div>
              <?php //get_template_part('social', 'count'); ?>
              <?php if( !mio_is_mobile() ) : ?>
              <p class="content"><?php
              $content = strip_shortcodes(get_the_content());
              echo mio_get_excerpt(strip_tags($content), 160, '...'); ?></p>
              <span class="btn btn-default btn-sl"><i class="fa fa-angle-right"></i><span>続きを読む</span></span>
              <?php endif; ?>
            </div>
            <div class="thumb">
              <?php mio_get_thumbnail('square'); ?>
            </div>
          </a>
          <?php else : ?>
          <div class="post-link">
            <div class="post-content clearfix">
              <div class="post-header">
                <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a></h3>
                <div class="meta">
                  <time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>
                  <?php //get_template_part('social', 'count'); ?>
                  <?php hp_cat_parent(); ?>
                </div>
              </div>
              <?php if( !mio_is_mobile() ) : ?>
              <p class="content"><?php
              $content = strip_shortcodes(get_the_content());
              echo mio_get_excerpt(strip_tags($content), 160, '...'); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn-default btn-sl"><i class="fa fa-angle-right"></i><span>続きを読む</span></a>
              <?php endif; ?>
            </div>
            <div class="thumb">
              <?php mio_get_thumbnail('square'); ?>
            </div>
          </div>
          <?php endif; ?>
        </article>
        <?php endwhile; ?>
        <?php pagination(); ?>
        <?php else : ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>

      <div class="col-xs-12 col-md-3">
        <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</div>
<!-- /#blog -->

