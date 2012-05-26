<?php // 2012-05-26
class Tiny_mce {
	private $new_title;
	private $db;
	/*	Set up data here if you want
	*/
	function __construct($fw) { 
		// Catch $fw object to access database
		//$this->db = $fw;
		//$return = $this->db->query('SELECT * FROM table');
		
		$this->tiny_mce_title_change('New Title');
	}
	
	/*	Example private function
	*/
	private function tiny_mce_title_change($title = '') {
		$this->new_title = $title;
	}
	
	/* 	Runs before template functions
		This is you chance to add things that the template functions might need.
	*/
	public function returner(&$vars) { 
		// Adds TinyMCE scripts
		$vars['script'][] = get_path('tiny_mce').'js/tiny_mce/tiny_mce.js';
		$vars['script'][] = get_path('tiny_mce').'js/tinymce_init.js';
	}
	
	/* 	Runs after template functions
		This is your chance to modify all data before output.
	*/
	public function modifier(&$vars) { 
		//$vars['title'] = 'TinyMCE'; // Modifies the title after the template functions has run and before html is loaded.
	}
}