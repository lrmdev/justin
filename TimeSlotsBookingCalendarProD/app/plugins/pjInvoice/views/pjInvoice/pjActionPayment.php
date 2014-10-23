<!doctype html>
<html>
	<head>
		<title><?php __('plugin_invoice_menu_invoices'); ?></title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<?php
		foreach ($controller->getCss() as $css)
		{
			echo '<link type="text/css" rel="stylesheet" href="'.$css['path'].$css['file'].'" />';
		}
		?>
	</head>
	<body>
		<div id="container">
		<?php
		switch ($_POST['payment_method'])
		{
			case 'paypal':
				if (pjObject::getPlugin('pjPaypal') !== NULL)
				{
					$controller->requestAction(array('controller' => 'pjPaypal', 'action' => 'pjActionForm', 'params' => $tpl['params']));
					__('plugin_invoice_paypal_redirect');
					?>
					<input type="button" value="<?php __('plugin_invoice_paypal_proceed'); ?>" id="pinBtnProceed" />
					<script type="text/javascript">
					(function () {
						function proceed() {
							var frm = document.getElementById("pinPaypal");
							if (frm) {
								frm.submit();
							}
						}

						window.setTimeout(function () {
							proceed.call(null);
						}, 3000);
						
						var btn = document.getElementById("pinBtnProceed");
						if (btn) {
							btn.onclick = function () {
								proceed.call(null);
							};
						}
					})();
					</script>
					<?php
				}
				break;
			case 'authorize':
				if (pjObject::getPlugin('pjAuthorize') !== NULL)
				{
					$controller->requestAction(array('controller' => 'pjAuthorize', 'action' => 'pjActionForm', 'params' => $tpl['params']));
					__('plugin_invoice_authorize_redirect');
					?>
					<input type="button" value="<?php __('plugin_invoice_authorize_proceed'); ?>" id="pinBtnProceed" />
					<script type="text/javascript">
					(function () {
						function proceed() {
							var frm = document.getElementById("pinAuthorize");
							if (frm) {
								frm.submit();
							}
						}

						window.setTimeout(function () {
							proceed.call(null);
						}, 3000);
						
						var btn = document.getElementById("pinBtnProceed");
						if (btn) {
							btn.onclick = function () {
								proceed.call(null);
							};
						}
					})();
					</script>
					<?php
				}
				break;
			case 'bank':
				echo stripslashes(nl2br($tpl['config_arr']['p_bank_account']));
				break;
			case 'creditcard':
			default:
		}
		?>
		</div>
		
	</body>
</html>