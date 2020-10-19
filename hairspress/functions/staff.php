<?php

function get_staff_manage($post_id = 0) {
	$manage = get_field('manage', $post_id);

	$result = NULL;
	foreach ($manage as $r) {
		if (!empty($result)) $result .= '・';
		$result .= $r->name;
	}

	return $result;
}
