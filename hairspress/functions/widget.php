<?php




// カスタム投稿用のアーカイブリンク処理
// サイドバー向け
global $my_archives_post_type;

function my_getarchives_where( $where, $r ) {
	global $my_archives_post_type;
	if( isset( $r['post_type']) ) {
		$my_archives_post_type = $r['post_type'];
		$where = str_replace('\'post\'', '\'' . $r['post_type'] . '\'', $where);
	} else {
		$my_archives_post_type = '';
	}
	return $where;
}
// add_filter('getarchives_where', 'my_getarchives_where', 10, 2);

function my_get_archives_link( $link_html ) {
	global $my_archives_post_type;
	if( $my_archives_post_type !== '' && $my_archives_post_type !== 'post' ) {
		$patterns = array ('/(blog)/', '/(\/details\/)/');
		$replace = array ($my_archives_post_type, '/');
		$link_html = preg_replace($patterns, $replace, $link_html);
	}
	// if( $my_archives_post_type != '' ) {
	//   $add_link = '?post_type='.$my_archives_post_type;
	//   $link_html = preg_replace("/href='(.+)'/", "href='$1".$add_link."'", $link_html);
	// }
	return $link_html;
}
// add_filter('get_archives_link', 'my_get_archives_link');

function mio_get_archives_list( $post_type = '', $show_count = 1) {
	$args = array(
		'type' => 'monthly',
		'post_type' => $post_type,
		'show_post_count' => $show_count,
		'format' => 'custom',
		'after' => '|',
		'echo' => 0
	);
	$html = wp_get_archives($args);
	$arr = explode("|", $html);
	array_pop($arr);

	$array_archives = array();

	foreach( $arr as $key => $val ) {
		$year = substr( trim( strip_tags( $val ) ), 0, 4);
		$abc = array();
		for( $i = 0; $i < count($arr); $i++ ) {
			if( strstr($arr[$i], $year.'年') ) {
				$abc[] = $arr[$i];
			}
		}
		$array_archives += array(
			$year => $abc
		);
	}
	$result = '';
	foreach( $array_archives as $keys => $vals ) {
		$result .= '<li>';
		$result .= '<button class="tgl"><span>'.$keys.'年<i class="fa fa-angle-down"></i></span></button>';
		$result .= '<ul class="tgl_child">';
		for( $linked = 0; $linked < count($vals); $linked++ ) {
			$result .= '<li>'.$vals[$linked].'</li>';
		}
		$result .= '</ul>';
		$result .= '</li>';
	}
	return $result;
}
function mio_the_archives_list( $type ) {
	echo mio_get_archives_list( $type );
}