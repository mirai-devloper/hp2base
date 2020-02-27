<?php
  $topic_args = array(
    'post_type'   => 'topics',
    'order'               => 'DESC',
    'orderby'             => 'date',
    'posts_per_page'         => 5,
  );
  
  $front_topics = new WP_Query( $topic_args );
?>
<?php if( $front_topics->have_posts() ) : ?>
<div id="frontInfo" class="front-info">
  <section class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-3">
        <h2 class="c-title-sm"><span class="en">Information</span></h2>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-6">
        <?php
          while( $front_topics->have_posts() ) : $front_topics->the_post(); ?>
          <article class="item row">
            <time datetime="<?php the_time('c'); ?>" class="datetime col-xs-12 col-md-2"><?php the_time('Y.m.d'); ?></time>
            <h2 class="title col-xs-12 col-md-10"><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a></h2>
          </article>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
      </div>

      <div class="col-xs-12 col-sm-2 col-md-3 front-info-more">
        <a href="<?php echo esc_url(get_post_type_archive_link('topics')); ?>" class="btn btn-shark btn-sm"><i class="fa fa-angle-right"></i>一覧を見る</a>
      </div>
    </div>
  </section>
</div>
<!-- /#frontInfo -->
<?php endif; ?>
