<?php if(!defined('INDEX')) die("No direct script access allowed."); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php print $title; ?> | <?php print $pageName; ?></title>
		<?php print $styles; ?>
	</head>
	
	<body>
		<div id="wrapper">
			<div id="header">
				<h1>Headline</h1>
				<div id="menu"><?php include("menu.tpl.php"); ?></div>
			</div>
			
			<div id="content">
			<?php
				if(file_exists('application/pages/'. $pages .'.page.tpl.php')) {
					include('pages/'. $pages .'.page.tpl.php');
				} else {
					include('pages/notfound.tpl.php');
				}
			?>
			</div>
			
			<div id="footer">Footer</div>
		</div>
		<?php print $scripts; ?>
	</body>
</html>