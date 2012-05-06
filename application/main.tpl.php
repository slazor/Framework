<?php if(!defined('INDEX')) die("No direct script access allowed."); ?>
<!DOCTYPE html>
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
			<?php print $content; ?>
			</div>
			
			<div id="footer">Footer</div>
		</div>
		<?php print $scripts; ?>
	</body>
</html>