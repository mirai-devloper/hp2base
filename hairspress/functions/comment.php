<?php

add_filter('comment_form_fields', function($fields) {
	$comment_field = $fields['comment'];
	$author_field = $fields['author'];
	$email_field = $fields['email'];
	$url_field = $fields['url'];
	$cookies_field = $fields['cookies'];
	unset($fields['comment']);
	unset($fields['author']);
	unset($fields['email']);
	unset($fields['url']);
	unset($fields['cookies']);

	// $commenter = wp_get_current_commenter();

	// $format = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
	// $html5 = 'html5' === $format;

	$fields['author'] = $author_field;
	$fields['email'] = $email_field;
	// $fields['url'] = sprintf(
	// 	'<p class="comment-form-url">%s %s</p>',
	// 	sprintf(
	// 		'<label for="url">%s</label>',
	// 		'URL'
	// 	),
	// 	sprintf(
	// 		'<input %s id="url" name="url" value="%s" size="30" maxlength="200" />',
	// 		($html5 ? 'type="url"' : 'type="text"'),
	// 		esc_attr($commenter['comment_author_url'])
	// 	)
	// );
	$fields['comment'] = $comment_field;
	$fields['cookies'] = $cookies_field;

	return $fields;
});