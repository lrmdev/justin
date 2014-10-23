<!doctype html>
<html>
	<head>
		<title>Time Slots Booking Calendar</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.(isset($css['remote']) && $css['remote'] ? NULL : PJ_INSTALL_URL).$css['path'].htmlspecialchars($css['file']).'" />';
		}
		foreach ($controller->getJs() as $js)
		{
			echo '<script src="'.(isset($js['remote']) && $js['remote'] ? NULL : PJ_INSTALL_URL).$js['path'].htmlspecialchars($js['file']).'"></script>';
		}
		?>
		<!--[if gte IE 9]>
  		<style type="text/css">.gradient {filter: none}</style>
		<![endif]-->
	</head>
	<body>
		<div id="container">
    		<div id="header">
				<a href="http://www.phpjabbers.com/time-slots-booking-calendar/" id="logo" target="_blank"><img src="<?php echo PJ_INSTALL_URL . PJ_IMG_PATH; ?>backend/logo.png" alt="Time Slots Booking Calendar" /></a>
			</div>
			
			<div id="middle">
				<div id="leftmenu">
					<?php require PJ_VIEWS_PATH . 'pjLayouts/elements/leftmenu.php'; ?>
				</div>
				<div id="right">
					<div class="content-top"></div>
					<div class="content-middle" id="content">
					<?php require $content_tpl; ?>
					</div>
					<div class="content-bottom"></div>
				</div> <!-- content -->
				<div class="clear_both"></div>
			</div> <!-- middle -->
		
		</div> <!-- container -->
		<div id="footer-wrap">
			<div id="footer">
			   	<p><a href="http://www.phpjabbers.com/" target="_blank">PHP Scripts</a> Copyright &copy; <?php echo date("Y"); ?> <a href="http://www.stivasoft.com" target="_blank">StivaSoft Ltd</a></p>
	        </div>
        </div>
	</body>
</html>