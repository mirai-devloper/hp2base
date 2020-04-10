<?php get_header(); ?>

<!-- ここから - コンテンツ -->
<div id="menu" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page"><span class="en">Menu</span><span class="jp">メニュー</span></h2>

    <div class="row">
      <?php if( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
					<?php get_template_part('temp', 'menu'); ?>
				<?php endwhile; ?>
      <?php else : ?>
				<?php if( is_admin_bar_showing() ) : ?>
					<p><span style="color: #f00;">システム：メニューが作成されていません。メニューを作成して、公開をしてください。</span></p>
				<?php else : ?>
					<p>申し訳ございません。こちらのページはまだ作成が完了していないようです。</p>
					<p>完成するまで今しばらくお待ちください。</p>
				<?php endif; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>
<!-- /#menu -->

<?php get_footer(); ?>
