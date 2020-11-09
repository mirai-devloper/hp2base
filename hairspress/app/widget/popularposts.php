<?php
namespace Hairspress\App;

use Hairspress\Core\View;

class Widget_Popularposts extends \WP_Widget
{
	private $post_type = 'post';

	public function __construct() {
		parent::__construct(
			'popularposts',
			'人気の投稿',
			array(
				'description' => 'ブログの人気記事を出力するウィジェット。',
			)
		);
	}

	public function widget($args, $instance)
	{
		if ( ! isset($args['widget_id']) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Popular Posts' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$r = new \WP_Query(
			apply_filters(
				'widget_popularposts_args',
				array(
					'post_type'           => $this->post_type,
					'posts_per_page'      => 20,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'meta_query' => array(
						'view_count' => array(
							'key' => 'post_views_count',
							'value' => 1,
							'type' => 'numeric',
							'compare' => '>',
						),
					),
					// 'date_query' => array(
					// 	array(
					// 		'inclusive' => true,
					// 		'after' => date('Y/n/j', strtotime('-1 month')),
					// 	),
					// ),
					'orderby' => array(
						'view_count' => 'DESC',
					),
				)
			)
		);

		echo $args['before_widget'];
		if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
		}

		$params = array(
			'popular' => $r,
		);

		echo View::forge('widget/popularposts', $params);

		echo $args['after_widget'];
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title' => '',
			)
		);
		$instance['title'] = sanitize_text_field($new_instance['title']);

		return $instance;
	}

	public function form($instance) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title' => '',
			)
		);

		$params = array(
			'fields' => array(
				'id' => $this->get_field_id('title'),
				'name' => $this->get_field_name('title')
			),
			'instance' => $instance
		);
		echo View::forge('widget/admin/popularposts', $params);
	}
}
