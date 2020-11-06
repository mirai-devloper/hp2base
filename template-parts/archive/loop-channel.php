<!-- ここから - コンテンツ -->
<div id="channel" class="c-wrap">
  <div class="container">
    <h2 class="c-title-page"><span class="en">Channel</span><span class="jp">チャンネル</span></h2>

    <?php
      // $current_term_id = get_queried_object_id();
      $terms = get_terms('channel_category');
      if( !empty($terms) ) : ?>
      <div class="row channel-category">
        <h3 class="cat-link-title">カテゴリで絞り込む</h3>
        <ul class="cat-link">
        <?php
          $home_current = is_post_type_archive() ? ' class="current channel-all"' : ' class="channel-all"';
          $all_link = get_post_type_archive_link('channel');
          echo '<li'.$home_current.'><a href="'.esc_url($all_link).'">全て</a></li>';
          foreach( (array) $terms as $key => $term ) {
            $link = get_term_link($term);
            if( is_wp_error($link) ) {
              continue;
            }
            $current = is_object_in_term( get_the_ID(), 'channel_category', $term->term_id ) && !is_post_type_archive() ? ' class="current"' : '';
            echo '<li'.$current.'><a href="'.esc_url($link).'">'.esc_html($term->name).'</a></li>';
          }
        ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-xs-12 channel-loop">
      <?php
        if( have_posts() ) :
          while( have_posts() ) : the_post();

          // カスタムフィールドの値を取得
          $yt_url = function_exists('get_field') ? get_field('hp_youtube_id') : null;

          // YouTubeIDを格納する変数初期化
          $id = null;

          $youtube_embed = '//www.youtube.com/embed/';

          // カスタムフィールドの値があれば実行
          if( !empty($yt_url) ) {
            // 直URLの場合
            if( preg_match('/.*v=([\d\w|-]+).*/', $yt_url, $match) )
              $id = $match[1];

            // 短縮の場合
            if( preg_match('/.*youtu.be\/([\d\w|-]+).*/', $yt_url, $match) )
              $id = $match[1];
          }

          // $idに値があればボタンを表示。値がNULLの場合はエラー文を表示。
          $yt_play_button = is_null($id) ? '<span class="yt_error">URLの設定に間違いがあります。</span>' : '<span class="btn-play"></span>';

          // $idに値があればembedのURLを、なければvoid(0)でリンクを反応させないようにする
          $linked = !is_null($id) ? $youtube_embed.$id.'?autoplay=1&rel=0' : '#';

          // $idに値があれば動画のサムネイルを取得する。なければ空を返す。
          $imaged = !is_null($id) ? '<img src="http://i.ytimg.com/vi/'.$id.'/hqdefault.jpg" alt="">' : '';

          // $idに値があればクラスを付与。なければ空を返す。
					$class = '';
      ?>
      <div class="item">
        <a href="<?= esc_url_raw($linked); ?>" class="<?= $class; ?>" <?= ($linked === '#') ? '' : 'data-lity'; ?>>
          <span class="thumb"><?php
            echo $yt_play_button;
            // 投稿時にアイキャッチが設定されていれば、アイキャッチを優先して表示
            // アイキャッチがなければYouTubeのサムネイルを表示させる
            if( has_post_thumbnail() ) {
              the_post_thumbnail('youtube');
            } else {
              echo $imaged;
            }
          ?></span>
          <?php /* the_title_attribute()はタグを除去した状態で出力します。SCRIPTタグ対策 */ ?>
          <h3 class="title"><i class="fa fa-angle-right"></i><span><?php the_title_attribute(); ?></span></h3>
        </a>
      </div>
      <?php endwhile; ?>
      <?php pagination(); ?>
      <?php else : ?>
      <p class="warning">投稿がまだありません。</p>
      <?php endif; ?>
      </div>
    </div>
  </div>
</div>
