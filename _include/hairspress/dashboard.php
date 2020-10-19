<?php
/**
 * ダッシュボードのカスタマイズ
 */
new HP_Dashboard;

class HP_Dashboard extends HP_Acf
{
	public function __construct()
	{
		add_shortcode('reserve_btn', array($this, 'reserve_btn_shortcode'));
		add_action('wp_dashboard_setup', array($this, 'dashboard'));
		add_action('admin_menu', array($this, 'manual_admin'));
	}

	/**
	 * wp_add_dashboard_widgetの短縮
	 *
	 * @param string $widget_id
	 * @param string $title
	 * @param string|array $callback
	 */
	public function add($widget_id, $title, $callback)
	{
		wp_add_dashboard_widget($widget_id, $title, $callback);
	}

	// ダッシュボード
	public function dashboard()
	{
		global $wp_meta_boxes;

		// Instagram
		// $token = get_option('instagram_field');
		// if (empty($token))
		// {
		// 	$this->add('hp_instagram', 'Instagramの設定', array($this, 'instagram'));
		// 	$my_widget = $wp_meta_boxes['dashboard']['normal']['core']['hp_instagram'];
		// 	unset($wp_meta_boxes['dashboard']['normal']['core']['hp_instagram']);
		// 	$wp_meta_boxes['dashboard']['normal']['high']['hp_instagram'] = $my_widget;
		// }

		// マニュアル
		$this->add('hp_dashboard_manual_pdf', 'マニュアルPDF', array($this, 'manual'));

		// 予約ボタン
		if (reserve_url())
			$this->add('hp_dashboard_reserve_btn', 'ネット予約ボタン', array($this, 'reserve_btn'));

		// 契約期間
		// $this->add('hp_dashboard_service_days', '契約期間', array($this, 'service_days'));
	}

