<?php
add_action('admin_menu', 'options_instagram');
function options_instagram() {
  add_options_page(
  	// 'options-general.php',
    'Instagramの設定',
    'Instagramの設定',
    'edit_posts',
    'options-instagram',
    'options_edit_instagram'
  );
  add_action('admin_init', 'mio_general_instagram');
}

function options_edit_instagram() { ?>
<div class="wrap">
	<h2>Instagramの利用</h2>
	<form name="oAuthInstagram" method="post" action="https://mi-rai.co.jp/api/instagram/">
		<div style="border: 2px dashed #999; max-width: 880px; padding: 5px 15px;">
			<input type="hidden" name="miraiOAuth" value="<?php echo sha1(uniqid(mt_rand(),true)); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<th><input type="submit" value="Instagramの認証を行う" class="button button-primary"></th>
						<td>
							<p>左にあるボタンを押すことで、自動的に認証を行うためのページへ行きます。<br><strong style="color: #f00;">Instagramへのログインが必要です。</strong></p>
							<p>初回認証の時にInstagramへの認証画面が出ますので、必ず「<strong style="color: #0a0;">Authorize（緑色のボタン）</strong>」を押して下さい。</p>
							<p>Authorizeボタンを押した後に、現在のページまで自動的に戻りますので、<br>今現在表示されているページへ戻ってきましたら、必ず「<strong style="color: #e60;">Access_token</strong>」の中に何かしらの文字が入っているか確認後、「変更を保存」ボタンを押して保存してください。</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	<form name="formInstagram" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<div>
		<?php wp_nonce_field('mio-nonce-key', 'options-instagram'); ?>
		<?php //$tax = get_option('mio-tax'); ?>
		<?php settings_fields('instagram_setting_group'); ?>
		<?php do_settings_sections( 'options-instagram' ); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><input type="button" id="instagramAjaxTest" value="接続テストを行う" class="button button-secondary"></th>
					<td>
						<div class="instagram-photo">
							<h4 style="margin-bottom: 8px;">Instagramの動作確認エリア</h4>
							<p style="font-size: 12px; padding: 0; text-align: left;">※Instagramの写真が取得出来るか確認ができます。</p>
							<div id="instagramTest"></div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
		<!-- <p><input type="number" step="1" min="0" max="100" name="mio-tax" value="<?php //echo $tax; ?>"></p> -->
		<!-- <p><input type="submit" value="<?php //echo esc_attr( '設定を保存' ); ?>" class="button button-primary button-large"></p> -->
		</div>
	</form>
	<?php instagram_test(); ?>
<script type="text/javascript">
window.onload = function() {
	var hash = window.location.hash;
	var token_hash = hash.split('access_token=');
	if ( hash && hash.match(/access_token=/) ) {
		document.formInstagram.instagram_field.value = token_hash[1];
	}
	// console.log(token_hash, window.location.hash);
}
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#instagramAjaxTest').on('click', function() {
		var token = $('#instagram_field').val();
		var user = $('#instagram_username_2').val();
		var tag = $('#instagram_tags').val();
		var permissions = document.formInstagram.instagram_permision.value;
		if ( token !== '' && (permissions === 'user') || (permissions === 'username' && user !== '') || (permissions === 'tags' && tag !== '') ) {
			var permission = 'https://api.instagram.com/v1/users/self/media/recent/';
			if ( permissions === 'username' && user !== '' ) {
				permission = 'https://api.instagram.com/v1/users/'+user+'/media/recent/';
			} else if ( permissions === 'tags' && tag !== '' ) {
				permission = 'https://api.instagram.com/v1/tags/'+encodeURIComponent(tag)+'/media/recent';
			}
			$.ajax({
				url: permission,
				type: 'GET',
				dataType: 'jsonp',
				data: {
					count : 5,
					access_token : token
				},
				timeout: 10000,
				success: function(data, textStatus, jqXHR) {
					var obj = data.data;
					var test = $('#instagramTest');
					var list = '';
					console.log(data);
					if ( obj.length >= 1 ) {
						list += '<ul class="instagram-list">';
						for ( var i = 0, len = obj.length; i < len; i++ ) {
							var type = obj[i].type;
							var images = obj[i].images.low_resolution;
							if ( type === 'video' ) {
								var video = obj[i].videos.low_resolution;
								list += '<li><video src="'+video.url+'" width="'+images.width+'" height="'+images.height+'" autobuffer autoplay autoloop loop muted="muted" poster="'+images.url+'"></video></li>';
							} else {
								list += '<li><img src="'+images.url+'" width="'+images.width+'" height="'+images.height+'" alt=""></li>';
							}
						}
						list += '</ul>';
						test.html(list);
					} else {
						list = '<p>投稿がないか、見つけられなかったため、取得できませんでした。</p>';
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log('error');
					$('#instagramTest').text('Instagramへ接続できませんでした。');
				}
			});

		} else {
			if ( permissions === 'username' && user === '' ) {
				$('#instagramTest').html('<p class="error">指定のユーザー名が空になっています。</p>');
			} else if ( permissions === 'tags' && tag === '' ) {
				$('#instagramTest').html('<p class="error">ハッシュタグが空になっています。</p>');
			} else {
				// $('#instagramTest').text('');
			}
		}
	});
});
</script>
</div>
<?php
}

