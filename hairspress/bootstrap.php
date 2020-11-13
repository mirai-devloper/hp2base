<?php
/**
 * Part of the Mirai framework.
 *
 * @package    Mirai
 * @version    0.1
 * @author     MIRAI Development
 * @license    MIT License
 * @copyright  2017 MIRAI Development
 */

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('CRLF') or define('CRLF', chr(13).chr(10));

// load the base functions
require __DIR__.DS.'base.php';


setup_autoloader();

function setup_autoloader()
{
	$loader = new Autoloader();
	$loader->register();

	$loader->addNamespace('Hairspress\\App', HP_APPPATH);
	$loader->addNamespace('Hairspress\\Core', HP_COREPATH);

	$loader->set_alias(array(
		'Hairspress\\Core\\Asset'      => 'Asset',
		'Hairspress\\Core\\View'       => 'View',
		'Hairspress\\Core\\Demo'       => 'Demo',
	));
}

require __DIR__.DS.'functions/custom-posts.php';
require __DIR__.DS.'functions/global.php';
require __DIR__.DS.'functions/common.php';
require __DIR__.DS.'functions/slider.php';
require __DIR__.DS.'functions/pagination.php';
require __DIR__.DS.'functions/pager.php';
require __DIR__.DS.'functions/nav_menu.php';
require __DIR__.DS.'functions/category.php';
require __DIR__.DS.'functions/widget.php';
require __DIR__.DS.'functions/comment.php';
require __DIR__.DS.'functions/breadcrumb.php';
require __DIR__.DS.'functions/front.php';
require __DIR__.DS.'functions/google.php';
require __DIR__.DS.'functions/staff.php';
require __DIR__.DS.'functions/catalog.php';
require __DIR__.DS.'functions/menucontents.php';


$hairspress_initialize = new Hairspress\App\Wordpress_Initialize();
$hairspress_login = Hairspress\App\Wordpress_Login::init();
$hairspress_title = new Hairspress\App\Wordpress_Title();

$hairspress_acf_admin = new Hairspress\App\Acf_Admin();

$hairspress_admin = new Hairspress\App\Wordpress_Admin();
$hairspress_admin->init();

$hairspress_user = new Hairspress\App\Wordpress_User();
$hairspress_user->init();

$hairspress_admin_dashboard = new Hairspress\App\Wordpress_Dashboard();

$hairspress_tour = new Hairspress\App\Wordpress_Tour();

$hairspress_tinymce = new Hairspress\App\Wordpress_Tinymce();
$hairspress_tinymce->init();

add_action('widgets_init', function() {
	$hairspress_widget = new Hairspress\App\Wordpress_Widget();
	$hairspress_widget->init();
});

$hairspress_design = new Hairspress\App\Options_Design();
$hairspress_topics = new Hairspress\App\Options_Topics();

$hairspress_theme = new Hairspress\App\Wordpress_Theme();

$hairspress_query = new Hairspress\App\Wordpress_Query();

$hairspress_post_password = new Hairspress\App\Wordpress_Post_Password();

// お知らせ
new Hairspress\App\Posttype_Topics();


// 投稿タイプ制限
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

if ($hp_setting['post_type']['catalog']) {
	// $post_type__catalog = new Hairspress\App\Posttype_Hair();
	add_action('init', 'add_catalog_post_type');
}

if ($hp_setting['post_type']['menu-contents']) {
	new Hairspress\App\Posttype_Menucontents();
}

if ($hp_setting['post_type']['channel']) {
	add_action('init', 'add_channel_post_type');
}