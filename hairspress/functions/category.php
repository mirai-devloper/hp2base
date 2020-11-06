<?php
// カテゴリー出力
function hp_the_cat( $args = array() ) {
	global $post;
	$defaults = array(
		'separate' => ', ',
		'container' => 'p',
		'container_class' => 'cat',
		'container_before' => '',
		'container_after' => '',
		'link_class' => '',
		'taxonomy' => 'category',
		'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$taxonomy_name = !empty($args->taxonomy) ? $args->taxonomy : 'category';
	$terms = get_the_terms( $post->ID, $taxonomy_name );
	$output = null;
	if( !empty($terms) ) {
		if( !empty($args->container) ) {
			$container_class = !empty($args->container_class) ? ' class="'.esc_attr($args->container_class).'"' : '';
			$output .= '<'.$args->container.$container_class.'>';
		}
		if( !empty($args->container_before) ) {
			$output .= $args->container_before;
		}
		foreach( (array) $terms as $term ) {
			$separate = !empty($args->separate) ? $args->separate : '';
			if( !empty($output) ) {
				$output .= $separate;
			}

			$link = get_term_link($term);
			$name = $term->name;

			$link_class = !empty($args->link_class) ? ' class="'.esc_attr($args->link_class).'"' : '';
			$output .= '<a href="'.esc_url($link).'"'.$link_class.'>'.esc_html($name).'</a>';
		}
		if( !empty($args->container) ) {
			$output .= '</'.$args->container.'>';
		}
	}
	if( $args->echo ) {
		echo $output;
	} else {
		return $output;
	}
}

function hp_cat_parent( $args = array() ) {
	global $post;

	$defaults = array(
		'container' => 'p',
		'container_class' => 'cat',
		'taxonomy' => 'category',
		'echo' => true,
		'anchor' => true
	);

	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$taxonomy_name = !empty($args->taxonomy) ? $args->taxonomy : 'category';
	$terms = get_the_terms($post->ID, $taxonomy_name);

	if( !empty($terms) ) {
		$term = (object) $terms[0];
		$link = get_term_link($term);
		$name = $term->name;

		$output = '';
		if( !empty($args->container) ) {
			$container_class = !empty($args->container_class) ? ' class="'.$args->container_class.'"' : '';
			$output = '<'.$args->container.$container_class.'>';
		}

		$anchor = array();
		if( is_bool($args->anchor) && $args->anchor ) {
			$anchor += array('<a href="'.esc_url($link).'">', '</a>');
		}

		if( !empty($anchor) ) {
			$output .= $anchor[0].esc_html($name).$anchor[1];
		} else {
			$output .= esc_html($name);
		}

		if( !empty($args->container) ) {
			$output .= '</'.$args->container.'>';
		}
		if( is_bool($args->echo) && $args->echo ) {
			echo $output;
			return;
		}
		return $output;
	}
}
