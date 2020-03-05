<?php
function hp_term_link_list( $args = array() ) {
  $defaults = array(
    'post_type' => 'post',
    'taxonomy' => 'category',
    'ul_class' => '',
    'home_class' => 'home-all',

  );
}

// ヘアカタログのスタイリスト別ターム出力
function hp_stylist_term() {
  $taxonomy = 'com_category';
  $term_args = array(
    'pad_counts' => true,
    'hide_empty' => true
  );
  $terms = get_terms($taxonomy, $term_args);

  if( count($terms) !== 0 ) {
    $home_current = is_post_type_archive() ? ' class="current"' : '';
    $all_link = get_post_type_archive_link('catalog');
    echo '<ul class="list-inline">';
    echo '<li'.$home_current.'><a href="'.esc_url($all_link).'">全て</a></li>';
    foreach( (array) $terms as $term ) {
      $term_link = get_term_link( $term );
      if( is_wp_error($term_link) ) {
        continue;
      }
      $is_object_term = is_object_in_term( get_the_ID(), $taxonomy, $term->term_id );

      $current = $is_object_term && !is_wp_error($is_object_term) && !is_post_type_archive() && is_tax('com_category') ? ' class="current"' : '';
      echo '<li'.$current.'><a href="'.esc_url($term_link).'">'.$term->name.'</a></li>';
    }
    echo '</ul>';
  }
}

function get_hp_stylist_name() {
  global $post;
  $terms = get_the_terms( $post->ID, 'com_category' );
  $term = $terms && !empty($terms) ? $terms[0] : false;
  if( $term ) {
    return $term->name;
  }
  return NULL;
}
function hp_stylist_name() {
  $stylist = get_hp_stylist_name();
  if( !empty($stylist) ) {
    echo esc_html($stylist);
  }
}
function get_hp_stylist_manage($post_id = 0) {
  global $post;
  $catalog_term = get_the_terms( $post->ID, 'com_category' );
  // var_dump($catalog_term);
  if( $catalog_term ) {
    $staff_args = array(
      'post_type' => 'staff',
      'tax_query' => array(
        array(
          'taxonomy' => 'com_category',
          'field' => 'term_id',
          'terms' => array($catalog_term[0]->term_id)
        )
      )
    );
    $staff_query = new WP_Query($staff_args);
    if( $staff_query->have_posts() ) : $staff_query->the_post();
      $manages = get_field('manage', $post->ID);

      $str = null;
      foreach( $manages as $manage ) {
        $str .= !empty($str) ? '・' : '';
        $str .= $manage->name;
      }
      // $manage = $manages && !empty($manages) ? $manages[0] : NULL;
      if ( !is_null($str) ) {
        return $str;
      }
		endif;
		// $manages = get_field('manage', $post_id);

		$str = '';
		if ($manages) {
			foreach( $manages as $manage ) {
				if ( ! empty($str)) {
					$str .= '・';
				}
				$str .= $manage->name;
			}
			return $str;
		}
  } else {
    return 'Not term staff.';
  }
  // wp_reset_postdata();
  return NULL;
}
function hp_stylist_manage() {
  $manage = get_hp_stylist_manage();
  if( !empty($manage) ) {
    echo '<span>' . esc_html($manage) . '</span>';
  }
}
function hp_stylist_photo() {
  global $post;
  $term = get_the_terms($post->ID, 'com_category');
  $staff_args = array(
    'post_type' => 'staff',
    'tax_query' => array(
      array(
        'taxonomy' => 'com_category',
        'field' => 'id',
        'terms' => $term[0]->term_id
      )
    )
  );
  $staff_query = new WP_Query($staff_args);
  if( $staff_query->have_posts() ) : $staff_query->the_post();
    $thumb_id = get_post_thumbnail_id($post->ID);
    $thumb = wp_get_attachment_image($thumb_id, 'admin-thumb');
    $link = get_permalink();
    $name = get_the_title();
    // var_dump($thumb);
    echo '<a href="'.$link.'"><span class="thumb">'.$thumb.'</span><span class="name">'.$name.'<i class="fa fa-angle-right"></i></span></a>';
  endif;
}



