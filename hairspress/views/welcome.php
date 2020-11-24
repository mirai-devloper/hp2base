<?php
$hp_setting = get_field('hp_setting', 'option');
if (!isset($hp_setting['post_type']['catalog'])) {
	$hp_setting['post_type']['catalog'] = true;
}
if (!isset($hp_setting['post_type']['menu-contents'])) {
	$hp_setting['post_type']['menu-contents'] = false;
}
if (!isset($hp_setting['post_type']['channel'])) {
	$hp_setting['post_type']['channel'] = true;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.css" integrity="sha512-UiVP2uTd2EwFRqPM4IzVXuSFAzw+Vo84jxICHVbOA1VZFUyr4a6giD9O3uvGPFIuB2p3iTnfDVLnkdY7D/SJJQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/ja.min.js" integrity="sha512-rElveAU5iG1CzHqi7KbG1T4DQIUCqhitISZ9nqJ2Z4TP0z4Aba64xYhwcBhHQMddRq27/OKbzEFZLOJarNStLg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.1/lity.min.js" integrity="sha512-UU0D/t+4/SgJpOeBYkY+lG16MaNF8aqmermRIz8dlmQhOlBnw6iQrnt4Ijty513WB3w+q4JO75IX03lDj6qQNA==" crossorigin="anonymous"></script>
<div class="welcome-panel-content">
	<h2>HairsPressへようこそ！</h2>
	<!-- <p class="about-description"><?php _e( 'We&#8217;ve assembled some links to get you started:' ); ?></p> -->
	<div class="welcome-panel-column-container">
		<div class="welcome-panel-column">
			<h3>サイト設定</h3>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?= admin_url( 'admin.php?page=theme-salon-settings' ); ?>">サロン設定</a>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?= admin_url( 'admin.php?page=hairspress-toppage-setting' ); ?>">トップページ設定</a>
			<h3>投稿する</h3>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?= admin_url( 'post-new.php' ); ?>">ブログを投稿</a>
			<a class="button button-primary button-hero load-customize hide-if-no-customize" href="<?= admin_url( 'post-new.php?post_type=topics' ); ?>">お知らせを投稿</a>
			<p>&nbsp;</p>
			<h4>アップデート履歴</h4>
			<ul id="hpUpdateList">
				<li class="text-center"><img src="<?= admin_url('images/loading.gif') ?>" alt=""></li>
			</ul>
		</div>
		<div class="welcome-panel-column">
			<h3><?php _e( 'Next Steps' ); ?></h3>
			<ul>
				<li>
					<a href="<?= admin_url('edit-tags.php?taxonomy=manage&post_type=staff') ?>" class="welcome-icon dashicons-category">役職を管理</a>
				</li>
				<li>
					<a href="<?= admin_url('edit-tags.php?taxonomy=com_category&post_type=catalog') ?>" class="welcome-icon dashicons-category">担当者を管理</a>
				</li>
				<li>
					<a href="<?= admin_url('post-new.php?post_type=staff'); ?>" class="welcome-icon dashicons-id-alt">スタッフを追加</a>
				</li>
				<?php if ($hp_setting['post_type']['catalog']) : ?>
					<li>
						<a href="<?= admin_url('post-new.php?post_type=catalog'); ?>" class="welcome-icon dashicons-book">ヘアカタログを追加</a>
					</li>
				<?php endif; ?>
				<li>
					<a href="<?= admin_url('post-new.php?post_type=menu'); ?>" class="welcome-icon dashicons-media-spreadsheet">メニューを追加</a>
				</li>
				<li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?></li>
			</ul>
		</div>
		<div class="welcome-panel-column welcome-panel-last">
			<h3>その他の管理</h3>
			<ul>
				<li>
					<a href="<?= admin_url('post-new.php?post_type=freepage') ?>" class="welcome-icon dashicons-admin-page">サブページを追加</a>
				</li>
				<?php if ($hp_setting['post_type']['menu-contents']) : ?>
					<li>
						<a href="<?= admin_url('post-new.php?post_type=menu-contents') ?>" class="welcome-icon dashicons-media-spreadsheet">メニューコンテンツを追加</a>
					</li>
				<?php endif; ?>
				<?php if ($hp_setting['post_type']['channel']) : ?>
					<li>
						<a href="<?= admin_url('post-new.php?post_type=channel') ?>" class="welcome-icon dashicons-format-video">チャンネルを追加</a>
					</li>
				<?php endif; ?>
				<?php if ( current_theme_supports( 'widgets' ) ) : ?>
					<li>
						<?php printf( '<a href="%s" class="welcome-icon welcome-widgets">' . __( 'Manage widgets' ) . '</a>', admin_url( 'widgets.php' ) ); ?>
					</li>
				<?php endif; ?>
				<?php if ( current_theme_supports( 'menus' ) ) : ?>
					<li>
						<a href="<?= admin_url( 'nav-menus.php' ); ?>" class="welcome-icon welcome-menus">ナビゲーションの管理</a>
					</li>
				<?php endif; ?>
				<!-- <li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more">' . __( 'Learn more about getting started' ) . '</a>', __( 'https://wordpress.org/support/article/first-steps-with-wordpress-b/' ) ); ?></li> -->
				<li>
					<h4>LINEサポート</h4>
					<p><img src="https://qr-official.line.me/sid/M/ymy6901w.png" style="margin:-15px -15px 0;vertical-align: top;"><br>スマホからQRを読み取って、MIRAIサポートの友だち追加をお願い致します。</p>
				</li>
			</ul>
		</div>
	</div>
</div>
<style>
#welcome-panel {
  display: block !important;
}
#screen-options-wrap label[for="wp_welcome_panel-hide"] {
  display: none;
}
.welcome-panel-close {
  display: none;
}

.lity-close {
	top: 40px;
	right: 15px;
}
</style>
<script>
(function($) {
	$(document).ready(function() {
		var $hpUpdateList = $('#hpUpdateList');
		var information_host = 'https://manual.hairspress.com/wp-json/wp/v2/posts?categories=2';
		$.getJSON(information_host)
		.done(function(data, status, jqXHR) {
			$hpUpdateList.html('');
			$.each(data, function(index, val) {
				var date = moment(val.date);
				var li = $('<li/>', {
					html: '<time>'+date.format('YYYY年MM月DD日')+'</time>: <a href="'+val.link+'" data-lity>'+val.title.rendered+'</a>'
				});
				$hpUpdateList.append(li)
			});
		})
		.fail(function(jqXHR, status, errorThrown) {
			$hpUpdateList.html('<li>'+status+'</li>');
		});
	});
})(jQuery);
</script>