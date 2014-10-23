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
		<?php echo $tpl['template']; ?>
		<?php
		if ($tpl['arr']['status'] == 'not_paid' && (int) $tpl['config_arr']['p_accept_payments'] === 1 && (
			(int) $tpl['config_arr']['p_accept_paypal'] === 1 || (int) $tpl['config_arr']['p_accept_authorize'] === 1 ||
			(int) $tpl['config_arr']['p_accept_creditcard'] === 1 || (int) $tpl['config_arr']['p_accept_bank'] === 1
		) && (float) $tpl['arr']['total'] > 0)
		{
			?>
			<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjInvoice&amp;action=pjActionPayment" method="post">
				<input type="hidden" name="payment_post" value="1" />
				<input type="hidden" name="uuid" value="<?php echo $tpl['arr']['uuid']; ?>" />
				<?php
				$checked = false;
				if ((int) $tpl['config_arr']['p_accept_paypal'] === 1)
				{
					?><p><label><input type="radio" name="payment_method" value="paypal"<?php if (!$checked) { $checked = true; echo ' checked="checked"'; } ?> /> <?php __('plugin_invoice_pay_with_paypal'); ?></label></p><?php
				}
				if ((int) $tpl['config_arr']['p_accept_authorize'] === 1)
				{
					?><p><label><input type="radio" name="payment_method" value="authorize"<?php if (!$checked) { $checked = true; echo ' checked="checked"'; } ?> /> <?php __('plugin_invoice_pay_with_authorize'); ?></label></p><?php
				}
				if ((int) $tpl['config_arr']['p_accept_creditcard'] === 1)
				{
					?><p><label><input type="radio" name="payment_method" value="creditcard"<?php if (!$checked) { $checked = true; echo ' checked="checked"'; } ?> /> <?php __('plugin_invoice_pay_with_creditcard'); ?></label></p><?php
				}
				if ((int) $tpl['config_arr']['p_accept_bank'] === 1)
				{
					?><p><label><input type="radio" name="payment_method" value="bank"<?php if (!$checked) { $checked = true; echo ' checked="checked"'; } ?> /> <?php __('plugin_invoice_pay_with_bank'); ?></label></p><?php
				}
				?>
				<input type="submit" value="<?php __('plugin_invoice_pay_now'); ?>" />
			</form>
			<?php
		}
		?>
		</div>
	</body>
</html>