<!-- ここから - コンテンツ -->
<div id="channel" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page">
			<span class="en">Channel</span>
			<span class="jp">チャンネル</span>
		</h2>

		<div class="row">
			<div class="col-xs-12 channel-loop">
			<?php if( have_posts() ) : ?>
				<?php while( have_posts() ) : the_post(); ?>
					<?php
						// カスタムフィールドの値を取得
						$yt_url = function_exists('get_field') ? get_field('hp_youtube_id') : null;

						// YouTubeIDを格納する変数初期化
						$id = null;

						$youtube_embed = '//www.youtube.com/embed/';

						$yt_play_button = '<span class="yt_error">URLの設定に間違いがあります。</span>';
						$linked = '#';
						$imaged = '';
						$class = '';

						// カスタムフィールドの値があれば実行
						if( !empty($yt_url) ) {
							// 直URLの場合
							if( preg_match('/.*v=([\d\w|-]+).*/', $yt_url, $match) ) {
								$id = $match[1];
							}

							// 短縮の場合
							if( preg_match('/.*youtu.be\/([\d\w|-]+).*/', $yt_url, $match) ) {
								$id = $match[1];
							}

							if (!is_null($id)) {
								// $idに値があればボタンを表示。値がNULLの場合はエラー文を表示。
								$yt_play_button = '<span class="btn-play"></span>';

								// $idに値があればembedのURLを、なければvoid(0)でリンクを反応させないようにする
								// $linked = !is_null($id) ? esc_url($youtube_embed.$id.'?autoplay=1') : 'javascript: void(0);';
								$linked = esc_url($yt_url);

								// $idに値があれば動画のサムネイルを取得する。なければ空を返す。
								$imaged = '<img src="http://i.ytimg.com/vi/'.$id.'/hqdefault.jpg" alt="">';

								// $idに値があればクラスを付与。なければ空を返す。
								// $class = !is_null($id) ? 'youtube fancybox.iframe' : '';
								$class = '';
							}
						}

					?>
					<div class="item single">
						<h2 class="title">
							<span><?php the_title_attribute(); ?></span>
						</h2>
						<a href="<?= $linked; ?>" class="<?= $class; ?>" data-lity>
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
						</a>
					</div>
				<?php endwhile; ?>
				<?php hp_single_pager(array('next' => '前の動画', 'prev' => '次の動画')); ?>
			<?php else : ?>
				<p class="warning">お探しの動画が見つかりませんでした。</p>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?php if (isset($fancybox)) : ?>
<script>
(function($) {
	console.log(Helper)
	var sp_w = isMobile() ? '100%' : '80%';
	var sp_h = isMobile() ? '35.25%' : '80%';
	var sp_border = isMobile() ? 3 : 6;
	$('.youtube').fancybox({
		maxWidth: 1280,
		maxHeight: 720,
		padding: sp_border,
		fitToView: false,
		width: sp_w,
		height: sp_h,
		autoSize: false
	})
})(jQuery);
</script>
<?php endif; ?>