add_action('admin_init', 'mio_instagram_admin_init');
function mio_instagram_admin_init() {
	$instagram_array = array(
		'token' => 'instagram_field',
		'permission' => 'instagram_permision',
		'user' => 'instagram_username',
		'tags' => 'instagram_tags'
	);
	if ( isset($_POST['options-instagram']) && $_POST['options-instagram'] ) {
		if ( check_admin_referer('mio-nonce-key', 'options-instagram') ) {
			foreach ( $instagram_array as $key => $val ) {
				if ( isset($_POST[$val]) && $_POST[$val] ) {
					update_option($val, $_POST[$val]);
				} else {
					update_option($val, '');
				}
			}
		}
	}
}

// add_action('init', 'mio_tax_default');
function mio_instagram_default() {
  $instagram = get_option('mio_instagram');
  if( !$instagram && empty($instagram) ) {
    update_option('mio_instagram', 8);
  }
}

// add_action('admin_init', 'mio_tax_init');
function mio_instagram_init() {
  if( isset( $_POST['options-instagram'] ) && $_POST['options-instagram'] ) {
    if( check_admin_referer( 'mio-nonce-key', 'options-instagram' ) ) {
      $e = new WP_Error();
      if( isset( $_POST['mio_instagram']) && $_POST['mio_instagram'] ) {
        if( is_numeric( trim($_POST['mio_instagram']) ) ) {
          update_option( 'mio_instagram', trim($_POST['mio_instagram']) );
          $e->add('updated', '保存しました。');
          set_transient('mio-instagram-admin-errors', array( $e->get_error_code() => $e->get_error_message()), 10 );
        } else {
          $e->add('error', '値が不正です。');
          set_transient( 'mio-instagram-admin-errors', $e->get_error_messages(), 10 );
        }

      } else {
        update_option( 'mio_instagram', '' );
      }

      wp_safe_redirect( menu_page_url('options-instagram', false) );
    }
  }
}

// add_action('admin_notices', 'mio_tax_notices');
function mio_instagram_notices() { ?>
  <?php if( $messages = get_transient('mio-instagram-admin-errors') ) : ?>
  <?php foreach( $messages as $key => $val ) :
    $error_code = $key === 'updated' ? 'updated' : 'error';
  endforeach; ?>
  <div class="<?php echo esc_attr($error_code); ?>">
    <ul>
      <?php foreach( $messages as $message ) : ?>
      <li><?php echo esc_html($message); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>
<?php
}


