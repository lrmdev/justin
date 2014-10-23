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
	if (isset($_GET['err']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionSchedule"><?php __('booking_schedule'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionIndex"><?php __('menuBookings'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionCreate"><?php __('booking_add'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInvoice&amp;action=pjActionInvoices"><?php __('plugin_invoice_menu_invoices'); ?></a></li>
		</ul>
	</div>
	
	<div class="b10">
		<form action="" method="get" class="float_left pj-form frm-filter">
			<input type="text" name="q" class="pj-form-field pj-form-field-search w150" placeholder="<?php __('btnSearch', false, true); ?>" />
			<button type="button" class="pj-button pj-button-detailed"><span class="pj-button-detailed-arrow"></span></button>
		</form>
		<?php
		$statuses = __('booking_statuses', true, true);
		?>
		<div class="float_right t5">
			<a href="#" class="pj-button btn-all"><?php __('lblAll'); ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="booking_status" data-value="confirmed"><?php echo $statuses['confirmed']; ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="booking_status" data-value="pending"><?php echo $statuses['pending']; ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="booking_status" data-value="cancelled"><?php echo $statuses['cancelled']; ?></a>
		</div>
		<br class="clear_both" />
	</div>
	
	<div class="pj-form-filter-advanced" style="display: none">
		<span class="pj-menu-list-arrow"></span>
		<form action="" method="get" class="form pj-form pj-form-search frm-filter-advanced">
			<div class="float_left w400">
				<p>
					<label class="title"><?php __('booking_query'); ?></label>
					<input type="text" name="q" class="pj-form-field w150" value="<?php echo isset($_GET['q']) ? pjSanitize::html($_GET['q']) : NULL; ?>" />
				</p>
				<p>
					<label class="title"><?php __('booking_status'); ?></label>
					<select name="booking_status" class="pj-form-field w150">
						<option value="">-- <?php __('lblChoose'); ?> --</option>
						<?php
						foreach ($statuses as $k => $v)
						{
							?><option value="<?php echo $k; ?>"<?php echo isset($_GET['booking_status']) && $_GET['booking_status'] == $k ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($v); ?></option><?php
						}
						?>
					</select>
				</p>
				<p>
					<label class="title">&nbsp;</label>
					<input type="submit" value="<?php __('btnSearch'); ?>" class="pj-button" />
					<input type="reset" value="<?php __('btnCancel'); ?>" class="pj-button" />
				</p>
			</div>
			<div class="float_right w300">
				<p>
					<label class="title" style="width: 110px"><?php __('booking_from'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after float_left r5">
						<input type="text" name="date_from" class="pj-form-field w80 datepick pointer required" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
				<p>
					<label class="title" style="width: 110px"><?php __('booking_to'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after float_left r5">
						<input type="text" name="date_to" class="pj-form-field w80 datepick pointer required" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
			</div>
			<br class="clear_both" />
		</form>
	</div>

	<div id="dialogExport" title="<?php __('booking_export_title', false, true); ?>" style="display:none"></div>

	<div id="grid"></div>
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.jsDateFormat = "<?php echo pjUtil::jsDateFormat($tpl['option_arr']['o_date_format']); ?>";
	var myLabel = myLabel || {};
	myLabel.uuid = "<?php __('booking_uuid', false, true); ?>";
	myLabel.slots = "<?php __('booking_slots', false, true); ?>";
	myLabel.status = "<?php __('booking_status', false, true); ?>";
	myLabel.customer = "<?php __('booking_customer', false, true); ?>";
	myLabel.total = "<?php __('booking_total', false, true); ?>";
	myLabel.confirmed = "<?php echo $statuses['confirmed']; ?>";
	myLabel.pending = "<?php echo $statuses['pending']; ?>";
	myLabel.cancelled = "<?php echo $statuses['cancelled']; ?>";
	myLabel.export_selected = "<?php __('booking_export', false, true); ?>";
	myLabel.delete_selected = "<?php __('delete_selected', false, true); ?>";
	myLabel.delete_confirmation = "<?php __('delete_confirmation', false, true); ?>";
	</script>
	<?php
}
?>