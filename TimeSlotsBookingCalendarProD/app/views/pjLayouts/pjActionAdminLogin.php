<!doctype html>
<html>
	<head>
		<title>Time Slots Booking Calendar</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
		<div id="container">
			<div id="header">
				<a href="http://www.phpjabbers.com/time-slots-booking-calendar/" id="logo" target="_blank"><img src="<?php echo PJ_INSTALL_URL . PJ_IMG_PATH; ?>backend/logo.png" alt="Time Slots Booking Calendar" /></a>
			</div>
			<div id="middle">
				<div id="login-content">
				<?php require $content_tpl; ?>
				</div>
			</div> <!-- middle -->
		</div> <!-- container -->
		<div id="footer-wrap">
			<div id="footer">
			   	<p><a href="http://www.phpjabbers.com/" target="_blank">PHP Scripts</a> Copyright &copy; <?php date_default_timezone_set('UTC'); echo date("Y"); ?> <a href="http://www.stivasoft.com" target="_blank">StivaSoft Ltd</a></p>
	        </div>
        </div>
	</body>
</html>