function mio_general_instagram() {
  // MIOテーマジェネラル設定
  add_settings_section(
    'options_instagram_id',
    'Instagramの設定',
    'mio_add_instagram_section',
    'options-instagram'
  );

  // インスタグラム
  add_settings_field(
    'instagram_field',
    'Access_token',
    'mio_instagram_field',
    'options-instagram',
    'options_instagram_id'
  );
  register_setting( 'instagram_setting_group', 'instagram_field');

  add_settings_field(
    'instagram_permision',
    'どのタイプで表示しますか？',
    'mio_instagram_permision',
    'options-instagram',
    'options_instagram_id'
  );
  register_setting( 'instagram_setting_group', 'instagram_permision');

  add_settings_field(
    'instagram_username',
    '指定のユーザー名',
    'mio_instagram_username',
    'options-instagram',
    'options_instagram_id'
  );
  register_setting( 'instagram_setting_group', 'instagram_username');

  add_settings_field(
    'instagram_tags',
    'ハッシュタグ',
    'mio_instagram_tags',
    'options-instagram',
    'options_instagram_id'
  );
  register_setting( 'instagram_setting_group', 'instagram_tags');
}
function mio_add_instagram_section() {
  // _e('E-mail used in home page', 'mio-email-generator');
  echo '<p>Instagramからデータを取得するために認証を行って下さい。</p>';
}

function mio_instagram_tags() {
	$instagram_tags = get_option('instagram_tags');
	$instagram = esc_attr($instagram_tags);
  printf(
    '<input type="text" id="instagram_tags" name="instagram_tags" value="%s" placeholder="美容室など" class="regular-text" />',
    isset($instagram_tags) ? esc_attr($instagram_tags) : ''
  );
  echo '<p><span style="color: #f00;">「＃」は無しで入力ください。また、ハッシュタグは１つまでしか検索できません。</span></p>';
  echo '<p><span style="font-size: 13px;">※注意※<br>ハッシュタグによっては、予期しないものまで取得されてしまいます。<br>その際は、プログラム側で制御できませんのでご了承下さい。</span></p>';
}

