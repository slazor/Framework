<?php // 2012-02-26
	session_start();
	define("INDEX", true);
	ob_start();

	include_once('settings.php');
	include_once('core/functions/functions.php');
	$page = end(explode('/',$_GET['args']));
	$args = trim(implode('.',explode('/',$_GET['args'])),'.');
	
	if(empty($args))	$args = 'start';
	$pages = $args;

	if($cache === TRUE) {
		$cachefile = base64_encode($pages.'.html');
	}

	if($cache === TRUE && file_exists('cache/'.$cachefile) && (time() - $cachetime < @filemtime('cache/'.$cachefile))) {
		// LOAD CACHE FILE
		include('cache/'.$cachefile);
	} else {
		
		// PageFunction to run
		if(!isset($pageFunction)) $pageFunction = 'page_preprocess_'.str_replace('.','_',$args);

		// Classes to include and create instances of ( AUTOMATIC CLASS INIT WILL BE AVAILABLE LATER )
		require_once('core/classes/framework.class.php');

		// Init SQL
		$mysqli	= new Mysqli($framework['dbHost'],$framework['dbUser'],$framework['dbPass'],$framework['dbData']);
		if($mysqli->connect_errno) {
			printf("Mysql Error: %s\n", $mysqli->connect_error);
			die();
		}

		// Init framework
		$fw = new Framework(array('mysqli' => $mysqli, 'hash' => array($randomString1,$randomString2)));

		// Load template functions
		require_once('application/functions.php');

		// Load page_all function if it exists
		$data = array();
		$vars = array();
		if(function_exists('page_preprocess_all')) page_preprocess_all($data, $fw);
		
		// Create variables from page_all template function
		if(isset($data) && is_array($data)) {
			foreach($data AS $key => &$dta) {
				if(!isset($page_all[$key]) && ($key != 'style' || $key != 'script')) $vars[$key] = $data[$key];
			}
		}

		// Pick up styles and script if set in template function
		if(isset($data['style'])) $style	= array_merge($style,$data['style']);
		if(isset($data['script'])) $script	= array_merge($script,$data['script']);

		// Load page function if it exists
		if(function_exists($pageFunction)) $pageFunction($data, $fw);

		// Create variables from current page template function
		if(isset($data) && is_array($data)) {
			foreach($data AS $key => &$dta) {
				if(!isset(${"$pageFunction"}[$key]) && ($key != 'style' || $key != 'script')) $vars[$key] = $dta;
				if($key == 'cache' && $dta === FALSE) { $cache = FALSE; ob_end_flush(); }
			}
		}

		// Pick up styles and script if set in template function
		if(isset($data['style']))		$framework['style']		= array_merge($framework['style'],$data['style']);
		if(isset($data['script']))	$framework['script']	= array_merge($framework['script'],$data['script']);

		// Framework variables
		$pageName	= $framework['pageName'];
		$title				= $page;
		
		if(isset($vars['title']))	$title	= $vars['title'];
		if(isset($vars['title'])) $title = $vars['title'];

		$styles		= $fw->getStyles($framework['style']);		// Returns styles
		$scripts		= $fw->getScripts($framework['script']);	// Returns scripts

		// Everything except template is now loaded. Unset unnecessary and sensitive variables
		unset($framework,$key,$data,$pageFunction,$GLOBALS,$dta,$randomString1,$randomString2);

		// Start loading templates
		require_once('application/main.tpl.php');
		$mysqli->close();

		if($cache === TRUE) {
			echo "<!-- Cache updated ".date('jS F Y H:i')." -->";
			$fp = fopen('cache/'.$cachefile, 'w');
			fwrite($fp, ob_get_contents());
			fclose($fp);
			ob_end_flush();
		}
	}
?>