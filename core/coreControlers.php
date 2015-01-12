<?php
class CoreControlers {
	
	function get_extension($filename) {
		return strtolower(substr($filename, strrpos($filename, ".") + 1, strlen($filename)));
	}
	
	function load_css($styles_to_load) {
		$html_style = '';
		foreach ($styles_to_load as $style_to_load) {
			$html_style .= '
		<link href="css/'.$style_to_load.'.css" rel="stylesheet" type="text/css" media="screen" id="css" />';
		}
		return $html_style ;
	}
	
	function load_tools($tools_to_load, $array_tools) {
		//var_dump($array_tools);
		$html_tools = '';
		foreach ($tools_to_load as $tool_to_load) {
			$html_tools .= '
		'.$array_tools[$tool_to_load];
		}
		return $html_tools;
	}

}
?>