function mio_instagram_username() {
	$instagram_username = get_option('instagram_username');
	echo '<div class="instagram_user_search"><input type="text" id="userSearch" name="userSearch" value="" placeholder="ユーザー名を入力">';
	echo '<input type="button" id="userSearchBtn" name="userSearchBtn" value="検 索" class="button button-primary"><span class="in_load">読込中</span>';
	// echo '<select id="userSearchSelect" name="userSearchSelect"><option value="">ユーザー名を検索してください。</option></select>';
	echo '<p><span style="font-size: 13px; color: #454545;">入力後に検索ボタンを押してください。<br>お店のアカウントとご自身のアカウントが別の場合にご利用ください。</span></p><p class="instagram_user_error"></p></div>';
	echo '<table class="instagram_user_table">';
  printf(
  	'<tr><td width="80">UserName</td><td width="280"><input type="text" id="instagram_username" name="instagram_username[]" value="%s" class="" placeholder="ここにユーザー名が表示されます" readonly /></td><td rowspan="2"><span id="instagramUserPic"></span></td></tr>',
    isset($instagram_username) ? esc_attr($instagram_username[0]) : ''
  );
  printf(
  	'<tr><td>UserID</td><td><input type="text" id="instagram_username_2" name="instagram_username[]" value="%s" class="" placeholder="ここにユーザーIDが表示されます" readonly /></td></tr>',
    isset($instagram_username) ? esc_attr($instagram_username[1]) : ''
  );
  echo '</table>';
  echo '<p><span style="color: #f00;"></span></p>';
  $token = get_option('instagram_field');
  ?>
<style type="text/css" media="screen">
.in_load {
	opacity: 0;
}
.instagram_user_search {
	max-width: 560px;
	padding: 5px;
	border: 2px dashed #999;
}
.instagram_user_error {
	color: #f00;
}
.instagram_user_table {
	width: 100%;
}
.instagram_user_table td {
	padding: 0px;
}
.instagram_user_table input[type=text] {
	max-width: 280px;
	width: 100%;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#userSearchBtn').on('click', function() {
		var token = $('#instagram_field').val();
		var val = $('#userSearch').val();
		$('.in_load').animate({
			opacity: 1
		},300);
		// console.log(document.formInstagram.instagram_username.value);
		if ( token !== '' && $('#userSearch').val() !== '' ) {
			$.ajax({
				url: 'https://api.instagram.com/v1/users/search',
				type: 'GET',
				dataType: 'jsonp',
				data: {
					q : val,
					access_token : token
				},
				timeout: 10000,
				success: function(data, textStatus, jqXHR) {
					var obj = data.data;
					$('.instagram_user_error').text('');
					$('.in_load').animate({opacity: 0},300);
					// console.log($.inArray(val, obj.username));
					if ( obj.length > 0 ) {
						var userArray = [];
						for ( var i = 0, len = obj.length; i < len; i++ ) {
							userArray.push(obj[i].username);
							if ( i in obj && obj[i].username === val ) {
								$('#instagram_username').val(obj[i].username);
								$('#instagram_username_2').val(obj[i].id);
								$('#instagramUserPic').html('<img src="'+obj[i].profile_picture+'" width="64" height="64" alt="">');
								// console.log(obj[i]);
							}
						}
						if ( $.inArray(val, userArray) === -1 ) {
							$('.instagram_user_error').text('指定のユーザー名が見つかりませんでした');
						}
					} else {
						$('.instagram_user_error').text('指定のユーザー名が見つかりませんでした');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('error');
					$('.instagram_user_error').text('Instagramへ接続できませんでした。');
				}
			});
		} else {
			$('.in_load').animate({opacity: 0},300);
		}
	});
});
</script>
<?php
}

function mio_instagram_permision() {
	$instagram_permision = get_option('instagram_permision');
?>
<fieldset>
	<label><input type="radio" id="instagram_permision_1" name="instagram_permision" value="user" <?php checked($instagram_permision, 'user'); ?>>認証したアカウント</label>&nbsp;
	<label><input type="radio" id="instagram_permision_2" name="instagram_permision" value="username" <?php checked($instagram_permision, 'username'); ?>>指定のユーザー名</label>&nbsp;
	<label><input type="radio" id="instagram_permision_3" name="instagram_permision" value="tags" <?php checked($instagram_permision, 'tags'); ?>>ハッシュタグ</label>
	<label><input type="radio" id="instagram_permision_4" name="instagram_permision" value="none" <?php checked($instagram_permision, 'none'); ?>>非表示</label>
</fieldset>
<?php
}

function mio_instagram_field() {
  $instagram_field = get_option('instagram_field');
  $instagram = esc_attr($instagram_field);
  printf(
    '<input type="text" id="instagram_field" name="instagram_field" value="%s" class="regular-text" readonly />',
    isset($instagram_field) ? esc_attr($instagram_field) : ''
  );
}

