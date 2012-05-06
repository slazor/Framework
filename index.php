<?php // 2012-05-05
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

		// Framework class include
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

		// Data storage
		$vars = array();
		$content  = '';
		//$catch_args = FALSE;
		$framework['script']['inline'] = array();

		// Get all classes to load
		$classes = $fw->load_classes('application/classes/');

		foreach($classes['file'] AS $k => $class) {
			if(!empty($class)) {
				// Include classes
				require_once('application/classes/'.$class);
				if(!class_exists($classes['name'][$k])) { 
					throw new ErrorException('Class Not Found !');
				} else { 
					// Create instances
					${$classes['name'][$k]} = new $classes['name'][$k]($fw);
					if(method_exists(${$classes['name'][$k]},'returner')) {
						// Run all returners
						${$classes['name'][$k]}->returner($vars);
					}
				}
			}
		}

		// Load page_preprocess_all function if it exists
		if(function_exists('page_preprocess_all')) page_preprocess_all($vars, $fw);

		// Pick up styles and script if set in template function
		if(isset($vars['style'])) $framework['style']	= array_merge($framework['style'],$vars['style']);
		if(isset($vars['script'])) $framework['script']	= array_merge($framework['script'],$vars['script']);
		
		if(isset($vars['catch_args'])) {
			foreach($vars['catch_args'] AS $arg) {
				$file = str_replace('_', '.', $arg);
				if($file != $pages) {
					if(strpos($pages, $file) !== FALSE) {
						if(file_exists('application/pages/'. $file .'.page.tpl.php')) {
							$pageFunction = 'page_preprocess_'.$arg;
							$vars['catch_args'] = explode('.', str_replace($file.'.','',$pages));
							$pages = $file;
						}
					}
				} else {
					$vars['catch_args'] = array();
				}
			}
		}
		
		// Load page function if it exists
		if(function_exists($pageFunction)) $pageFunction($vars, $fw);

		// Run all modifiers
		for($k=0;$k<sizeof($classes['name']);$k++) {
			if(method_exists(${$classes['name'][$k]},'modifier')) {
				${$classes['name'][$k]}->modifier($vars);
			}
		}

		// Pick up styles and script if set in template function
		if(isset($vars['style']))	$framework['style']	= array_merge($framework['style'],$vars['style']);
		if(isset($vars['script']['inline']))	$framework['script']['inline']	= array_merge($framework['script']['inline'],$vars['script']['inline']);
		if(isset($vars['script']['inline']))	unset($vars['script']['inline']);
		if(isset($vars['script']))	$framework['script']	= array_merge($framework['script'],$vars['script']);

		// Framework variables
		$pageName	= $framework['pageName'];
		$title			= $page;

		if(isset($vars['title'])) $title = $vars['title'];

		$styles	= $fw->getStyles($framework['style']);		// Returns styles
		$scripts	= $fw->getScripts($framework['script']);	// Returns scripts

		// Everything except template is now loaded. Unset unnecessary and sensitive variables
		unset($framework,$key,$vars['script'],$vars['style'],$vars['catch_args'],$pageFunction,$GLOBALS,$dta,$randomString1,$randomString2);

		// Start loading templates
		ob_start();
		if(file_exists('application/pages/'. $pages .'.page.tpl.php')) {
			include('application/pages/'. $pages .'.page.tpl.php');
		} else {
			include('application/pages/notfound.tpl.php');
		}
		$content = ob_get_clean();
		
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