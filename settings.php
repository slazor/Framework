<?php // 2012-05-26
	if(!defined('INDEX')) die("No direct script access allowed.");

	/* GENERAL SETTINGS */
	$framework['pageName']	= 'Framework';			// Will be used as "$currentPage | $pageName" in title

	/* INCLUDED FILES */
	$framework['style']		= array('reset','style'); 		// Styles to be included
	$framework['script']		= array('jquery.js','script.js');		// Scripts to be included

	/* MYSQL SERVER SETTINGS */
	$framework['dbHost']	= '';										// MySQL Host
	$framework['dbUser']	= '';										// MySQL Username
	$framework['dbPass']	= '';										// MySQL Password
	$framework['dbData']	= '';										// MySQL Database

	/* CACHE SETTINGS */
	$cache		= FALSE;											// Turn on site-wide cache
	$cachetime	= 120;													// Time in seconds (3600 = 1h)

	/* SECURITY SETTINGS */
	$randomString1			= 'k)aZ$6BeqVKWX@a';	// Encryption string 1
	$randomString2			= 'W8O!7G5#2uLk=fq';		// Encryption string 2
	$stripTags				= array('script', 'style');		// Tags to remove before database inserts
	
	/* FILE DOWNLOAD SETTINGS */
	$download['folder']		= 'files/'; // Path to the folder where you store files
	$download['log']			= TRUE; // Log file downloads
	$download['message']	= 'File does not exist. Make sure you specified correct file name.'; // File not found message
	
	$download['allowed']	= array( // Allowed filetypes
		// archives
		'zip' => 'application/zip', 
		'rar' => 'application/rar', 
		// documents
		'txt' => ' text/plain', 
		'pdf' => 'application/pdf', 
		'doc' => 'application/msword', 
		'xls' => 'application/vnd.ms-excel', 
		'ppt' => 'application/vnd.ms-powerpoint',  
		// executables
		'exe' => 'application/octet-stream', 
		// images
		'gif' => 'image/gif', 
		'png' => 'image/png', 
		'jpg' => 'image/jpeg', 
		'jpeg' => 'image/jpeg', 
		// audio
		'mp3' => 'audio/mpeg', 
		'wav' => 'audio/x-wav', 
		 // video
		'mpeg' => 'video/mpeg', 
		'mpg' => 'video/mpeg', 
		'mpe' => 'video/mpeg', 
		'mov' => 'video/quicktime', 
		'avi' => 'video/x-msvideo'
	);
?>