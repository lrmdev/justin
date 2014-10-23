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
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	$plugin_menu = PJ_VIEWS_PATH . sprintf('pjLayouts/elements/menu_%s.php', $controller->getConst('PLUGIN_NAME'));
	if (is_file($plugin_menu))
	{
		include $plugin_menu;
	}
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	?>
	<style type="text/css">
	label[for="status_cancelled"].ui-state-active{
		background: #FEFEFE;
		color: black;
	}
	label[for="status_not_paid"].ui-state-active{
		background: red;
		color: #fff;
		text-shadow: 1px 1px 1px #444;
	}
	label[for="status_paid"].ui-state-active{
		background: green;
		color: white;
		text-shadow: 1px 1px 1px #333;
	}
	</style>
	<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjInvoice&amp;action=pjActionUpdate" method="post" class="pj-form form" id="frmUpdateInvoice">
		<input type="hidden" name="invoice_update" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		<input type="hidden" name="uuid" value="<?php echo $tpl['arr']['uuid']; ?>" />
		<input type="hidden" name="order_id" value="<?php echo $tpl['arr']['order_id']; ?>" />
		
		<?php pjUtil::printNotice(@$titles['PIN10'], @$bodies['PIN10']); ?>
		
		<fieldset class="fieldset light">
			<legend><?php __('plugin_invoice_general_info'); ?></legend>
			<div class="float_left w300">
				<p>
					<label class="title"><?php __('plugin_invoice_i_uuid'); ?></label>
					<span class="left h30"><?php echo @$tpl['arr']['id']; ?></span>
				</p>
				
				<p>
					<label class="title"><?php __('plugin_invoice_i_issue_date'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after">
						<input type="text" name="issue_date" id="issue_date" class="pj-form-field w80 datepick pointer" readonly="readonly" value="<?php echo pjUtil::formatDate(@$tpl['arr']['issue_date'], "Y-m-d", $tpl['option_arr']['o_date_format']); ?>" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_created'); ?></label>
					<span class="left"><?php echo !empty($tpl['arr']['created']) ? date($tpl['option_arr']['o_date_format'] . " H:i:s", strtotime($tpl['arr']['created'])) : '---'; ?></span>
				</p>
			</div>
			<div class="float_right w400">
				<p>
					<label class="title"><?php __('plugin_invoice_i_order_id'); ?></label>
					<span class="left h30"><?php
					if (!empty($tpl['config_arr']['o_booking_url']))
					{
						?><a href="<?php echo PJ_INSTALL_URL . str_replace('{ORDER_ID}', $tpl['arr']['order_id'], $tpl['config_arr']['o_booking_url']); ?>"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['order_id'])); ?></a><?php
					} else {
						echo htmlspecialchars(stripslashes(@$tpl['arr']['order_id']));
					}
					?></span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_due_date'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after">
						<input type="text" name="due_date" id="due_date" class="pj-form-field w80 datepick pointer" readonly="readonly" value="<?php echo pjUtil::formatDate(@$tpl['arr']['due_date'], "Y-m-d", $tpl['option_arr']['o_date_format']); ?>" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_modified'); ?></label>
					<span class="left"><?php echo !empty($tpl['arr']['modified']) ? date($tpl['option_arr']['o_date_format'] . " H:i:s", strtotime($tpl['arr']['modified'])) : '---'; ?></span>
				</p>
			</div>
			<br class="clear_both" />
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button" />
				<input type="button" value="<?php __('plugin_invoice_view'); ?>" class="pj-button btnInvoiceView" />
				<input type="button" value="<?php __('plugin_invoice_print'); ?>" class="pj-button btnInvoicePrint" />
				<input type="button" value="<?php __('plugin_invoice_send'); ?>" class="pj-button btnInvoiceSend" data-uuid="<?php echo $tpl['arr']['uuid']; ?>" />
			</p>
		</fieldset>
		
		<fieldset class="fieldset white">
			<legend><?php __('plugin_invoice_items_info'); ?></legend>
			<div id="grid_items"></div>
			<input type="button" class="t5 pj-button plugin_invoice_add_item" value="<?php __('plugin_invoice_add'); ?>" />
		</fieldset>
		
		<fieldset class="fieldset sky">
			<legend><?php __('plugin_invoice_payment_info'); ?></legend>
			<div class="float_left w350">
				<p>
					<label class="title"><?php __('plugin_invoice_i_subtotal'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="subtotal" id="subtotal" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['subtotal'])); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_discount'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="discount" id="discount" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['discount'])); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_tax'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="tax" id="tax" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['tax'])); ?>" />
					</span>
				</p>
				<?php if ((int) $tpl['config_arr']['si_include'] === 1 && (int) $tpl['config_arr']['si_shipping'] === 1) : ?>
				<p>
					<label class="title"><?php __('plugin_invoice_i_shipping'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="shipping" id="shipping" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['shipping'])); ?>" />
					</span>
				</p>
				<?php endif; ?>
				<p>
					<label class="title"><?php __('plugin_invoice_i_total'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="total" id="total" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['total'])); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_paid_deposit'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="paid_deposit" id="paid_deposit" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['paid_deposit'])); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_amount_due'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['arr']['currency'], ""); ?></abbr></span>
						<input type="text" name="amount_due" id="amount_due" class="pj-form-field number w80" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['amount_due'])); ?>" />
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_currency'); ?></label>
					<span class="left">
						<select name="currency" id="currency" class="pj-form-field w100">
						<option value="">---</option>
						<?php
						foreach (__('currencies', true) as $currency)
						{
							?><option value="<?php echo $currency; ?>"<?php echo $currency == @$tpl['arr']['currency'] ? ' selected="selected"' : NULL; ?>><?php echo $currency; ?></option><?php
						}
						?>
						</select>
					</span>
				</p>
				<p>
					<label class="title">&nbsp;</label>
					<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button" />
				</p>
			</div>
			<div class="float_right w350">
				<p>
					<label class="title"><?php __('plugin_invoice_i_status'); ?></label><br/>
					<span class="left h30 block" id="boxStatus">
					<?php
					foreach (__('plugin_invoice_statuses', true) as $k => $v)
					{
						?><input type="radio" name="status" id="status_<?php echo $k; ?>" value="<?php echo $k; ?>"<?php echo $tpl['arr']['status'] == $k ? ' checked="checked"' : NULL; ?> /> <label for="status_<?php echo $k; ?>"><?php echo $v; ?></label><?php
					}
					?>
					</span>
				</p>
				<p>
					<label class="title"><?php __('plugin_invoice_i_notes'); ?></label><br/>
					<span class="left">
						<textarea name="notes" id="notes" class="pj-form-field" style="width: 325px; height: 236px"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['notes'])); ?></textarea>
					</span>
				</p>
			</div>
			<br class="clear_both" />
		</fieldset>
		
		<?php pjUtil::printNotice(@$titles['PIN11'], @$bodies['PIN11']); ?>
		
		<fieldset class="fieldset white w340 float_left">
			<legend><?php __('plugin_invoice_billing_info'); ?></legend>
			<p>
				<label class="title"><?php __('plugin_invoice_i_billing_address'); ?></label>
				<span class="left">
					<input type="text" name="b_billing_address" id="b_billing_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_billing_address'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_company'); ?></label>
				<span class="left">
					<input type="text" name="b_company" id="b_company" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_company'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_name'); ?></label>
				<span class="left">
					<input type="text" name="b_name" id="b_name" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_name'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_address'); ?></label>
				<span class="left">
					<input type="text" name="b_address" id="b_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_address'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_street_address'); ?></label>
				<span class="left">
					<input type="text" name="b_street_address" id="b_street_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_street_address'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_city'); ?></label>
				<span class="left">
					<input type="text" name="b_city" id="b_city" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_city'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_state'); ?></label>
				<span class="left">
					<input type="text" name="b_state" id="b_state" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_state'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_zip'); ?></label>
				<span class="left">
					<input type="text" name="b_zip" id="b_zip" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_zip'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_phone'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
					<input type="text" name="b_phone" id="b_phone" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_phone'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_fax'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
					<input type="text" name="b_fax" id="b_fax" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_fax'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_email'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
					<input type="text" name="b_email" id="b_email" class="pj-form-field email" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_email'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_url'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-url"></abbr></span>
					<input type="text" name="b_url" id="b_url" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_url'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
			</p>
		</fieldset>
		
		<fieldset class="fieldset white w340 float_right">
			<legend><?php __('plugin_invoice_company_info'); ?></legend>
			<p>
				<label class="title"><?php __('plugin_invoice_i_company'); ?></label>
				<span class="left">
					<input type="text" name="y_company" id="y_company" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_company'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_name'); ?></label>
				<span class="left">
					<input type="text" name="y_name" id="y_name" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_name'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_street_address'); ?></label>
				<span class="left">
					<input type="text" name="y_street_address" id="y_street_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_street_address'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_city'); ?></label>
				<span class="left">
					<input type="text" name="y_city" id="y_city" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_city'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_state'); ?></label>
				<span class="left">
					<input type="text" name="y_state" id="y_state" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_state'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_zip'); ?></label>
				<span class="left">
					<input type="text" name="y_zip" id="y_zip" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_zip'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_phone'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
					<input type="text" name="y_phone" id="y_phone" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_phone'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_fax'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
					<input type="text" name="y_fax" id="y_fax" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_fax'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_email'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
					<input type="text" name="y_email" id="y_email" class="pj-form-field email" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_email'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_url'); ?></label>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-url"></abbr></span>
					<input type="text" name="y_url" id="y_url" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_url'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
			</p>
		</fieldset>
		
		<br class="clear_both" />
				
		<?php
		if ((int) $tpl['config_arr']['si_include'] === 1)
		{
			?>
			<fieldset class="fieldset white">
				<legend><?php __('plugin_invoice_shipping_info'); ?></legend>
				<div class="float_left w350">
					<?php if ((int) $tpl['config_arr']['si_shipping_address'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_shipping_address'); ?></label>
						<span class="left">
							<input type="text" name="s_shipping_address" id="s_shipping_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_shipping_address'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_company'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_company'); ?></label>
						<span class="left">
							<input type="text" name="s_company" id="s_company" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_company'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_name'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_name'); ?></label>
						<span class="left">
							<input type="text" name="s_name" id="s_name" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_name'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_address'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_address'); ?></label>
						<span class="left">
							<input type="text" name="s_address" id="s_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_address'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_street_address'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_street_address'); ?></label>
						<span class="left">
							<input type="text" name="s_street_address" id="s_street_address" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_street_address'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_city'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_city'); ?></label>
						<span class="left">
							<input type="text" name="s_city" id="s_city" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_city'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_state'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_state'); ?></label>
						<span class="left">
							<input type="text" name="s_state" id="s_state" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_state'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_zip'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_zip'); ?></label>
						<span class="left">
							<input type="text" name="s_zip" id="s_zip" class="pj-form-field w160" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_zip'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_phone'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_phone'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
							<input type="text" name="s_phone" id="s_phone" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_phone'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_fax'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_fax'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-phone"></abbr></span>
							<input type="text" name="s_fax" id="s_fax" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_fax'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_email'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_email'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
							<input type="text" name="s_email" id="s_email" class="pj-form-field email" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_email'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_url'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_url'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-before">
							<span class="pj-form-field-before"><abbr class="pj-form-field-icon-url"></abbr></span>
							<input type="text" name="s_url" id="s_url" class="pj-form-field" style="width: 133px" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_url'])); ?>" />
						</span>
					</p>
					<?php endif; ?>
				</div>
				<div class="float_right w350">
					<?php if ((int) $tpl['config_arr']['si_is_shipped'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_is_shipped'); ?></label>
						<span class="left">
							<input type="checkbox" name="s_is_shipped" value="1"<?php echo (int) $tpl['arr']['s_is_shipped'] === 1 ? ' checked="checked"' : NULL; ?> />
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_date'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_shipping_date'); ?></label>
						<span class="pj-form-field-custom pj-form-field-custom-after">
							<input type="text" name="s_date" id="s_date" class="pj-form-field w80 datepick pointer" readonly="readonly" value="<?php echo pjUtil::formatDate(@$tpl['arr']['s_date'], "Y-m-d", $tpl['option_arr']['o_date_format']); ?>"  rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
							<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
						</span>
					</p>
					<?php endif; ?>
					<?php if ((int) $tpl['config_arr']['si_terms'] === 1) : ?>
					<p>
						<label class="title"><?php __('plugin_invoice_i_shipping_terms'); ?></label><br />
						<span class="left">
							<textarea name="s_terms" id="s_terms" class="pj-form-field" style="width: 325px; height: 220px"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_terms'])); ?></textarea>
						</span>
					</p>
					<?php endif; ?>
					<p>
						<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
					</p>
				</div>
				<br class="clear_both" />
			</fieldset>
			<?php
		}
		?>
		<br class="clear_both" />
	</form>
	
	<form action="<?php echo PJ_INSTALL_URL; ?>index.php" method="get" target="_blank" style="display: none" id="frmPluginInvoicePrint">
		<input type="hidden" name="controller" value="pjInvoice" />
		<input type="hidden" name="action" value="pjActionPrint" />
		<input type="hidden" name="uuid" value="<?php echo $tpl['arr']['uuid']; ?>" />
	</form>
	
	<form action="<?php echo PJ_INSTALL_URL; ?>index.php" method="get" target="_blank" style="display: none" id="frmPluginInvoiceView">
		<input type="hidden" name="controller" value="pjInvoice" />
		<input type="hidden" name="action" value="pjActionView" />
		<input type="hidden" name="uuid" value="<?php echo $tpl['arr']['uuid']; ?>" />
	</form>
	
	<div id="dialogAddItem" style="display: none" title="<?php __('plugin_invoice_add_item_title'); ?>"></div>
	<div id="dialogEditItem" style="display: none" title="<?php __('plugin_invoice_edit_item_title'); ?>"></div>
	<div id="dialogSendInvoice" style="display: none" title="<?php __('plugin_invoice_send_invoice_title'); ?>"></div>
	
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.qty_is_int = <?php echo (int) @$tpl['config_arr']['o_qty_is_int'] === 1 ? 'true' : 'false'; ?>;
	var myLabel = myLabel || {};
	myLabel.btn_cancel = "<?php __('btnCancel'); ?>";
	myLabel.btn_save = "<?php __('plugin_invoice_save'); ?>";
	myLabel.btn_update = "<?php __('btnUpdate'); ?>";
	myLabel.btn_send = "<?php __('btnSend'); ?>";
	myLabel.i_item = "<?php __('plugin_invoice_i_item'); ?>";
	myLabel.i_qty = "<?php __('plugin_invoice_i_qty'); ?>";
	myLabel.i_unit = "<?php __('plugin_invoice_i_unit'); ?>";
	myLabel.i_amount = "<?php __('plugin_invoice_i_amount'); ?>";
	</script>
	<?php
}
?>