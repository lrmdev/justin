<!doctype html>
<html>
	<head>
		<title><?php __('front_cancel_title'); ?></title>
		<meta charset="utf-8">
		<meta name="X-UA-Compatible" content="IE=Edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.(isset($css['remote']) && $css['remote'] ? NULL : PJ_INSTALL_URL).$css['path'].$css['file'].'" />';
		}
		foreach ($controller->getJs() as $js)
		{
			echo '<script src="'.(isset($js['remote']) && $js['remote'] ? NULL : PJ_INSTALL_URL).$js['path'].$js['file'].'"></script>';
		}
		?>
	</head>
	<body>
	<?php require $content_tpl; ?>
	</body>
</html>