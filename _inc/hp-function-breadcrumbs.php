<?php

//パンくずリストを出力する関数
function breadcrumbs($args = array()){
  global $post;
  $str ='';
  $defaults = array(
    'id'            => "breadcrumbs",
    'class'         => "",
    'home'          => "トップページ",
    'search'        => "で検索した結果",
    'tag'           => "タグ",
    'author'        => "投稿者",
    'notfound'      => "404 Not found",
    'separator'     => '',
    'textContainer' => '',
    'liOption'      => ' itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="swiper-slide"',
    'aOption'       => ' itemprop="url"',
    'spanOption'    => ' itemprop="title"'
  );
  $args = wp_parse_args( $args, $defaults );
  extract( $args, EXTR_SKIP );

  //セパレータが設定されてない場合は表示なし（空白）
  if($separator == '') {
    $separatorHTML = $separator;
  } else {
    $separatorHTML = '<li>'.$separator.'</li>';
  }
  if($textContainer == '') {
    $startTextContainer =  '';
    $endTextContainer = '';
  } else {
    $startTextContainer =  '<' . $textContainer . '>';
    $endTextContainer =  '</' . $textContainer . '>';
  }

  // フロントページと投稿ページの設定をした場合、投稿ページのリンクを作成
  $page_posts = get_option('page_for_posts');
  $show_front = get_option('show_on_front') === 'page';
  $posted_link = $show_front && !empty($page_posts) ? '<li'.$liOption.'><a href="'.esc_url(get_page_link($page_posts)).'"'.$aOption.'><span'.$spanOption.'>'.wp_kses_post(get_the_title($page_posts)).'</span></a></li>' : '';


  if(is_home()) {
    echo '<ul id="'. $id .'" class="' . $class.'" itemprop="breadcrumb">';
    echo '<li' . $liOption . '><a href="'.esc_url(home_url()).'"'.$aOption.'><span' . $spanOption . '>'. wp_kses_post($home) .'</span></a></li>';
    if( $show_front ) {
      echo $posted_link;
    }
    echo '</ul>';
  }
  if(!is_home()&&!is_admin()){ //!is_admin は管理ページ以外という条件分岐
    $str.= '<ul id="'. $id .'" class="' . $class.'" itemprop="breadcrumb">';
    $str.= '<li' . $liOption . '><a href="'. esc_url(home_url()) .'/"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post($home) .'</span></a></li>';
    $str.= $separatorHTML;
    $my_taxonomy = get_query_var('taxonomy');  //[taxonomy] の値（タクソノミーのスラッグ）
    $cpt = get_query_var('post_type');   //[post_type] の値（投稿タイプ名）
    if($my_taxonomy &&  is_tax($my_taxonomy)) {//カスタム分類のページ
      $my_tax = get_queried_object();  //print_r($my_tax);
      $post_types = get_taxonomy( $my_taxonomy )->object_type;
      $cpt = $post_types[0];  //カスタム分類名からカスタム投稿名を取得。
      $str.='<li' . $liOption . '><a href="' .esc_url(get_post_type_archive_link($cpt)).'"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post(get_post_type_object($cpt)->label).'</span></a></li>';  //カスタム投稿のアーカイブへのリンクを出力
      $str.= $separatorHTML;
      if($my_tax -> parent != 0) {  //親があればそれらを取得して表示
        $ancestors = array_reverse(get_ancestors( $my_tax -> term_id, $my_tax->taxonomy ));
        foreach($ancestors as $ancestor){
          $str.='<li' . $liOption . '><a href="'. esc_url(get_term_link($ancestor, $my_tax->taxonomy)) .'"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post(get_term($ancestor, $my_tax->taxonomy)->name) .'</span></a></li>';
          $str.= $separatorHTML;
        }
      }
      $str.='<li' . $liOption . '><a href="'.esc_url(get_term_link($my_tax->term_id, $my_tax->taxonomy)).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer . wp_kses_post($my_tax->name) . $endTextContainer . '</span></a></li>';
    }elseif(is_category()) {  //カテゴリーのアーカイブページ
      if( $show_front ) {
        $str .= $posted_link;
      }
      $cat = get_queried_object();
      if($cat -> parent != 0){
        $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
        foreach($ancestors as $ancestor){
          $str.='<li' . $liOption . '><a href="'. esc_url(get_category_link($ancestor)) .'"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post(get_cat_name($ancestor)) .'</span></a></li>';
          $str.= $separatorHTML;
        }
      }
      $str.='<li' . $liOption . '><a href="'.esc_url(get_term_link($cat)).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. wp_kses_post($cat->name) . $endTextContainer . '</span></a></li>';
    }elseif(is_post_type_archive()) {  //カスタム投稿のアーカイブページ
      $cpt = get_query_var('post_type');
      if(is_date()) { //年月日アーカイブだった場合
        $str.='<li' . $liOption . '><a href="' .get_post_type_archive_link($cpt).'"' . $aOption . '><span' . $spanOption . '>'. get_post_type_object($cpt)->label.'</span></a></li>';
        if(get_query_var('day') != 0){  //日別アーカイブ
          $postTyleLink = get_post_type_archive_link(get_post_type());
          $str.='<li' . $liOption . '><a href="'. $postTyleLink . '/date/'  . get_query_var('year') . '/"' . $aOption . '><span' . $spanOption . '>' . get_query_var('year'). '年</span></a></li>';
          $str.= $separatorHTML;
          $str.='<li' . $liOption . '><a href="'. $postTyleLink . '/date/'  . get_query_var('year') . '/'  . get_query_var('monthnum'). '/"' . $aOption . '><span' . $spanOption . '>'. get_query_var('monthnum') .'月</span></a></li>';
          $str.= $separatorHTML;
          $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. get_query_var('day'). '日</strong></span></li>';
        } elseif(get_query_var('monthnum') != 0){  //月別アーカイブ
          $postTyleLink = get_post_type_archive_link(get_post_type());
          $str.='<li' . $liOption . '><a href="'. $postTyleLink . '/date/'  . get_query_var('year') . '/"' . $aOption . '><span' . $spanOption . '>'. get_query_var('year') .'年</span></a></li>';
          $str.= $separatorHTML;
          $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. get_query_var('monthnum'). '月</strong></span></li>';
        } else {  //年別アーカイブ
          $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. get_query_var('year') .'年</strong></span></li>';
        }
      } else {
        $str.='<li' . $liOption . '><a href="'.get_post_type_archive_link($cpt).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. get_post_type_object($cpt)->label . $endTextContainer . '</span></a></li>';
      }
    }elseif($cpt && is_singular($cpt)){  //カスタム投稿の個別記事ページ
      $taxes = get_object_taxonomies( $cpt );
      $mytax = !empty($taxes) ? $taxes[0] : null;
      if ( $cpt !== 'freepage' ) {
        $str.='<li' . $liOption . '><a href="' .get_post_type_archive_link($cpt).'"' . $aOption . '><span' . $spanOption . '>'. get_post_type_object($cpt)->label.'</span></a></li>';  //カスタム投稿のアーカイブへのリンクを出力
      }
      if( !empty($mytax) ) {
        $str.= $separatorHTML;
        $taxes = get_the_terms($post->ID, $mytax);
        $tax = $taxes ? get_youngest_tax($taxes, $mytax ) : NULL;  //print_r($tax);
        if( !empty($tax) ) {
          if($tax -> parent != 0){
            $ancestors = array_reverse(get_ancestors( $tax -> term_id, $mytax ));
            foreach($ancestors as $ancestor){
              $str.='<li' . $liOption . '><a href="'. get_term_link($ancestor, $mytax).'"' . $aOption . '><span' . $spanOption . '>'. get_term($ancestor, $mytax)->name . '</span></a></li>';
              $str.= $separatorHTML;
            }
          }
          if( $cpt !== 'staff' ) {
            $str.='<li' . $liOption . '><a href="'. get_term_link($tax, $mytax).'"' . $aOption . '><span' . $spanOption . '>'. $tax -> name . '</span></a></li>';
            $str.= $separatorHTML;
          }
        }
      }
      $str.= '<li' . $liOption . '><a href="'.esc_url(get_permalink(get_the_ID())).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. wp_kses_post($post->post_title) .$endTextContainer . '</span></a></li>';
    }elseif(is_single()){  //個別記事ページ
      if( $show_front ) {
        $str .= $posted_link;
      }
      $categories = get_the_category($post->ID);
      $cat = get_youngest_cat($categories);
      if($cat -> parent != 0){
        $ancestors = array_reverse(get_ancestors( $cat -> cat_ID, 'category' ));
        foreach($ancestors as $ancestor){
          $str.='<li' . $liOption . '><a href="'. esc_url(get_category_link($ancestor)).'"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post(get_cat_name($ancestor)). '</span></a></li>';
          $str.= $separatorHTML;
        }
      }
      $str.='<li' . $liOption . '><a href="'. esc_url(get_category_link($cat->term_id)). '"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post($cat->cat_name) . '</span></a></li>';
      $str.= $separatorHTML;
      $str.= '<li' . $liOption . '><a href="'.esc_url(get_permalink(get_the_ID())).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. wp_kses_post($post->post_title) .$endTextContainer . '</span></a></li>';
    } elseif(is_page()){  //固定ページ
      if($post -> post_parent != 0 ){
        $ancestors = array_reverse(get_post_ancestors( $post->ID ));
        foreach($ancestors as $ancestor){
          $str.='<li' . $liOption . '><a href="'. esc_url(get_permalink($ancestor)).'"' . $aOption . '><span' . $spanOption . '>'. wp_kses_post(get_the_title($ancestor)) .'</span></a></li>';
          $str.= $separatorHTML;
        }
      }
      $str.= '<li' . $liOption . '><a href="'.esc_url(get_permalink(get_the_ID())).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. wp_kses_post($post->post_title) .$endTextContainer . '</span></a></li>';
    } elseif(is_date()){  //日付ベースのアーカイブページ
      if( $show_front ) {
        $str .= $posted_link;
      }
      if(get_query_var('day') != 0){  //年別アーカイブ
        $str.='<li' . $liOption . '><a href="'. get_year_link(get_query_var('year')). '"' . $aOption . '><span' . $spanOption . '>' . get_query_var('year'). '年</span></a></li>';
        $str.= $separatorHTML;
        $str.='<li' . $liOption . '><a href="'. get_month_link(get_query_var('year'), get_query_var('monthnum')). '"' . $aOption . '><span' . $spanOption . '>'. get_query_var('monthnum') .'月</span></a></li>';
        $str.= $separatorHTML;
        $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. get_query_var('day'). '日</strong></span></li>';
      } elseif(get_query_var('monthnum') != 0){  //月別アーカイブ
        $str.='<li' . $liOption . '><a href="'. get_year_link(get_query_var('year')) .'"' . $aOption . '><span' . $spanOption . '>'. get_query_var('year') .'年</span></a></li>';
        $str.= $separatorHTML;
        $str.='<li' . $liOption . '><a href="'.get_month_link(get_query_var('year'), get_query_var('monthnum')).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. get_query_var('monthnum'). '月</strong></span></a></li>';
      } else {  //年別アーカイブ
        $str.='<li' . $liOption . '><a href="'.get_year_link(get_query_var('year')).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. get_query_var('year') .'年</strong></span></a></li>';
      }
    } elseif(is_search()) {  //検索結果表示ページ
      $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. '「'. get_search_query() .'」'. $search .$endTextContainer . '</span></li>';
    } elseif(is_author()){  //投稿者のアーカイブページ
      $str .='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer. $author .' : '. get_the_author_meta('display_name', get_query_var('author')).$endTextContainer . '</span></li>';
    } elseif(is_tag()){  //タグのアーカイブページ
      if( $show_front ) {
        $str .= $posted_link;
      }

      $str.='<li' . $liOption . '><a href="'.esc_url(get_tag_link(get_queried_object_id())).'"><span' . $spanOption . '>' . $startTextContainer. $tag .' : '. single_tag_title( '' , false ). $endTextContainer . '</span></a></li>';
    } elseif(is_attachment()){  //添付ファイルページ
      $str.= '<li' . $liOption . '><a href="'.get_permalink(get_the_ID()).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. $post -> post_title .$endTextContainer . '</span></a></li>';
    } elseif(is_404()){  //404 Not Found ページ
      $str.='<li' . $liOption . '><span' . $spanOption . '>' . $startTextContainer.$notfound.$endTextContainer . '</span></li>';
    } else{  //その他
      $str.='<li' . $liOption . '><a href="'.get_permalink(get_the_ID()).'"'.$aOption.'><span' . $spanOption . '>' . $startTextContainer. wp_title('', true) .$endTextContainer . '</span></a></li>';
    }
    $str.='</ul>';
  }
  echo $str;
}
//一番下の階層のカテゴリーを返す関数
function get_youngest_cat($categories){
  global $post;
  if(count($categories) == 1 ){
    $youngest = $categories[0];
  }
  else{
    $count = 0;
    foreach($categories as $category){  //それぞれのカテゴリーについて調査
      $children = get_term_children( $category -> term_id, 'category' );  //子カテゴリーの ID を取得
      if($children){  //子カテゴリー（の ID ）が存在すれば
        if ( $count < count($children) ){  //子カテゴリーの数が多いほど、そのカテゴリーは階層が下なのでそれを元に調査するかを判定
          $count = count($children);  //$count に子カテゴリーの数を代入
          $lot_children = $children;
          foreach($lot_children as $child){  //それぞれの「子カテゴリー」について調査 $childは子カテゴリーのID
            if( in_category( $child, $post -> ID ) ){  //現在の投稿が「子カテゴリー」のカテゴリーに属するか
              $youngest = get_category($child);  //属していればその「子カテゴリー」が一番若い（一番下の階層）
            }
          }
        }
      }
      else{  //子カテゴリーが存在しなければ
        $youngest = $category;  //そのカテゴリーが一番若い（一番下の階層）
      }
    }
  }
  return $youngest;
}
//一番下の階層のタクソノミーを返す関数
function get_youngest_tax($taxes, $mytaxonomy){
  global $post;
  if(count($taxes) == 1 ){
    $youngest = $taxes[key($taxes)];
  }
  else{
    $count = 0;
    foreach($taxes as $tax){  //それぞれのタクソノミーについて調査
      $children = get_term_children( $tax -> term_id, $mytaxonomy );  //子タクソノミーの ID を取得
      if($children){  //子カテゴリー（の ID ）が存在すれば
        if ( $count < count($children) ){  //子タクソノミーの数が多いほど、そのタクソノミーは階層が下なのでそれを元に調査するかを判定
          $count = count($children);  //$count に子タクソノミーの数を代入
          $lot_children = $children;
          foreach($lot_children as $child){  //それぞれの「子タクソノミー」について調査 $childは子タクソノミーのID
            if( is_object_in_term( $post -> ID, $mytaxonomy ) ){  //現在の投稿が「子タクソノミー」のタクソノミーに属するか
              $youngest = get_term($child, $mytaxonomy);  //属していればその「子タクソノミー」が一番若い（一番下の階層）
            }
          }
        }
      }
      else{  //子タクソノミーが存在しなければ
        $youngest = $tax;  //そのタクソノミーが一番若い（一番下の階層）
      }
    }
  }
  return $youngest;
}
