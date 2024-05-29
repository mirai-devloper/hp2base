<?php
namespace Hairspress\App;

class Wordpress_Dashboard {
  public function __construct()
  {
    add_shortcode('reserve_btn', array($this, 'reserve_button_shortcode'));
    add_action('wp_dashboard_setup', array($this, 'widget'));
    add_action('admin_menu', array($this, 'admin_menu_page'));
    add_action('admin_head', array($this, 'help'));
    add_action('init', array($this, 'setup_reserve_button'));
  }

  public function widget() {
    wp_add_dashboard_widget(
      'hp_dashboard_manual_pdf',
      'マニュアルPDF',
      array($this, 'manual_widget')
    );
    // wp_add_dashboard_widget(
    // 	'hairspress_dashboard_information',
    // 	'アップデート履歴',
    // 	array($this, 'information')
    // );

    // if (reserve_url()) {
    // 	wp_add_dashboard_widget(
    // 		'hp_dashboard_reserve_btn',
    // 		'ネット予約ボタン',
    // 		array($this, 'reserve_button')
    // 	);
    // }

    // global $wp_meta_boxes;
    // $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

    // $widget_backup = array(
    // 	'hairspress_dashboard_information' => $normal_dashboard['hairspress_dashboard_information'],
    // 	'hp_dashboard_manual_pdf' => $normal_dashboard['hp_dashboard_manual_pdf'],
    // 	'hp_dashboard_reserve_btn' => $normal_dashboard['hp_dashboard_reserve_btn'],
    // );
    // unset($normal_dashboard['hairspress_dashboard_information']);
    // unset($normal_dashboard['hp_dashboard_manual_pdf']);
    // unset($normal_dashboard['hp_dashboard_reserve_btn']);

    // $sorted_dashboard = array_merge($widget_backup, $normal_dashboard);
    // $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
  }

  public function information() {
    ?>
    <?php
  }

  public function setup_reserve_button() {
    $image_path = get_theme_file_path('assets/images/common/btn_reserve.png');
    $new_path = ABSPATH.'btn_reserve.png';
    if (!file_exists($new_path)) {
      if (!copy($image_path, $new_path)) {
        echo 'Faild';
      }
    }
  }

  public function reserve_button() {
    $image_path = get_theme_file_path('assets/images/common/btn_reserve.png');
    $new_path = ABSPATH.'btn_reserve.png';
    if (!file_exists($new_path)) {
      if (!copy($image_path, $new_path)) {
        echo 'Faild';
      }
    }

    if (reserve_url() and file_exists($new_path)) {
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
        <style>#dashboard_reserve_btn img { max-width: 100%; height: auto; } #dashboard_reserve_btn input { width: 100%; }</style>
      <?php
    }
  }

  public function reserve_button_shortcode() {
    $root_url = is_multisite() ? network_home_url() : site_url().'/';
    $home_url = $root_url.'btn_reserve.png';
    if ($reserve_url = reserve_url()) {
      return sprintf(
        '<a href="%1$s" target="_blank"><img src="%2$s" width="160" height="66" alt="%3$s"></a>',
        $reserve_url,
        $home_url,
        'ネット予約24時間受付中！'
      );
    }
  }

  public function admin_menu_page() {
    add_menu_page(
      'マニュアル',
      'マニュアル',
      'edit_posts',
      'hp-manual-admin',
      array($this, 'manual_widget'),
      'dashicons-editor-help',
      3
    );
  }

  public function manual_widget() {
    $settings = array(
      'url' => 'https://hairspress.com/wp/wp-content/uploads',
      'list' => array(
        array('ダッシュボード', '/2018/01/02a805b5ec8da06feb478d519d885e50.pdf'),
        array('ブログ・お知らせ投稿', '/2018/01/a6e4724254fe319e9846c600c0bb05cc.pdf'),
        array('スタッフ', '/2018/01/86a34b1cacd639578481a3f61b41c49e.pdf'),
        array('ヘアカタログ', '/2018/01/9b616014801799dd1350be1d96c94f2d.pdf'),
        array('アイキャッチ画像', '/2018/01/bbf338c4363902bdc3155e9103d896bc.pdf'),
        array('メニュー', '/2018/01/9536f9ed8adc5ecb6c9fb6387a3c3b3c.pdf'),
        array('チャンネル', '/2018/01/477cd4919e5e30b66d0d2273c45fb460.pdf'),
        array('サブページ', '/2018/01/cf2aaf25282df99f00be4d49207239f9.pdf'),
        // array('スライダー設定', '/2018/01/a9fd99c4f03a815d4aeb005c25caba63.pdf'),
        array('サロン設定', '/2018/01/262af9ecfd721a00ab70d1df653d6a1b.pdf'),
        array('サイトナビの設定', '/2018/01/612d200e608db59bb2cd0862e7e885b6.pdf'),
      ),
    );

    foreach ($settings['list'] as $k => $v)
    {
      $set_url = $settings['url'].$v[1];
      $url[] = sprintf(
        '<a href="%1$s" class="openManualWindow">%2$s</a>',
        $set_url,
        $v[0]
      );
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
          <li>現在調整中です。</li>
          <!-- <li><a href="http://hairspress.com/wp/wp-content/uploads/2018/05/93159e8270dab2fd834e88cbbf9e3590.pdf" class="openManualWindow">GoogleAnalyticsレポートについて</a></li> -->
        </ul>
      </div>
    </div>
    <script type="text/javascript">
    (function($) {
      $(document).on('click', '.openManualWindow', function(e) {
        e.preventDefault();
        window.open(this.href, 'hpManual', 'width=1024,height=700,menubar=no,toolbar=no,scrollbars=yes');
        return false;
      });
    })(jQuery);
    </script>
  <?php
  }

  public function help() {
    $screen = get_current_screen();

    // echo '<pre style="margin-left:240px;">';
    // var_dump($screen->id);
    // echo '</pre>';
    switch ($screen->id) {
      case 'dashboard':
        $this->help_dashboard($screen);
        break;

      default:
        # code...
        break;
    }
  }

  public function help_dashboard($screen) {
    $screen->remove_help_tabs();
    $screen->add_help_tab(
      array(
        'id'      => 'overview',
        'title'   => __( 'Overview' ),
        'content' => '<p>HairsPressへようこそ！<br>HairsPressでは、サロン様のホームページの環境をご提供しています。<br>スタッフページやヘアカタログなどの機能を使い、ホームページを運営していきましょう！<br>また、ブログやお知らせの投稿ができますので、お客様に向けて情報発信を行うことができます。<br>HairsPressのご利用でお困りになりましたら、右側にあるLINEサポートから株式会社MIRAIを友だち追加して、ご連絡ください。</p>',
      )
    );

    $screen->add_help_tab(
      array(
        'id'      => 'firststep',
        'title'   => 'はじめに',
        'content' => '<p>初期費用がセルスタートのお客様向けの説明になります。<br>最初に<a href="'.admin_url('admin.php?page=theme-salon-settings').'">サロン設定</a>からサロン情報の入力をします。<br>サロン設定が終わりましたら、<a href="'.admin_url('admin.php?page=hairspress-toppage-setting').'">トップページ設定</a>から、ビジュアルのスライダーやバナースペース、Instagramのバナー画像を設定します。<br>ここまで設定が済むと、トップページが完成します。</p>',
      )
    );

    $screen->set_help_sidebar(
      '<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
      '<p><a href="https://lin.ee/kn3wDOX" target="_blank">LINEサポート</a></p>' .
      '<p><a href="https://mi-rai.co.jp/" target="_blank">MIRAI Inc.</a></p>'
    );
  }
}