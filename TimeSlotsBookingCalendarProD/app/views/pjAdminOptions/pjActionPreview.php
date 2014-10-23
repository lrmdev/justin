<!doctype html>
<html>
	<head>
		<title>Time Slots Booking Calendar by PHPJabbers.com</title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="fragment" content="!">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
		.ui-widget{
			font-size: 0.9em !important;
		}
		.ui-widget-content{
			line-height: 1.4em;
		}
		</style>
		<link href="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFrontEnd&action=pjActionLoadCss&cid=<?php echo @$_GET['cid']; ?><?php echo isset($_GET['layout']) && (int) $_GET['layout'] > 0 ? '&layout=' . (int) $_GET['layout'] : NULL; ?>" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div style="margin: 0 auto; width: 400px">
			<script type="text/javascript" src="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFrontEnd&action=pjActionLoad&cid=<?php echo @$_GET['cid']; ?><?php echo isset($_GET['layout']) && (int) $_GET['layout'] > 0 ? '&layout=' . (int) $_GET['layout'] : NULL; ?>"></script>
		</div>
	</body>
</html>