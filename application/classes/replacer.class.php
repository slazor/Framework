<?php // 2012-05-05
class Replacer {
	private $new_title;
	
	/*	Set up data here if you want
	*/
	function __construct() { 
		$this->replacer_title_change('New Title');
	}
	
	/*	Example private function
	*/
	private function replacer_title_change($title = '') {
		$this->new_title = $title;
	}
	
	/* 	Runs before template functions
		This is you chance to add things that the template functions might need.
	*/
	public function returner(&$vars) { 
		$vars['new_title'] = $this->new_title; // Creates a new variable with the new title for use in template functions.
	}
	
	/* 	Runs after template functions
		This is your chance to modify all data before output.
	*/
	public function modifier(&$vars) { 
		$vars['title'] = 'Modified title'; // Modifies the title after the template functions has run and before html is loaded.
	}
}