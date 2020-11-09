<div id="sidebar" class="sidebar">
  <?php
		$freespace_check = get_field('free_space_hidden', 'option');
		if( $freespace_check ) :
	?>
		<div id="sidebarFreespace" class="widget-freespace">
      <?php
        $freespace = get_field('free_space', 'option');
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