function instagram_test() {
	?>
  <!-- <div class="instagram-photo">
  <h3>Instagramの動作確認エリア</h3>
  <p style="font-size: 12px; padding: 0; text-align: left;">※Instagramの写真が取得出来るか確認ができます。</p>
  <div id="instagramTest"></div> -->
<?php
// $token = get_option('instagram_field');
// $permission = get_option('instagram_permision');
// $tags = get_option('instagram_tags');
// $user = get_option('instagram_username');
// // var_dump($user);
// if ( ! empty($token) ) {
// 	$api_url = 'https://api.instagram.com/v1/users/self/feed?count=5&access_token='.$token;
// 	if ( $permission == 'username' && !empty($user) ) {
// 		$api_url = 'https://api.instagram.com/v1/users/'.$user[1].'/media/recent?count=5&access_token='.$token;
// 	} elseif ( $permission == 'tags' && !empty($tags) ) {
// 		$api_url = 'https://api.instagram.com/v1/tags/'.urlencode($tags).'/media/recent?count=5&access_token='.$token;
// 	}
// 	// var_dump($api_url);
// 	// WP側のGET処理
// 	$instagram_json = wp_remote_get($api_url);
// 	// var_dump($instagram_json);
// 	if ( ! is_wp_error( $instagram_json ) && $instagram_json['response']['code'] === 200 ) {
// 		$body = json_decode($instagram_json['body']);
// 		// var_dump($body);
// 		if ( !empty($body->data) && $body->meta->code === 200 ) {
// 			echo '<ul class="instagram-list">';
// 			foreach ( $body->data as $key => $val ) {
// 				// var_dump($val);
// 				$images = $val->images->low_resolution;
// 				if ( $val->type == 'video' ) {
// 					$video = $val->videos->low_resolution;
// 					echo '<li><video src="'.$video->url.'" width="'.$images->width.'" height="'.$images->height.'" autobuffer autoplay autoloop loop muted="muted" poster="'.$images->url.'"></video></li>';
// 				} else {
// 					echo '<li><img src="'.$images->url.'" width="'.$images->width.'" height="'.$images->height.'" alt=""></li>';
// 				}
// 			}
// 			echo '</ul>';
// 		} else {
// 			echo '<p>投稿が無かったため、処理を中断しました。Instagramのアプリを起動し、写真を投稿してください。</p>';
// 		}
// 	} else {
// 		// update_option('instagram_field', '');
// 		// echo '<script type="text/javascript">(function() { document.formInstagram.instagram_field.value = ""; })();</script>';
// 		if ( $permission == 'tags' ) {
// 			echo '<p>Instagramに接続できないか認証が行われていない為、取得できませんでした。</p>';
// 		} elseif( $permission == 'username' ) {
// 			echo '<p>Instagramにアカウントが削除されたか、非公開のため取得できませんでした。</p>';
// 		} else {
// 			echo '<p>Instagramの認証が完了していないか、解除された可能性があります。<br>再度認証を行ってください。</p>';
// 		}
// 	}
// 	// if( preg_match('/(\w+)/', $token, $match) ) {
// 	// 	// $user変数に代入させる
// 	// 	$user = $match[1];
// 	// 	// var_dump($user);

// 	// }
// } else {
// 	echo '<p>Instagramの認証後に動作確認の為、認証したアカウントの写真リストが表示されます。</p>';
// }
?>
<!-- </div> -->
<style type="text/css" media="screen">
.instagram-photo {
	position: relative;
	max-width: 580px;
	padding: 0 15px;
	border: 2px dashed #999;
}
.instagram-photo:before,
.instagram-photo:after {
	content: "";
	display: block;
}
.instagram-photo:after {
	clear: both;
}
.instagram-photo p {
	padding: 42px 0;
	text-align: center;
}
.instagram-list {
	/*max-width: 500px;*/
	margin: 0 -15px;
	padding: 0;
	list-style: none;
}
.instagram-list li {
	float: left;
	/*max-width: 155px;*/
	width: 20%;
	margin: 0;
	padding: 15px;
	box-sizing: border-box;
}
.instagram-list img,
.instagram-list video {
	max-width: 100%;
	height: auto;
}
</style><?php
}



// オプション取得
function mio_get_instagram() {
  $instagram_field = get_option('instagram_field');
  return $instagram_field;
}
function mio_the_instagram() {
  echo mio_get_tax();
}

function mio_get_instagram_user_id() {
	$token = get_option('instagram_field');
	if ( ! empty($token) ) {
		if( preg_match('/(\w+)/', $token, $match) ) {
			return $match[1];
		}
	}
	return NULL;
}

