<?php // 2012-05-26
// Get base path
function base_path() {
	return str_replace('index.php','',$_SERVER['SCRIPT_NAME']);
}

// Get url argument
function arg($arg = 0) {
	$args = explode('/',$_GET['args']);
	return (isset($args[$arg])) ? $args[$arg] : '';
}

// Quick print_r
function printr($array) {
	print '<pre>';
	print_r($array);
	print '</pre>';
}

// Time ago
function time_ago($ptime) {
	$etime = time() - $ptime;
	if($etime < 1) return 'less than 1 second ago';
	$a = array (
		12 * 30 * 24 * 60 * 60 =>  'year',
		30 * 24 * 60 * 60 =>  'month',
		24 * 60 * 60 =>  'day',
		60 * 60 =>  'hour',
		60	=>  'minute',
		1 =>  'second'
	);
	foreach($a as $secs => $str) {
		$d = $etime / $secs;

		if( $d >= 1 ) {
			$r = round( $d );
			return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
		}
	}
}

// Validate Emails
function validate_email($email = false) {
	if(!$email) return false;
	$regex = '/^([.0-9a-z_-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,4})$/i';
	if(preg_match($regex, trim($email), $matches)) {
		return true;
	} else { 
		return false;
	} 
}

// Redirect to url
function redirect($url = false, $code = 301) {
	if(!$url) return false;
	header('Location: '.$url, true, $code);
}

// Generate random string
function generate_access_code() {
	$n = rand(10e16, 10e20);
	return base_convert($n, 10, 36);
}

// Create a safe link/url to a file on the server
function generate_download_url($filename, $title = false) {
	$url	= 'http://'.$_SERVER['SERVER_NAME'].base_path().'download.php?f='.$filename;
	$link	= '<a href="http://'.$_SERVER['SERVER_NAME'].base_path().'download.php?f='.$filename.'" target="_blank">';
	$link .= ($title) ? $title : $filename;
	$link .= '</a>';
	return array('path' =>$url, 'link' => $link);
}

// Creates a path to the a module directory
function get_path($module = null) {
	if(!empty($module)) {
		return base_path().'application/modules/'.$module.'/';
	}
}

?>
