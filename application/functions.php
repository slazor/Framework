<?php // 2012-05-25
	
	// Function that runs on every page.
	function page_preprocess_all(&$vars, $fw = NULL) {
		// Loading of variables and such that is used on every pageload
		$vars['allPageArray'] = array('part1', 'part2');
		$vars['style']			= array('globalCSS');
		
		 /* 
			Catch all arguments after this and give to this preprocess. 
			Ex. www.framework.com/blog/my-post/ would normaly use "page_preprocess_blog_my-post" go to the template file "blog.my-post.page.tpl.php"
			with the use of this the argument "my-post" would be sent to the "page_preprocess_blog" that uses the template file "blog.page.tpl.php"
		 */
		$vars['catch_args'] = array('page_sub', 'blog');
		
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
		
		$inline_js_one = '
			$(document).ready(function() {
				//$("body").css("background-color","#eee");
			});
		';
		
		$inline_js_two = '
			$(document).ready(function() {
				//$("li a").css("background-color","#eee");
			});
		';
		
		$vars['title']				= 'The Page Page';
		//$vars['style']			= array('theCSS', 'theSecondCSS');
		//$vars['script']			= array('theJS.js', 'theSecondJS.js', 'inline' => array($inline_js_one,$inline_js_two));
		$vars['access_code']	= generate_access_code();
	}
	
	function page_preprocess_page_sub(&$vars, $fw = NULL) {
		$vars['baloo'] = $vars['catch_args'];
		$links = generate_download_url("file.txt","Download file");
		$vars['title'] = 'TinyMCE module test';
		//print generate_access_code();
	}
	
	function page_preprocess_blog(&$vars, $fw = NULL) {
		/*
			Contains the url arguments that were sent to this preprocess thanks to  "$vars['catch_args'] = array('page_sub', 'blog');" IN "page_preprocess_all"
		*/
		foreach($vars['catch_args'] AS &$arg) {
			$arg .= ' - snip';
		}
	}
?>