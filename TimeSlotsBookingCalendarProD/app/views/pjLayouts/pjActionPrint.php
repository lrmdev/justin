<!doctype html>
<html>
	<head>
		<title>Time Slots Booking Calendar by PHPJabbers.com</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.(isset($css['remote']) && $css['remote'] ? NULL : PJ_INSTALL_URL).$css['path'].htmlspecialchars($css['file']).'" />';
		}
		?>
		<!--[if gte IE 9]>
  		<style type="text/css">.gradient {filter: none}</style>
		<![endif]-->
		<style type="text/css">
		html, body{
			background-image: none;
			background-color: #fff;
		}
		</style>
	</head>
	<body>
		<div id="print_wrap">
		<?php require $content_tpl; ?>
        </div>
        <script type="text/javascript">
        window.onload = function () {
			window.print();
        };
        </script>
	</body>
</html>