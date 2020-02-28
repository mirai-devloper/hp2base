<?php
namespace Hairspress\Core;

class Demo
{
	public function __construct() {
		// dummy
	}
	public static function init()
	{
		if (
			getenv('ENV_MODE') == 'develop'
			OR strpos($_SERVER['SERVER_NAME'], 'demo.hairspress.com') !== false
			OR strpos($_SERVER['SERVER_NAME'], 'localhost') !== false
		)
		{
			echo View::forge('demo/demo');
			self::font();
			self::style();
			self::javascript();
		}
	}

	/**
	 * WEBフォントのCSSを出力
	 */
	public static function font()
	{
		$url = array(
			'//fonts.googleapis.com/css?family=Josefin+Slab',
			'//fonts.googleapis.com/css?family=Lora',
			'//fonts.googleapis.com/css?family=Amatic+SC%3A400%2C700',
			'//fonts.googleapis.com/css?family=Playball',
		);
		foreach ($url as $v)
		{
			printf(
				'<link rel="stylesheet" href="%1$s" type="text/css" media="all">',
				$v
			);
		}
	}

	public static function style()
	{
		//
	}

	public static function javascript()
	{
?>
<script type="text/javascript">
(function(i, k, a, m, u, s, o) {
	var d = i, ss = sessionStorage, tcf = d.getElementById(k), val = tcf.value, url = '<?= get_template_directory_uri(); ?>/assets/css/';
	if( ss.getItem(a) ) {
		var opt = tcf.options;
		for ( var i = 0, len = opt.length; i < len; i++ ) {
			if( ss.getItem(a) == opt[i].value ) {
				opt[i].selected = true;
			}
		}
		if( d.getElementById(m) ) {
			var hc_css = d.getElementById(m);
			var theme = ss.getItem(a);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', url+theme+'.css', false);
			xmlhttp.send(null);
			hc_css.href = url+theme+'.css';
		}
	} else {
		ss.setItem(a ,val);
	}

	var form = d.tcf;
	var btnChange = form.elements[s];
	btnChange.onclick = function() {
		ss.setItem(a, form.elements[o].value);
		if( d.getElementById(m) ) {
			var hc_css = d.getElementById(m);
			var theme = ss.getItem(a);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('GET', url+theme+'.css', false);
			xmlhttp.send(null);
			hc_css.href = url+theme+'.css';
		}
	};
})(document, 'themeChanger', 'hptheme', 'hairspress-child-css', 'hp2', 'tcf-btn', 'tcf-sel');
</script>
<?php
	}

	public static function body_class()
	{
		$local = $_SERVER['SERVER_NAME'];
		if (
			getenv('ENV_MODE') == 'develop'
			OR strpos($local, 'demo.hairspress.com') !== false
		)
		{
			return 'demo-mode';
		}
		{
			return '';
		}
	}
}
