<?php // 2012-02-26
	if(!defined('INDEX')) die("No direct script access allowed.");
	
	// Function that runs on every page.
	function page_preprocess_all(&$data, $fw = NULL) {
		// Loading of variables and such that is used on every pageload
		$data['allPageArray'] = array('part1', 'part2');
	}

	// Function that runs on single page
	function page_preprocess_start(&$data, $fw = NULL) {
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
		
		$data['title']	= 'The Startpage Page';
	}

	function page_preprocess_page(&$data, $fw = NULL) {
		//$data['cache']		= FALSE;
		$data['title']			= 'The Page Page';
		$data['style']		= array('theCSS', 'theSecondCSS');
		$data['script']		= array('theJS','theSecondJS');
		$data['customVar']	= 'Hello world';
	}
?>