<?php

if ( ! function_exists('meta'))
{
	function meta($echo = true, $ogp = false)
	{
		if (is_archive() or is_post_type_archive()) return;

		global $post;

		$output = false;

		if (get_post_type() === 'page')
		{
			if (get_the_excerpt())
			{
				$output = get_the_excerpt();
			}
		}
		elseif (get_post_type() === 'post')
		{
			$excerpt = get_the_excerpt();
			if ($excerpt)
			{
				$output = $excerpt;
			}
			elseif (empty($excerpt) or $ogp === true)
			{
				$the_content = apply_filters('the_content', $post->post_content);
				$the_content = str_replace(']]>', ']]&gt;', $the_content);
				$the_content = str_replace('&nbsp;', '', $the_content);
				$the_content = wp_trim_words($the_content, 120, '...');

				$output = $the_content;
			}
		}

		if (isset($output) and ! empty($output) and $echo === true)
		{
			echo sprintf(
				'<meta name="description" content="%s" />'.PHP_EOL,
				esc_attr($output)
			);
			return false;
		}

		if ($echo === false and isset($output))
			return $output;
	}
}

function meta_echo()
{
	meta(true);
}
add_action('wp_head', 'meta_echo', 1);

function _rest_api_add($response, $post, $request)
{
	$response->data['post_meta'] = array(
		'description' => meta(false),
	);

	return $response;
}
add_filter('rest_prepare_post', '_rest_api_add', 10, 3);
add_filter('rest_prepare_news', '_rest_api_add', 10, 3);

function get_ogp_thumbnail($metadata)
{
	if (isset($metadata['sizes']['ogp']) and $metadata['sizes']['ogp']['width'] >= 1200)
	{
		$size = 'ogp';
	}
	elseif (isset($metadata['sizes']['square']) and $metadata['sizes']['square']['width'] >= 252)
	{
		$size = 'square';
	}
	else
	{
		$size = 'thumbnail';
	}

	$attachment_image = wp_get_attachment_image_src($metadata['id'], $size);
	$thumbnail        = esc_url($attachment_image[0]);

	return $thumbnail;
}

function get_ogp_thumbnail_metadata($id)
{
	$thumbnail_id = get_post_thumbnail_id($id);
	$metadata = wp_get_attachment_metadata($thumbnail_id);
	$metadata['id'] = $thumbnail_id;

	return $metadata;
}

function get_ogp_attachment_metadata($id)
{
	$attachment_args = array(
		'post_parent' => $id,
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
	);
	$attachments = get_children($attachment_args);

	if ($attachments)
	{
		$attachment_id = array_keys($attachments);
		$metadata = wp_get_attachment_metadata($attachment_id[0]);
		$metadata['id'] = $attachment_id[0];

		return $metadata;
	}

	return false;
}

function get_ogp_attachment_image($metadata)
{
	if (isset($metadata['sizes']['ogp']) and $metadata['sizes']['ogp']['width'] >= 1200)
	{
		$size = 'ogp';
	}
	elseif (isset($metadata['sizes']['square']) and $metadata['sizes']['square']['width'] >= 252)
	{
		$size = 'square';
	}
	else
	{
		$size = 'thumbnail';
	}

	$attachment_image = wp_get_attachment_image_src($metadata['id'], $size);
	$thumbnail = esc_url($attachment_image[0]);

	return $thumbnail;
}


function ogp($echo = true)
{
	if (
		 is_front_page()
		 or is_page()
		 or is_archive()
		 or is_post_type_archive()
	) return;

	global $post;

	if (empty($post)) return false;

	$ogp = array(
		'og:type'      => 'article',
		'og:title'     => get_the_title($post->ID).' - '.get_bloginfo('name'),
		'og:url'       => get_permalink($post->ID),
		'og:site_name' => get_bloginfo('name'),
	);

	// Description
	if (meta(false, true))
	{
		$ogp['og:description'] = meta(false, true);
	}

	if (has_post_thumbnail($post->ID))
	{
		$metadata = get_ogp_thumbnail_metadata(get_the_ID());
	}
	else
	{
		$attachment = get_ogp_attachment_metadata(get_the_ID());
	}

	// Image
	if (isset($metadata))
	{
		$ogp['og:image'] = get_ogp_thumbnail($metadata);
	}
	else
	{
		if (isset($attachment) and $attachment)
		{
			$ogp['og:image'] = get_ogp_attachment_image($attachment);
		}
	}


	$ogp['fb:app_id'] = '1109523609194214';

	// Twitter
	$ogp['twitter:card'] = 'summary';
	$ogp['twitter:title'] = get_the_title($post->ID).' - '.get_bloginfo('name');
	if (meta(false, true))
	{
		$ogp['twitter:description'] = meta(false, true);
	}

	if (isset($metadata))
	{
		if (isset($metadata['sizes']['ogp']) and $metadata['sizes']['ogp']['width'] >= 1200)
		{
			$ogp['twitter:card'] = 'summary_large_image';
		}

		$ogp['twitter:image'] = get_ogp_thumbnail($metadata);
	}
	else
	{
		if (isset($attachment) and $attachment)
		{
			if (isset($attachment['sizes']['ogp']) and $attachment['sizes']['ogp']['width'] >= 1200)
			{
				$ogp['twitter:card'] = 'summary_large_image';
			}

			$ogp['twitter:image'] = get_ogp_attachment_image($attachment);
		}
	}

	// Tag Output
	$output = array();
	foreach ($ogp as $key => $val)
	{
		$output[] = sprintf(
			'<meta property="%1$s" content="%2$s" />',
			$key,
			esc_attr($val)
		);
	}

	if (empty($output)) return;

	echo implode(PHP_EOL, $output).PHP_EOL;
}
add_action('wp_head', 'ogp', 1);


function rest_ogp($response, $post, $request)
{
	global $post;

	$ogp['og'] = array(
		'title'       => get_the_title($post->ID).' - '.get_bloginfo('name'),
		'url'         => get_permalink($post->ID),
		'site_name'   => get_bloginfo('name'),
		'type'        => 'article',
		'description' => meta(false, true),
	);
	$ogp['twitter'] = array(
		'title'       => get_the_title($post->ID).' - '.get_bloginfo('name'),
		'description' => meta(false, true),
	);

	// Image
	if (has_post_thumbnail($post->ID))
	{
		$metadata = get_ogp_thumbnail_metadata(get_the_ID());
	}
	else
	{
		$attachment = get_ogp_attachment_metadata(get_the_ID());
	}

	if (isset($metadata))
	{
		$thumb = get_ogp_thumbnail($metadata);
		$ogp['og']['image'] = $thumb;
		$ogp['twitter']['image'] = $thumb;
	}
	else
	{
		if (isset($attachment))
		{
			$thumb = get_ogp_attachment_image($attachment);
			$ogp['og']['image'] = $thumb;
			$ogp['twitter']['image'] = $thumb;
		}
	}

	$ogp['fb']['app_id'] = '1109523609194214';


	$response->data['ogp'] = $ogp;

	return $response;
}
add_filter('rest_prepare_post', 'rest_ogp', 10, 3);
add_filter('rest_prepare_news', 'rest_ogp', 10, 3);