// チャンネル
function hp_channel_check() {
  global $wp_query;
  $posted = $wp_query->posts;
  $yt_id = array();
  foreach( $posted as $posts ) {
    $youtube = function_exists('get_field') ? get_field('hp_youtube_id', $posts->ID) : null;
    $ids = null;
    if( !empty($youtube) ) {
      // 直URLの場合
      if( strpos($youtube, "youtube.com") !== FALSE || strpos($youtube, "youtu.be") !== FALSE ) {
        $ids = 'ok';
      }
    }
    if( is_null($ids) ) {
      $yt_id += array($posts->ID);
      continue;
    }
  }
  return $yt_id;
}


// カタログサーチ
function hp_catalog_search() {
  $post_type_link = get_post_type_archive_link('catalog');

  echo '<div id="catalogSearchBox" class="catalog-search-wrapper">';
  echo '<form name="csForm" id="catalogSearchForm" method="post" action="'.$post_type_link.'">';

  /*
   * スタイリストのラジオボタン作成
   */
  if( taxonomy_exists('com_category') ) {
    $stylist_args = array(
      'hide_empty' => 1
    );
    $stylist_terms = get_terms('com_category', $stylist_args);
    if( !empty($stylist_terms) ) {
      echo '<div class="catalog_search searchStylist">';
      echo '<div class="head">スタイリスト別</div><div class="radio">';
      echo '<span class="cr"><input id="stylistAll" class="stylistAll" type="radio" name="stylist[]" value=""><label for="stylistAll">全て</label></span>';
      foreach( $stylist_terms as $stylist ) {
        $slug = $stylist->slug;
        $term_id = $stylist->term_id;
        $name = $stylist->name;
        echo '<span class="cr"><input id="'.$slug.'" class="'.$slug.'" type="radio" name="stylist[]" value="'.$slug.'"><label for="'.$slug.'">'.$name.'</label></span>';
      }
      echo '</div>';
      echo '</div>';
    }
  }


  /*
   * レングスのラジオボタン作成
   */
  if( taxonomy_exists('catalog_length') ) {
    $length_args = array(
      'hide_empty' => 1
    );
    $length_terms = get_terms('catalog_length', $length_args);

    if( !empty($length_terms) ) {
      echo '<div class="catalog_search searchLength">';
      echo '<div class="head">レングス別</div><div class="radio">';
      echo '<span class="cr"><input id="lengthAll" class="lengthAll" type="radio" name="length[]" value=""><label for="lengthAll">全て</label></span>';
      foreach( $length_terms as $length ) {
        $slug = $length->slug;
        $term_id = $length->term_id;
        $name = $length->name;
        echo '<span class="cr"><input id="'.$slug.'" class="'.$slug.'" type="radio" name="length[]" value="'.$slug.'"><label for="'.$slug.'">'.$name.'</label></span>';
      }
      echo '</div>';
      echo '</div>';
    }
  }

  /*
   * タグのラジオボタン生成
   */
  if( taxonomy_exists('catalog_tag') ) {
    $tag_args = array(
      'hide_empty' => 1
    );
    $tag_terms = get_terms('catalog_tag', $tag_args);

    if( !empty($tag_terms) ) {
      echo '<div class="catalog_search searchTag">';
      echo '<div class="head">イメージ別</div><div id="searchTagCheckbox" class="radio">';
      echo '<span class="cr"><input id="tagAll" class="tagAll" type="checkbox" name="catalog_tag[]" value=""><label for="tagAll">全て</label></span>';

      foreach( $tag_terms as $tag ) {
        $slug = $tag->slug;
        $term_id = $tag->term_id;
        $name = $tag->name;
        $str = '<span class="cr"><input id="tag'.$term_id.'" type="checkbox" name="catalog_tag[]" value="'.$slug.'"><label for="tag'.$term_id.'">'.$name.'</label></span>';
        echo $str;
      }
      echo '</div>';
      echo '</div>';
    }
  }
  echo '<div class="cs_submit"><input type="button" id="ls" value="検索する" class="btn btn-primary btn-lm"></div>';
  echo '</form>';
  echo '</div>';
}
