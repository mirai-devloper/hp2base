<?php
namespace Hairspress\App;

use Hairspress\Core\View;

class Widget_Archives extends \WP_Widget_Archives
{
	private $post_type = 'post';

	public function __construct() {
		parent::__construct();
		add_filter('widget_archives_args', function($args) {
			$args['post_type'] = $this->post_type;
			return $args;
		});
	}

	public function add_archives_posttype($args)
	{
		$args['post_type'] = $this->post_type;
		return $args;
	}

	public function get_post_types()
	{
		$post_types = get_post_types(
			array(
				'public'  => true,
				'show_ui' => true,
				'hierarchical' => false,
			),
			'objects'
		);
		return $post_types;
	}

	public function widget($args, $instance)
	{
		if ( ! isset($args['widget_id']) ) {
			$args['widget_id'] = $this->id;
		}

		if ( ! empty($instance['post_type']))
		{
			$this->post_type = $instance['post_type'];
		}
		$default_title = __('Archives');
		$title = !empty($instance['title']) ? $instance['title'] : $default_title;
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		$count = !empty($instance['count']) ? '1' : '0';
		$dropdown = !empty($instance['dropdown']) ? '1' : '0';

		echo $args['before_widget'];
		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		// parent::widget($args, $instance);
		$a = array(
			'show_post_count' => $count,
		);
		$r = wp_parse_args($a, $instance);
		$this->get_archives(apply_filters('widget_archives_args', $r));
		echo $args['after_widget'];
	}

	public function get_archives($args) {
		extract($args, EXTR_SKIP);

		$defaults = array(
			'limit' => '',
			'before' => '',
			'after' => '',
			'show_post_count' => false,
			'echo' => 1,
			'order' => 'DESC',
		);

		$r = wp_parse_args($args, $defaults);
		extract($r, EXTR_SKIP);

		$arcresults = $this->get_monthly_archives_data($r);
		$output = $this->build_html($r, $arcresults);

		if ($echo) {
			echo $output;
		} else {
			return $output;
		}
	}

	public function get_monthly_archives_data($args) {
		global $wpdb;
		extract($args, EXTR_SKIP);

		if ('' != $limit) {
			$limit = absint($limit);
			$limit = ' LIMIT ' . $limit;
		}

		$order = strtoupper($order);
		if ($order !== 'ASC') {
			$order = 'DESC';
		}

		$where = apply_filters('getarchives_where', "WHERE post_type = '{$this->post_type}' AND post_status = 'publish'", $args);
		$join = apply_filters('getarchives_join', '', $args);

		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5($query);
		$cache = wp_cache_get('get_archives', 'general');
		if (!isset($cache[$key])) {
			$arcresults = $wpdb->get_results($query);
			$cache[$key] = $arcresults;
			wp_cache_set('get_archives', $cache, 'general');
		} else {
			$arcresults = $cache[$key];
		}

		return $arcresults;
	}

	public function build_html($args, $arcresults) {
		extract($args, EXTR_SKIP);

		if (!$arcresults) {
			return '';
		}

		$cur_year = -1;
		$afterafter = $after;

		$output = '<ul class="yearArchiveList">';
		foreach ((array) $arcresults as $arcresult) {
			if ($cur_year != $arcresult->year) {
				if ($cur_year > 0) {
					$output .= '</ul>';
					$output .= "</li>\n";
				}

				$output .= '<li><button class="tgl"><span>'.$arcresult->year.'年<i class="fa fa-angle-down"></i></span></button>';
				$output .= '<div class="tgl_child"><ul>';

				$cur_year = $arcresult->year;
			}

			if ($show_post_count) {
				$after = " <span class='num'>({$arcresult->posts})</span>{$afterafter}";
			}

			$output .= '<li class="singleList">'.$this->get_archives_list($arcresult->year, $arcresult->month, $before, $after)."</li>\n";
		}
		$output .= "</ul></div>";
		$output .= "</li>\n";
		$output .= '</ul>';

		return $output;
	}

	public function get_archives_list($year, $month, $before = '', $after = '') {
		global $wp_locale;

		$url = get_month_link($year, $month);
		$url = esc_url($url);

		$text = $wp_locale->get_month($month);
		$text = wptexturize($text);

		$title_text = sprintf(
			__('%1$s %2$d'),
			$wp_locale->get_month($month),
			$year
		);
		$title_text = esc_attr($title_text);

		$link_html = "$before<a href='$url' title='$title_text'>$text</a>$after";
		$link_html = apply_filters('get_archives_link', $link_html);

		return $link_html;
	}

	public function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['post_type'] = $new_instance['post_type'];

		return $instance;
	}

	public function form($instance)
	{
		parent::form($instance);

		$post_type = isset($instance['post_type']) ? $instance['post_type'] : $this->post_type;

		$post_types = $this->get_post_types();
		$field_id = $this->get_field_id('post_type');
		$field_name = $this->get_field_name('post_type');

		$fields = array(
			'id'   => $field_id,
			'name' => $field_name,
		);

		$params = array(
			'field'      => $fields,
			'post_types' => $post_types,
			'instance'   => $post_type
		);

		echo View::forge('widget/admin/archives', $params);
	}
}
