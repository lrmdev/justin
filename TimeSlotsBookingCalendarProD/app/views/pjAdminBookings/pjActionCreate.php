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
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	$hash = md5(uniqid(rand(), true));
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionSchedule"><?php __('booking_schedule'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionIndex"><?php __('menuBookings'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionCreate"><?php __('booking_add'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInvoice&amp;action=pjActionInvoices"><?php __('plugin_invoice_menu_invoices'); ?></a></li>
		</ul>
	</div>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionCreate" method="post" id="frmCreateBooking" class="form pj-form frmBooking">
		<input type="hidden" name="booking_create" value="1" />
		<input type="hidden" name="hash" value="<?php echo $hash; ?>" />
		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1"><?php __('booking_tab_details'); ?></a></li>
				<li><a href="#tabs-2"><?php __('booking_tab_client'); ?></a></li>
			</ul>
			
			<div id="tabs-1">
				<?php pjUtil::printNotice(@$titles['ABK10'], @$bodies['ABK10']); ?>
				<fieldset class="fieldset white">
					<legend><?php __('booking_general'); ?></legend>
					<div class="float_left w450">
						<p>
							<label class="title"><?php __('booking_uuid'); ?>:</label>
							<input type="text" name="uuid" id="uuid" class="pj-form-field w100 required" value="<?php echo pjUtil::uuid(); ?>" />
						</p>
						<p>
							<label class="title"><?php __('booking_status'); ?>:</label>
							<select name="booking_status" id="booking_status" class="pj-form-field required">
								<option value=""><?php __('booking_choose'); ?></option>
								<?php
								foreach (__('booking_statuses', true) as $k => $v)
								{
									?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
								}
								?>
							</select>
						</p>
						<p>
							<label class="title"><?php __('booking_notes'); ?>:</label>
							<textarea name="customer_notes" id="customer_notes" class="pj-form-field w280 h120"></textarea>
						</p>
					</div>
					<div class="float_right w260">
						<?php if ((int) $tpl['option_arr']['o_disable_payments'] === 0): ?>
						<p>
							<label class="title" style="width: 120px"><?php __('booking_payment_method'); ?>:</label>
							<select name="payment_method" id="payment_method" class="pj-form-field w120 required">
								<option value=""><?php __('booking_choose'); ?></option>
								<?php
								foreach (__('payment_methods', true) as $k => $v)
								{
									?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
								}
								?>
							</select>
						</p>
						<p class="erCC" style="display: none">
							<label class="title" style="width: 120px"><?php __('booking_cc_type'); ?></label>
							<span class="inline_block">
								<select name="cc_type" class="pj-form-field w120">
									<option value="">---</option>
									<?php
									foreach (__('booking_cc_types', true) as $k => $v)
									{
										?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
									}
									?>
								</select>
							</span>
						</p>
						<p class="erCC" style="display: none">
							<label class="title" style="width: 120px"><?php __('booking_cc_num'); ?></label>
							<span class="inline_block">
								<input type="text" name="cc_num" id="cc_num" class="pj-form-field w120 digits" />
							</span>
						</p>
						<p class="erCC" style="display: none">
							<label class="title" style="width: 120px"><?php __('booking_cc_code'); ?></label>
							<span class="inline_block">
								<input type="text" name="cc_code" id="cc_code" class="pj-form-field w120 digits" />
							</span>
						</p>
						<p class="erCC" style="display: none">
							<label class="title" style="width: 120px"><?php __('booking_cc_exp'); ?></label>
							<span class="inline_block">
								<?php
								echo pjTime::factory()
									->attr('name', 'cc_exp_month')
									->attr('id', 'cc_exp_month')
									->attr('class', 'pj-form-field')
									->prop('format', 'M')
									->month();
								?>
								<?php
								echo pjTime::factory()
									->attr('name', 'cc_exp_year')
									->attr('id', 'cc_exp_year')
									->attr('class', 'pj-form-field')
									->prop('left', 0)
									->prop('right', 10)
									->year();
								?>
							</span>
						</p>
						<?php endif; ?>
						<p>
							<label class="title" style="width: 120px"><?php __('booking_price'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_price" id="booking_price" class="pj-form-field number w90" />
							</span>
						</p>
						<p>
							<label class="title" style="width: 120px"><?php __('booking_deposit'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_deposit" id="booking_deposit" class="pj-form-field number w90" />
							</span>
						</p>
						<p>
							<label class="title" style="width: 120px"><?php __('booking_tax'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_tax" id="booking_tax" class="pj-form-field number w90" />
							</span>
						</p>
						<p>
							<label class="title" style="width: 120px"><?php __('booking_total'); ?>:</label>
							<span class="pj-form-field-custom pj-form-field-custom-before">
								<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
								<input type="text" name="booking_total" id="booking_total" class="pj-form-field number w90" />
							</span>
						</p>
						<p>
							<input type="button" value="<?php __('booking_recalc', false, true); ?>" class="pj-button order-calc float_right" />
						</p>
					</div>
					<br class="clear_both" />
					<div class="t5"></div>
					<div class="p">
						<label class="title"><?php __('booking_slots'); ?>:</label>
						<div id="boxBookingItems"></div>
						
						<div id="dialogItemDelete" title="<?php __('booking_slots_delete_title', false, true); ?>" style="display: none"><?php __('booking_slots_delete_body'); ?></div>
						<div id="dialogItemAdd" title="<?php __('booking_slots_add_title', false, true); ?>" style="display: none"></div>
					</div>
					<p>
						<label class="title">&nbsp;</label>
						<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
						<input type="button" value="<?php __('booking_slot_add', false, true); ?>" class="pj-button item-add" />
					</p>
				</fieldset>
			</div>
			<div id="tabs-2">
				<?php pjUtil::printNotice(@$titles['ABK11'], @$bodies['ABK11']); ?>
				<fieldset class="fieldset white">
					<legend><?php __('booking_customer'); ?></legend>
					
					<div class="float_left w360">
						<p>
							<label class="title"><?php __('booking_country'); ?>:</label>
							<select name="customer_country" id="customer_country" class="pj-form-field w180 custom-chosen">
								<option value=""><?php __('booking_choose'); ?></option>
								<?php
								foreach ($tpl['country_arr'] as $country)
								{
									?><option value="<?php echo $country['id']; ?>"><?php echo pjSanitize::html($country['name']); ?></option><?php
								}
								?>
							</select>
						</p>
						<p>
							<label class="title"><?php __('booking_state'); ?>:</label>
							<input type="text" name="customer_state" id="customer_state" class="pj-form-field w180" />
						</p>
					</div>
					<div class="float_right w350">
						<p>
							<label class="title"><?php __('booking_city'); ?>:</label>
							<input type="text" name="customer_city" id="customer_city" class="pj-form-field w160" />
						</p>
						<p>
							<label class="title"><?php __('booking_zip'); ?>:</label>
							<input type="text" name="customer_zip" id="customer_zip" class="pj-form-field w80" />
						</p>
					</div>
					<br class="clear_both" />
					<p>
						<label class="title"><?php __('booking_name'); ?>:</label>
						<input type="text" name="customer_name" id="customer_name" class="pj-form-field w300" />
					</p>
					<p>
						<label class="title"><?php __('booking_email'); ?>:</label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
							<input type="text" name="customer_email" id="customer_email" class="pj-form-field email w250" />
						</span>
					</p>
					<p>
						<label class="title"><?php __('booking_phone'); ?>:</label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
							<input type="text" name="customer_phone" id="customer_phone" class="pj-form-field w250" />
						</span>
					</p>
					<p>
						<label class="title"><?php __('booking_address_1'); ?>:</label>
						<input type="text" name="customer_address_1" id="customer_address_1" class="pj-form-field w500" />
					</p>
					<p>
						<label class="title"><?php __('booking_address_2'); ?>:</label>
						<input type="text" name="customer_address_2" id="customer_address_2" class="pj-form-field w500" />
					</p>
					<p>
						<label class="title">&nbsp;</label>
						<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
					</p>
				</fieldset>
				
			</div>
		</div>
	</form>
	
	<?php
}
?>