<?php

// インスタグラム
$insta_token = "1666134066.ba9ac4f.438beac147334acfa809f4f4746d65b2";
define("INSTAGRAM_ACCESS_TOKEN", $insta_token);

// var_dump(get_option('hp_instagram_user_id') );
// add_action('updated_option', 'hp_instagram_user_set');
function hp_instagram_user_set() {
  // Advanced Custom Fields(Pro)のフィールドからインスタグラムのURLを取得する
  $instagram_url = function_exists('get_field') ? get_field('hp_salon_social_instagram', 'option') : false;

  // $instagram_urlが空でなければ実行
  if( !empty($instagram_url) ) {
    // ユーザー名を格納する変数
    $user = NULL;
    
    // インスタグラムのURLが保存されたフィールドからユーザー名を取得する
    // マッチ条件　＝　英数字._が含まれた文字列のみ
    if( preg_match('/.*instagram.com\/([\d\w_.]+).*/', $instagram_url, $match) ) {
      // $user変数に代入させる
      $user = $match[1];
    }
    // $userが空でない且つ、英数字と_.になっている場合に処理させる
    // それ以外の文字列が含まれる場合はfalseを返す
    if( !empty($user) && preg_match('/[\d\w_.]+$/', $user) ) {
      // 保存できた場合にインスタグラムの生IDを保存する
      if( update_option('hp_instagram_user_name', $user) ) {
        // インスタグラムのID検索API
        $user_api_url = 'https://api.instagram.com/v1/users/search?q='.$user.'&access_token='.INSTAGRAM_ACCESS_TOKEN;
        // WP側のGET処理
        $WP_INSTAGRAM = wp_remote_get($user_api_url);
        // レスポンスコードが200且つWPエラーがなければ、生IDを保存
        if( !is_wp_error($WP_INSTAGRAM) && $WP_INSTAGRAM['response']['code'] === 200 ) {
          $wp_json = json_decode( $WP_INSTAGRAM['body'] );
          $user_data = null;
          foreach ( $wp_json->data as $key => $val ) {
          	$username = $val->username;

          	if( $username == $user ) {
          		$user_data = $val;
          		break;
          	}
          }
          // $user_json = $wp_json->data[0];
          update_option('hp_instagram_user_id', $user_data->id);
        }
      }

    }
  } else {
  	update_option('hp_instagram_user_name', '');
  }
  
}
