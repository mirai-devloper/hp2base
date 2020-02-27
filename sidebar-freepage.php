<?php $gtdu = get_template_directory_uri(); ?>
<div id="sidebar" class="sidebar">
  <?php
  $freespace_check = function_exists('get_field') ? get_field('free_space_hidden', 'option') : false;
  if( $freespace_check ) :
?>
<div id="sidebarFreespace" class="widget-freespace">
      <?php
        $freespace = function_exists('get_field') ? get_field('free_space', 'option') : null;
        if( !empty($freespace) ) {
          foreach( (array) $freespace as $item ) {
            // 画像取得
            $image = '';
            if( !empty($item['image']) ) {
              $image_obj = wp_get_attachment_image_src( $item['image'], 'front-free-thumb');
              $image = '<img src="'.esc_url($image_obj[0]).'" width="'.esc_attr($image_obj[1]).'" height="'.esc_attr($image_obj[2]).'" alt="">';
            } else {
              $image = '<span class="not-thumb"></span>';
            }
            
            // リンク取得
            $link = '';
            if( $item['url_customer'] ) {
              $link = $item['url'] ? $item['url'] : 'javascript: void(0);';
            } else {
              $link = $item['url_selector'] ? $item['url_selector'] : 'javascript: void(0);';
            }

            // タイトル
            $title = '';
            if( !empty($item['link_text']) ) {
              $title = '<figcaption>'.wp_kses_post($item['link_text']).'</figcaption>';
            }
            $str = <<< __HTML__
<div class="item">
  <figure class="freespace">
    <a href="$link">
      $image
      $title
    </a>
  </figure>
</div>
__HTML__;
            echo $str;
          }
        }
      ?>
</div>
<!-- /#freespace -->
<?php endif; ?>
</div>
<!-- /#sidebar -->
