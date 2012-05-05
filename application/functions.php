<?php // 2012-05-05
	
	// Function that runs on every page.
	function page_preprocess_all(&$vars, $fw = NULL) {
		// Loading of variables and such that is used on every pageload
		$vars['allPageArray'] = array('part1', 'part2');
	}

	// Function that runs on single page
	function page_preprocess_start(&$vars, $fw = NULL) {
		/* 
		Loading of variables and such that is used only on the page "start.page.php"
		
		$data['title']	: Title of the current page (string)
		$data['style']	: Load page specific css files (array)
		$data['script']	: Load page specific js files (array)
		*/
		
		/*
		Use the Framework functions for safe database actions
		
		- Examples -
		INSERT: $insert = $fw->insert('table', array('column' => 'value', 'column' => 'value'));
		
		UPDATE: $fw->update('table', array('insertcolumn' => 'insertvalue', 'insertcolumn' => 'insertvalue'), array('argumentcolumn' => 'argumentvalue'), 10);
		
		SELECT: $return = $fw->query('SELECT * FROM table WHERE column = ?', array(value));
		*/
		
		$vars['title']	= 'The Startpage Page';
	}

	function page_preprocess_page(&$vars, $fw = NULL) {
		//$data['cache']		= FALSE;
		$vars['title']			= 'The Page Page';
		$vars['style']			= array('theCSS', 'theSecondCSS');
		$vars['script']			= array('theJS','theSecondJS');
		$vars['customVar']	= 'Hello world';
	}
?>