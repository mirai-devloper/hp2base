<?php
namespace Hairspress\App;

use Hairspress\Core\View;

class Widget_Recentposts extends \WP_Widget_Recent_Posts
{
	private $post_type = 'post';

	public function add_recent_posts_posttype($args)
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
				$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new \WP_Query( apply_filters( 'widget_posts_args', array(
				'posts_per_page'      => $number,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'post_type'           => $this->post_type,
		), $instance ) );

		if ( ! $r->have_posts() ) {
				return;
		}

		echo $args['before_widget'];
		if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
		}

		$params = array(
			'posts' => $r,
			'show_date' => $show_date
		);

		echo View::forge('widget/recentposts', $params);

		echo $args['after_widget'];

		// add_filter('widget_posts_args', array($this, 'add_recent_posts_posttype'), 10);

		// parent::widget($args, $instance);
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

		echo View::forge('widget/admin/recentposts', $params);
	}
}
