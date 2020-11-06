<?php

// シングルページのページャー
function hp_single_pager( $args = array() ) {
	$defaults = array(
		'next' => '前の記事へ',
		'prev' => '次の記事へ',
		'container' => 'div',
		'container_class' => 'single-pager',
		'next_before' => '<i class="fa fa-angle-left"></i>',
		'next_after' => '',
		'prev_before' => '',
		'prev_after' => '<i class="fa fa-angle-right"></i>',
		'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$next_text = $args->next_before.$args->next.$args->next_after;
	$prev_text = $args->prev_before.$args->prev.$args->prev_after;
	$next = get_next_post_link('%link', $next_text);
	$prev = get_previous_post_link('%link', $prev_text);

	$output = '';
	if( !empty($args->container) ) {
		$container_class = !empty($args->container_class) ? ' class="'.$args->container_class.'"' : '';
		$output = '<'.$args->container.$container_class.'>';
	}

	$output .= '<div class="next">'.$next.'</div>';
	$output .= '<div class="prev">'.$prev.'</div>';

	if( !empty($args->container) ) {
		$output .= '</'.$args->container.'>';
	}

	if( is_bool($args->echo) && $args->echo ) {
		echo $output;
		return;
	}
	return $output;
}
