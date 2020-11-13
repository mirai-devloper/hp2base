<?php
namespace Hairspress\App;
/**
 * Theme Activation Tour
 *
 * This class handles the pointers used in the introduction tour.
 * @package Popup Demo
 * @see https://gist.github.com/DevinWalker/7595475
 *
 */
class Wordpress_Tour {

	private $pointer_close_id = 'wordpress_tour'; //value can be cleared to retake tour

	/**
	 * construct
	 *
	 * If user is on a pre pointer version bounce out.
	 */
	public function __construct() {
		global $wp_version;

		//pre 3.3 has no pointers
		if (version_compare($wp_version, '3.4', '<'))
			return false;

		//version is updated ::claps:: proceed
		add_action('admin_enqueue_scripts', array( $this, 'tour_enqueue'));
	}

	/**
	 * Enqueue styles and scripts needed for the pointers.
	 */

	public function tour_enqueue() {
		if (!current_user_can('manage_options'))
			return;

		// Assume pointer shouldn't be shown
		$enqueue_pointer_script_style = false;

		// Get array list of dismissed pointers for current user and convert it to array
		$dismissed_pointers = explode(',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true));

		// Check if our pointer is not among dismissed ones
		if (!in_array($this->pointer_close_id, $dismissed_pointers)) {
			$enqueue_pointer_script_style = true;

			// Add footer scripts using callback function
			add_action('admin_print_footer_scripts', array($this, 'intro_tour'));
			add_action('wp_footer', array($this, 'intro_tour'));
		}

		// Enqueue pointer CSS and JS files, if needed
		if ($enqueue_pointer_script_style) {
			wp_enqueue_style('wp-pointer');
			wp_enqueue_script('wp-pointer');
		}

	}


	/**
	 * ツアー内容の呼出
	 *
	 * $adminpages ツアー内容の配列
	 */
	public function intro_tour() {
		$adminpages = array(
			//  管理画面ページのスクリーンIDを指定。@see : http://codex.wordpress.org/Function_Reference/get_current_screen
			'dashboard' => array(
				array(
					'content' => "<h3>トップページの設定</h3>
												<p>スライダー設定、バナースペース設定をこちらにまとめました！</p>", // ポインター内のコンテンツ
					'id' => '#toplevel_page_hairspress-toppage-setting', // ポインターを表示する要素のセレクターを表示
					'position' => array(
						'edge' => 'left', // 矢印の位置
						'align' => 'center' // ポインターの位置
					) ,
					'button2' => '', // 次へボタンのテキスト
					'function' => '$(this).parents(".wp-pointer").fadeOut("fast");$("#menu-posts-freepage").pointer(wordimpress_pointer_options_0).pointer("open");' // 次へボタンをクリックした時に実行する JS
				),
				array(
					'content' => "<h3>サブページ</h3>
												<p>フリーページからサブページへ名称を変更しました！</p>", // ポインター内のコンテンツ
					'id' => '#menu-posts-freepage', // ポインターを表示する要素のセレクターを表示
					'position' => array(
						'edge' => 'left', // 矢印の位置
						'align' => 'center' // ポインターの位置
					) ,
					'button2' => '', // 次へボタンのテキスト
					'function' => '$(this).parents(".wp-pointer").fadeOut("fast");' // 次へボタンをクリックした時に実行する JS
				),
				array(
					'content' => "<h3>メニューコンテンツ</h3>
												<p>メニューコンテンツの投稿機能を追加しました。</p>", // ポインター内のコンテンツ
					'id' => '#menu-posts-menu-contents', // ポインターを表示する要素のセレクターを表示
					'position' => array(
						'edge' => 'left', // 矢印の位置
						'align' => 'center' // ポインターの位置
					) ,
					'button2' => '', // 次へボタンのテキスト
					'function' => '$(this).parents(".wp-pointer").fadeOut("fast");' // 次へボタンをクリックした時に実行する JS
				),
			),
		);


		$page = '';
		$screen = get_current_screen();

		//Check which page the user is on
		if (isset( $_GET[ 'page' ] ) ) {
			$page = $_GET[ 'page' ];
		}
		if (empty($page)) {
			$page = $screen->id;
		}

		$function = array();
		$button2 = array();
		$opt_arr = array();
		if ( !$adminpages[$page] ) return ;

		foreach ( $adminpages[$page] as $key => $option) {
			//Location the pointer points
			if (!empty($adminpages[$page][$key]['id'])) {
				$id[$key] = $adminpages[$page][$key]['id'];
			} else {
				$id[$key] = $screen->id;
			}
			//Options array for pointer used to send to JS
			if ('' != $page && in_array($page, array_keys($adminpages[$page]))) {

				$align = ( is_rtl() ) ? 'right' : 'left';
				$opt_arr[$key] = array(
					'content' => $adminpages[$page][$key]['content'],
					'position' => array(
						'edge' => (!empty($adminpages[$page][$key]['position']['edge'])) ? $adminpages[$page][$key]['position']['edge'] : 'left',
						'align' => (!empty($adminpages[$page][$key]['position']['align'])) ? $adminpages[$page][$key]['position']['align'] : $align
					),
					'pointerWidth' => 500
				);
				if (isset($adminpages[$page][$key]['button2'])) {
					$button2[$key] = (!empty($adminpages[$page][$key]['button2'])) ? $adminpages[$page][$key]['button2'] : '';
				}
				if (isset($adminpages[$page][$key]['function'])) {
					$function[$key] = $adminpages[$page][$key]['function'];
				}
			}
		}
		$this->print_scripts( $id , $opt_arr, __( "非表示" , 'textdomain'), $button2, $function);
	}


	/**
	 * Prints the pointer script
	 *
	 * @param string $selector The CSS selector the pointer is attached to.
	 * @param array $options The options for the pointer.
	 * @param string $button1 Text for button 1
	 * @param string|bool $button2 Text for button 2 (or false to not show it, defaults to false)
	 * @param string $button2_function The JavaScript function to attach to button 2
	 * @param string $button1_function The JavaScript function to attach to button 1
	 */
	public function print_scripts( $selectors, $options, $button1, $button2 = array(), $button2_function = '', $button1_function = '') {
		foreach ( $selectors as $key => $selector) { ?>
			<script type="text/javascript">
				//<![CDATA[
				(function ($) {

					var wordimpress_pointer_options_<?= $key ?> = <?= json_encode( $options[$key] ); ?>, setup_<?= $key ?>;
					// Userful info here
					wordimpress_pointer_options_<?= $key ?> = $.extend(wordimpress_pointer_options_<?= $key ?>, {
						buttons: function (event, t) {
							button = jQuery('<a id="pointer-close_<?= $key;?>" style="margin-left:5px" class="button-secondary">' + '<?= $button1; ?>' + '</a>');
							button.bind('click.pointer', function () {
									t.element.pointer('close');
							});
							return button;
						}
					});
					page_scroller = function( element ){
						var target = $(element).offset().top;
						$("html, body").animate({scrollTop:target}, 500);
						event.preventDefault();
						return false;
					}

					setup_<?= $key ?> = function () {
						$('<?= $selector; ?>').pointer(wordimpress_pointer_options_<?= $key ?>).pointer('open');
						<?php if ( $button2[$key] ) { ?>
							jQuery('#pointer-close_<?= $key;?>').after('<a id="pointer-primary_<?= $key;?>" class="button-primary">' + '<?= $button2[$key]; ?>' + '</a>');
						<?php } ?>
						jQuery('#pointer-primary_<?= $key;?>').click(function () {
							<?= $button2_function[$key]; ?>
						});
						jQuery('#pointer-close_<?= $key;?>').click(function () {
							<?php if ( $button1_function[$key] == '' ) { ?>
							$.post(ajaxurl, {
								pointer: '<?= $this->pointer_close_id; ?>',
								action: 'dismiss-wp-pointer'
							});
							<?php } else { ?>
								<?= $button1_function[$key]; ?>
							<?php } ?>
						});
					};
					if (wordimpress_pointer_options_<?= $key ?>.position && wordimpress_pointer_options_<?= $key ?>.position.defer_loading) {
						$(window).bind('load.wp-pointers', setup_<?= $key ?>);
					} else {
						$(document).ready(setup_<?= $key ?>);
					}

				})(jQuery);
				//]]>
			</script>
	<?php
		}
	}
}