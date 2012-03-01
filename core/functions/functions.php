<?php 
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

// Validate Emails
function validateEmail($email = false) {
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
function generateAccessCode(){
	$n = rand(10e16, 10e20);
	return base_convert($n, 10, 36);
}
?>