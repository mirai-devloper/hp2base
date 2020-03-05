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

// カテゴリーウィジェットの再登録
unregister_widget('WP_Widget_Categories');
register_widget('Hairspress\\App\\Widget_Categories');

// 最新の投稿ウィジェットの再登録
unregister_widget('WP_Widget_Recent_Posts');
register_widget('Hairspress\\App\\Widget_Recentposts');

// アーカイブウィジェットの再登録
unregister_widget('WP_Widget_Archives');
register_widget('Hairspress\\App\\Widget_Archives');

unregister_widget('WP_Widget_Recent_Comments');
unregister_widget('WP_Widget_Meta');
unregister_widget('WP_Widget_RSS');