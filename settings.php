<?php // 2011-10-16
	if(!defined('INDEX')) die("No direct script access allowed.");

	/* GENERAL SETTINGS */
	$framework['pageName']	= 'Framework';			// Will be used as "$currentPage | $pageName" in title

	/* INCLUDED FILES */
	$framework['style']		= array('reset','style'); 		// Styles to be included
	$framework['script']	= array('jquery','script');		// Scripts to be included

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
	$stripTags					= array('script', 'style');		// Tags to remove before database inserts
?>