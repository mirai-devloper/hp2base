<?php


if ( ! function_exists('html_tag'))
{
	function html_tag($tag, $attr = array(), $content = false)
	{
		static $void_elements = array(
			// html4
			"area","base","br","col","hr","img","input","link","meta","param",
			// html5
			"command","embed","keygen","source","track","wbr",
			// html5.1
			"menuitem",
		);

		$html = '<'.$tag;
		$html .= ( ! empty($attr)) ? ' '.(is_array($attr) ? array_to_attr($attr) : $attr) : '';

		// a void element?
		if (in_array(strtolower($tag), $void_elements))
		{
			$html .= ' />';
		}
		else
		{
			$html .= '>'.$content.'</'.$tag.'>';
		}

		return $html;
	}
}


if ( ! function_exists('array_to_attr'))
{
	function array_to_attr($attr)
	{
		$attr_str = '';

		foreach ((array) $attr as $property => $value)
		{
			if ($value === null or $value === false)
			{
				continue;
			}

			if (is_numeric($property))
			{
				$property = $value;
			}

			$attr_str .= $property.'="'.str_replace('"', '&quot;', $value).'" ';
		}

		return trim($attr_str);
	}
}

if ( ! function_exists('implode_assoc'))
{
	function implode_assoc($inner, $outer, $array)
	{
		$output = array();
		foreach ($array as $key => $item)
		{
			$output[] = $key.$inner.'"'.str_replace('"', '&quot;', $item).'"';
		}

		return implode($outer, $output);
	}
}


if ( ! function_exists('in_arrayi'))
{
	function in_arrayi($needle, $haystack)
	{
		return in_array(strtolower($needle), array_map('strtolower', $haystack));
	}
}

if ( ! function_exists('get_object_public_vars'))
{
	function get_object_public_vars($obj)
	{
		return get_object_vars($obj);
	}
}
