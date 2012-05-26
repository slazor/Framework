<?php
define("INDEX", true);
include_once('settings.php');
unset($framework);

define('ALLOWED_REFERRER', '');
define('BASE_DIR',$download['folder']);
define('LOG_DOWNLOADS',$download['log']	);
define('LOG_FILE','downloads.log');

$allowed_ext = $download['allowed'];

// Check if empty
if(!isset($_GET['f']) || empty($_GET['f'])) die($download['message']);
if (strpos($_GET['f'], "\0") !== FALSE) die('');

// Get real file name.
$fname = basename($_GET['f']);

// Check if the file exists
// Check in subfolders too
function find_file($dirname, $fname, &$file_path) {
	$dir = opendir($dirname);
	while($file = readdir($dir)) {
		if(empty($file_path) && $file != '.' && $file != '..') {
			if(is_dir($dirname.'/'.$file)) {
				find_file($dirname.'/'.$file, $fname, $file_path);
			} else {
				if(file_exists($dirname.'/'.$fname)) {
					$file_path = $dirname.'/'.$fname;
					return;
				}
			}
		}
	}
}

$file_path = '';
find_file(BASE_DIR, $fname, $file_path);

if(!is_file($file_path)) die($download['message']); 

// File size
$fsize = filesize($file_path); 

// File extension
$fext = strtolower(substr(strrchr($fname,"."),1));

// Check if allowed extension
if(!array_key_exists($fext, $allowed_ext)) die($download['message']); 

// Get mime type
if($allowed_ext[$fext] == '') {
	$mtype = '';
	if(function_exists('mime_content_type')) {
		$mtype = mime_content_type($file_path);
	} else if (function_exists('finfo_file')) {
		$finfo = finfo_open(FILEINFO_MIME);
		$mtype = finfo_file($finfo, $file_path);
		finfo_close($finfo);  
	}

	if ($mtype == '') {
		$mtype = "application/force-download";
	}
} else {
	$mtype = $allowed_ext[$fext];
}

/*
if (!isset($_GET['fc']) || empty($_GET['fc'])) {
  $asfname = $fname;
}
else {
  // remove some bad chars
  $asfname = str_replace(array('"',"'",'\\','/'), '', $_GET['fc']);
  if ($asfname === '') $asfname = 'NoName';
}
*/

// Set the headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: " . $mtype);
header("Content-Disposition: attachment; filename=\"$fname\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $fsize);

// Download
$file = @fopen($file_path,"rb");
if($file) {
	while(!feof($file)) {
		print(fread($file, 1024*8));
		flush();
		if(connection_status()!=0) {
			@fclose($file);
			die();
		}
	}
	@fclose($file);
}

// Log downloads
if (LOG_DOWNLOADS) {
	$f = @fopen(LOG_FILE, 'a+');
	if ($f) {
		@fputs($f, date('m.d.Y g:ia') . '  ' . $_SERVER['REMOTE_ADDR'] . '  ' . $fname . "\n");
		@fclose($f);
	}
}
?>
