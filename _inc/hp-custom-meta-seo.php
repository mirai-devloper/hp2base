<?php

################################################
## METAタグFieldの追加
################################################

/* 入力項目がどの投稿タイプのページに表示されるのかの設定 */
add_action('admin_menu', 'mio_add_metafields');
function mio_add_metafields() {
  // add_meta_box(
  //   'mio_description_id',
  //   'META出力',
  //   'mio_add_meta',
  //   'post',
  //   'advanced',
  //   'high'
  // );
  add_meta_box(
    'mio_description_id',
    'META出力',
    'mio_add_meta',
    'page',
    'advanced',
    'high'
  );
}

// カスタムフィールドに設定するNAMEの配列設定
function mio_metafield_array() {
  return array(
    'description' => 'mio_description',
    'keywords' => 'mio_keyword'
  );
}

// フィールドの保存処理
add_action('save_post', 'mio_save_metatag');
function mio_save_metatag($post_id) {
  $meta_array = mio_metafield_array();
  foreach( $meta_array as $key => $val ) {
    // クエリの有無判定
    $is_post = isset($_POST[$val]) ? $_POST[$val] : '';

    // メタデータの取得
    $meta_post = get_post_meta( $post_id, $val, true );

    // 値が含まれるかどうかで保存か削除を判定
    if( strcmp( $is_post, $meta_post ) != 0 || $is_post != '') {
      // 保存
      update_post_meta( $post_id, $val, $is_post );
    } else {
      // 削除
      delete_post_meta( $post_id, $val, $meta_post );
    }
  }
}

function mio_add_meta() {
  global $post;
  $metaArray = mio_metafield_array();
  $metaval = array();
  foreach( $metaArray as $key => $val ) {
    $metaval += array( $key => get_post_meta( $post->ID, $val, true ) );
  }
  echo <<< __HTML__
<div class="meta_field">
  <label for="mio_description">ディスクリプション</label>
  <input type="text" id="mio_description" name="mio_description" value="{$metaval['description']}" size="30" placeholder="ここにディスクリプションの文章を入力" class="large-text">
  <p class="description">META Descriptionを設定します。未設定の場合はMETAタグは出力されません。 128文字程度を目安に設定してください。改行はできません。</p>
</div>

<div class="meta_field">
  <label for="mio_keyword">キーワード</label>
  <input type="text" id="mio_keyword" name="mio_keyword" value="{$metaval['keywords']}" size="30" placeholder="ここにキーワードを入力" class="large-text">
  <p class="description">META Keywordsを設定できます。未設定の場合は出力されません。 複数のキーワードを設定する場合は、半角カンマ[ , ]で区切ってください。</p>
</div>
__HTML__;
}

// 出力用の関数
add_action( 'wp_head', 'mio_the_metatag', 1 );
function mio_the_metatag() {
  global $post, $page, $paged;

  // クエリーオブジェクトIDを取得
  $object_id = get_queried_object_id();

  $arg = mio_metafield_array();
  $meta = array();
  $post_id = $object_id;
  $post_type = get_query_var('post_type');
  $search = get_query_var('s');
  $page_by_path = null;
  $is_post_type = false;
  $is_paged = (empty($page) && $paged <= 1);

  // カスタム投稿の場合に判定を行う
  if( !empty($post_type) ) {
    $page_by_path = get_page_by_path($post_type);
    if( $page_by_path ) {
      $post_id = $page_by_path->ID;
      if( $post_type === $page_by_path->post_name ) {
        $is_post_type = true;
      }
    }
  }

  if( is_page() || (is_home() && !is_front_page() && !is_category() && !is_tag() && !is_archive() && $is_paged && empty($search)) || ( $is_post_type && is_post_type_archive() && !is_tax() && $is_paged && empty($search)) ) {
    foreach( $arg as $key => $val ) {
      // post_metaを取得
      $get_meta = get_post_meta( $post_id, $val, true );

      // エラーがある場合はスキップして次のループ
      if( is_wp_error($get_meta) ) {
        continue;
      }

      // $get_meta変数が空でない場合に実行する
      if( !empty($get_meta) ) {
        $meta += array($key => array($key, $get_meta) );
        echo '<meta name="'.$meta[$key][0].'" content="'.esc_html($meta[$key][1]).'">'."\n";
      }
    }
  }
}

add_action( 'wp_head', 'mio_the_metarobots', 2 );
function mio_the_metarobots() {
  // is_archive() ||
  if(  is_paged() ) {
    echo '<meta name="robots" content="noindex">';
  }
}