	// 予約ボタンウィジェット
	public function reserve_btn()
	{
		$image_path = get_template_directory().'/assets/images/common/btn_reserve.png';
		$new_path = ABSPATH.'btn_reserve.png';
		if ( ! file_exists($new_path)) {
			if ( ! copy($image_path, $new_path)) {
				echo 'faild';
			}
		}

		if (reserve_url() and file_exists($new_path))
		{
			?>
<div class="inside">
	<div id="dashboard_reserve_btn">
		<h4>ブログ用のネット予約ボタン</h4>
		<div>
			<input type="text" id="reserve_btn" value="[reserve_btn]" onclick="select()">
			<p>上のコードをコピーして、ブログを書いてる場所などに貼り付けることで利用可能です。<br>以下のようにリンク付きで画像が表示されます。</p>
			<p><?= do_shortcode('[reserve_btn]'); ?></p>
		</div>
	</div>
</div>
<style>
#dashboard_reserve_btn img {
	max-width: 100%;
	height: auto;
}
#dashboard_reserve_btn input {
	width: 100%;
}
</style>
			<?php
		}
	}

	// 予約ボタンのショートコード
	public function reserve_btn_shortcode()
	{
		$root_url = is_multisite() ? network_home_url() : site_url().'/';
		$home_url = $root_url.'btn_reserve.png';
		if ($reserve_url = reserve_url())
		{
			return sprintf(
				'<a href="%1$s" target="_blank">%2$s</a>',
				$reserve_url,
				'<img src="'.$home_url.'" width="160" height="66" alt="ネット予約24時間受付中！">'
			);
		}
		return null;
	}

	// Instagramウィジェット
	public function instagram()
	{
		$url = admin_url('options-general.php?page=options-instagram');
	?>
<div class="inside">
	<div id="dashboard_reserve_btn">
		<p>Instagramを利用するために設定を行って下さい。</p>
		<p><a href="<?= esc_url($url); ?>" class="button button-primary">Instagramの設定ページへ</a></p>
	</div>
</div>
	<?php
	}

	// マニュアルページ
	public function manual_admin()
	{
		add_menu_page(
			'マニュアル',
			'マニュアル',
			'edit_posts',
			'hp-manual-admin',
			array($this, 'manual'),
			'dashicons-editor-help',
			3
		);
	}

	// マニュアルウィジェット
	public function manual()
	{
		$setting = array(
			'url' => 'http://hairspress.com/wp/wp-content/uploads',
			'list' => array(
				array('ダッシュボード', '/2018/01/02a805b5ec8da06feb478d519d885e50.pdf'),
				array('ブログ・お知らせ投稿', '/2018/01/a6e4724254fe319e9846c600c0bb05cc.pdf'),
				array('スタッフ', '/2018/01/86a34b1cacd639578481a3f61b41c49e.pdf'),
				array('ヘアカタログ', '/2018/01/9b616014801799dd1350be1d96c94f2d.pdf'),
				array('アイキャッチ画像', '/2018/01/bbf338c4363902bdc3155e9103d896bc.pdf'),
				array('メニュー', '/2018/01/9536f9ed8adc5ecb6c9fb6387a3c3b3c.pdf'),
				array('チャンネル', '/2018/01/477cd4919e5e30b66d0d2273c45fb460.pdf'),
				array('フリーページ', '/2018/01/cf2aaf25282df99f00be4d49207239f9.pdf'),
				array('スライダー設定', '/2018/01/a9fd99c4f03a815d4aeb005c25caba63.pdf'),
				array('サロン情報', '/2018/01/262af9ecfd721a00ab70d1df653d6a1b.pdf'),
				array('メニューの設定', '/2018/01/612d200e608db59bb2cd0862e7e885b6.pdf'),
			)
		);

		foreach ($setting['list'] as $k => $v)
		{
			$set_url = $setting['url'].$v[1];
			$url[] = '<a href="'.$set_url.'" class="openManualWindow">'.$v[0].'</a>';
		}
	?>
<div class="inside">
	<div id="dashboard_manual">
		<h2>マニュアル</h2>
		<p>マニュアルをPDFファイルでご覧に頂けます。</p>
		<p>現在開いているページ（ウィンドウ）とは別で、新しく小さいウィンドウが開きます。（パソコンのみ）</p>
		<hr>
		<h3>管理画面マニュアル</h3>
		<ul id="hpManualPdf" class="hpManual">
			<li><?= implode('</li><li>', $url); ?></li>
		</ul>
		<hr>
		<h3>Googleアナリティクスのレポートについて</h3>
		<ul id="hpManualPdf2" class="hpManual">
			<li><a href="http://hairspress.com/wp/wp-content/uploads/2018/05/93159e8270dab2fd834e88cbbf9e3590.pdf" class="openManualWindow">GoogleAnalyticsレポートについて</a></li>
		</ul>
	</div>
</div>
<script type="text/javascript">
(function($) {
	$('.openManualWindow').on('click', function() {
		event.preventDefault();
		window.open(this.href, 'hpManual', 'width=1024,height=700,menubar=no,toolbar=no,scrollbars=yes');
		return false;
	});
})(jQuery);
</script>
	<?php
	}

	// 契約日ウィジェット
	public function service_days()
	{
		if ($start = parent::get('hp_service_start', 'option'))
		{
			$today = date_i18n('Y年m月d日');
			$start_format = date('Y年m月d日', strtotime($start));
			$year2 = date('Y年m月d日', strtotime("$start +2 year -1 day"));
		?>
<p>HairsPressの契約期間を表示しています。契約日から2年となっております。</p>
<p>今日の日付：<?= $today; ?></p>
<table class="contract_table">
	<thead>
		<tr>
			<th>契約開始日</th>
			<td><?= $start_format; ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>契約満了日</th>
			<td><?= $year2; ?></td>
		</tr>
	</tbody>
</table>
<style>
.contract_table {
  width: 100%;
  border-collapse: collapse;
}
.contract_table th,
.contract_table td {
  padding: 10px 16px;
  font-size: 14px;
  text-align: center;
  border: 1px solid #ddd;
}
.contract_table th {
  background: #f0f0f0;
}
</style>
		<?php
			update_option('hp_service_end', $year2);
			update_option('hp_service_contract', $start_format.' 〜 '.$year2);
		}
	}
}
