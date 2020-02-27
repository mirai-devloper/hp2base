<?php get_header(); ?>

<!-- ここから - コンテンツ -->
<div id="blog" class="c-wrap">
  <div class="container">
    <!-- <h2 class="c-title-page"><span class="en">Blog</span><span class="jp">ブログ</span></h2> -->

    <div class="row">
      <div class="col-xs-12 col-md-9">
        <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
        <article class="post-single">
          <section class="post-content">
            <header class="post-header">
              <h1 class="title"><?php the_title_attribute(); ?></h1>
              <div class="meta">
                <time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>
              </div>
            </header>

            <section class="contents-body">
              <?php the_content(); ?>
            </section>
            
            <footer>
              <?php
                $pages_args = array(
                  'before' => '<div class="link-pages-wrapper"><span class="link-pages-title">ページ</span>',
                  'after' => '</div>',
                  'link_before' => '<span>',
                  'link_after' => '</span>',
                  'separator' => ''
                );
                wp_link_pages( $pages_args );
              ?>
              <?php get_template_part('social', 'button'); ?>
            </footer>
          </section>
        </article>
        <?php endwhile; ?>
        <?php hp_single_pager(); ?>
        <div class="post-moreback">
          <a href="<?php echo esc_url( get_post_type_archive_link('topics') ); ?>" class="btn btn-default btn-"><i class="fa fa-angle-left"></i><span>一覧へ戻る</span></a>
        </div>
        <?php else : ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>

      <div class="col-xs-12 col-md-3">
        <?php get_sidebar('topics'); ?>
      </div>
    </div>
  </div>
</div>
<!-- /#blog -->

<script>
(function($) {
  $(document).ready(function() {
    $('.contents-body a').fancybox({
      padding: 6,
      helpers: {
        overlay: {
          css: {
            'background' : 'rgba(0, 0, 0, 0.7)'
          }
        }
      }
    });
  });
})(jQuery);
</script>

<?php get_footer(); ?>

