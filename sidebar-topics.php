<?php $gtdu = get_template_directory_uri(); ?>
<div id="sidebar" class="sidebar">
  <div id="search-mio" class="widget widget_search">
    <form role="search" method="get" id="searchformMio" class="searchform" action="<?php echo esc_url(get_post_type_archive_link('topics')) ?>">
      <div>
        <!-- <input type="hidden" name="post_type" value="topics"> -->
        <input type="text" value="" name="s" id="s" placeholder="キーワード検索ができます">
        <button type="submit" id="searchsubmitMio">
          <i class="fa fa-search"></i>
        </button>
      </div>
    </form>
  </div>

  <div id="widget-newpost" class="widget widget_newpost topics">
    <h4 class="widgettitle">新着記事</h4>
    <ul>
      <?php
      $newpost = new WP_Query("post_type=topics&orderby=date&order=DESC&showposts=3");
      if( $newpost->have_posts() ) :
        while( $newpost->have_posts() ) : $newpost->the_post(); ?>
          <li>
            <div>
              <time datetime="<?php the_time('c') ?>" class="en"><?php the_time('Y.m.d') ?></time>
              <a href="<?php the_permalink() ?>" class="title"><?php echo mio_get_excerpt(strip_tags(get_the_title()), 32); ?></a>
            </div>
          </li>
        <?php endwhile;
      endif;
      wp_reset_postdata();
      ?>
    </ul>
  </div>
  <!-- /.widget_newpost -->

  <div id="widget-archive" class="widget widget_archive topics">
    <h4 class="widgettitle">アーカイブ</h4>
    <ul>
      <?php mio_the_archives_list('topics', 1) ?>
    </ul>
  </div>
  <!-- /.widget_archive -->
</div>
<!-- /#sidebar -->