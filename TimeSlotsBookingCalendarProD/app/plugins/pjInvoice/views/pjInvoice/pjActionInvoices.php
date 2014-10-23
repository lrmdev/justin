<?php
if (isset($tpl['status']))
{
	$status = __('status', true);
	switch ($tpl['status'])
	{
		case 2:
			pjUtil::printNotice(NULL, $status[2]);
			break;
	}
} else {
	$plugin_menu = PJ_VIEWS_PATH . sprintf('pjLayouts/elements/menu_%s.php', $controller->getConst('PLUGIN_NAME'));
	if (is_file($plugin_menu))
	{
		include $plugin_menu;
	}
	
	if (isset($_GET['err']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles[$_GET['err']], !isset($_GET['errTime']) ? @$bodies[$_GET['err']] : $_SESSION[$controller->invoiceErrors][$_GET['errTime']]);
	}
	$statuses = __('plugin_invoice_statuses', true);
	?>
	<div class="b10">
		<form action="" method="get" class="pj-form frm-filter float_left">
			<input type="text" name="q" class="pj-form-field pj-form-field-search w250" placeholder="<?php __('btnSearch'); ?>" value="<?php echo htmlspecialchars(stripslashes(@$_GET['q'])); ?>" />
		</form>
		
		<?php
		if (isset($tpl['foreign_arr']) && !empty($tpl['foreign_arr']))
		{
			?><span class="float_left l5"><select name="foreign_id" id="foreign_id" class="pj-form-field">
				<option value="">---</option><?php
			foreach ($tpl['foreign_arr'] as $item)
			{
				?><option value="<?php echo $item['id']; ?>"<?php echo !isset($_GET['foreign_id']) || $_GET['foreign_id'] != $item['id'] ? NULL : ' selected="selected"'; ?>><?php echo pjSanitize::html($item['title']); ?></option><?php
			}
			?></select></span><?php
		}
		?>
		
		<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInvoice&amp;action=pjActionIndex" class="pj-button float_right"><?php __('plugin_invoice_config'); ?></a>
		<br class="clear_both" />
	</div>
	
	<div id="grid"></div>
	
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.jqDateFormat = "<?php echo pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']); ?>";
	pjGrid.jsDateFormat = "<?php echo pjUtil::jsDateFormat($tpl['option_arr']['o_date_format']); ?>";
	var myLabel = myLabel || {};
	myLabel.num = "<?php __('plugin_invoice_i_num'); ?>";
	myLabel.order_id = "<?php __('plugin_invoice_i_order_id'); ?>";
	myLabel.issue_date = "<?php __('plugin_invoice_i_issue_date'); ?>";
	myLabel.due_date = "<?php __('plugin_invoice_i_due_date'); ?>";
	myLabel.created = "<?php __('plugin_invoice_i_created'); ?>";
	myLabel.status = "<?php __('plugin_invoice_i_status'); ?>";
	myLabel.total = "<?php __('plugin_invoice_i_total'); ?>";
	myLabel.delete_title = "<?php __('plugin_invoice_i_delete_title'); ?>";
	myLabel.delete_body = "<?php __('plugin_invoice_i_delete_body'); ?>";
	myLabel.paid = "<?php echo $statuses['paid']; ?>";
	myLabel.not_paid = "<?php echo $statuses['not_paid']; ?>";
	myLabel.cancelled = "<?php echo $statuses['cancelled']; ?>";
	myLabel.booking_url = "<?php echo @$tpl['invoice_config_arr']['o_booking_url']; ?>";
	myLabel.empty_date = "<?php __('gridEmptyDate'); ?>";
	myLabel.invalid_date = "<?php __('gridInvalidDate'); ?>";
	myLabel.empty_datetime = "<?php __('gridEmptyDatetime'); ?>";
	myLabel.invalid_datetime = "<?php __('gridInvalidDatetime'); ?>";
	</script>
	<?php
}
?>