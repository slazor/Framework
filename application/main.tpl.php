<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php print $title; ?> | <?php print $pageName; ?></title>
	<?php print $styles; ?>
	<!--[if lt IE 9]>
	<link href="<?php print base_path(); ?>application/assets/css/ie.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php print base_path(); ?>application/assets/script/html5.js"></script>
	<![endif]-->
</head>
	
<body>
	<div id="wrapper">
		<header id="header-container">
			<h1 class="title"><a href="<?php print base_path(); ?>">Framework</a></h1>
			<nav id="menu">
				<ul>
					<li><a href="<?php print base_path(); ?>">Startpage</a></li>
					<li><a href="<?php print base_path(); ?>page">Page 1</a></li>
					<li><a href="<?php print base_path(); ?>page/sub">Page 1 Sub</a></li>
				</ul>
			</nav>
		</header>
		
		<div id="content-container">
			<?php print $content; ?>
		</div>
		
		<footer id="footer-container">
			<p>&copy; Mikael Wase 2012 - <a href="http://www.mikaelwase.com" target="_blank">www.mikaelwase.com</a></p>
		</footer>
	</div>
	<?php print $scripts; ?>
</body>
</html>