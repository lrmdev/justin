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
	include PJ_VIEWS_PATH . 'pjLayouts/elements/optmenu.php';
	
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	pjUtil::printNotice($titles['PIN01'], $bodies['PIN01'], false);
	if (isset($_GET['err']))
	{
		pjUtil::printNotice(@$titles[$_GET['err']], !isset($_GET['errTime']) ? @$bodies[$_GET['err']] : $_SESSION[$controller->invoiceErrors][$_GET['errTime']]);
	}
	?>
	<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjInvoice&amp;action=pjActionIndex" method="post" class="pj-form form" enctype="multipart/form-data">
		<input type="hidden" name="invoice_post" value="1" />
		<fieldset class="fieldset white">
			<legend><?php __('plugin_invoice_company_info'); ?></legend>
			<p>
				<label class="title"><?php __('plugin_invoice_i_logo'); ?></label>
				<span class="left" id="plugin_invoice_box_logo">
					<?php
					if (!empty($tpl['arr']['y_logo']) && is_file($tpl['arr']['y_logo']))
					{
						?><img src="<?php echo $tpl['arr']['y_logo']; ?>" alt="" class="align_middle" />
						<input type="button" class="pj-button plugin_invoice_delete_logo" value="<?php __('lblDelete'); ?>" /><?php
					} else {
						?><input type="file" name="y_logo" id="y_logo" /><?php
					}
					?>
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_company'); ?></label>
				<span class="left">
					<input type="text" name="y_company" id="y_company" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_company'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_name'); ?></label>
				<span class="left">
					<input type="text" name="y_name" id="y_name" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_name'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_street_address'); ?></label>
				<span class="left">
					<input type="text" name="y_street_address" id="y_street_address" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_street_address'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_city'); ?></label>
				<span class="left">
					<input type="text" name="y_city" id="y_city" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_city'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_state'); ?></label>
				<span class="left">
					<input type="text" name="y_state" id="y_state" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_state'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_zip'); ?></label>
				<span class="left">
					<input type="text" name="y_zip" id="y_zip" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_zip'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_phone'); ?></label>
				<span class="left">
					<input type="text" name="y_phone" id="y_phone" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_phone'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_fax'); ?></label>
				<span class="left">
					<input type="text" name="y_fax" id="y_fax" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_fax'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_email'); ?></label>
				<span class="left">
					<input type="text" name="y_email" id="y_email" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_email'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title"><?php __('plugin_invoice_i_url'); ?></label>
				<span class="left">
					<input type="text" name="y_url" id="y_url" class="pj-form-field w400" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_url'])); ?>" />
				</span>
			</p>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
			</p>
		</fieldset>
		<fieldset class="fieldset white">
			<legend><?php __('plugin_invoice_config'); ?></legend>
			<div class="float_left w340">
				<p>
					<label><input type="checkbox" class="align_middle" name="p_accept_payments" value="1"<?php echo (int) $tpl['arr']['p_accept_payments'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_accept_payments'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" name="p_accept_paypal" data-box=".boxPaypal" value="1"<?php echo (int) $tpl['arr']['p_accept_paypal'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_accept_paypal'); ?></label>
				</p>
				<p class="boxPaypal" style="display: <?php echo (int) $tpl['arr']['p_accept_paypal'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_paypal_address'); ?></label><br />
					<span class="l20"><input type="text" name="p_paypal_address" class="pj-form-field w200" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['p_paypal_address'])); ?>" /></span>
				</p>
				<p>
					<label class="l20"><input type="checkbox" name="p_accept_authorize" data-box=".boxAuthorize" value="1"<?php echo (int) $tpl['arr']['p_accept_authorize'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_accept_authorize'); ?></label>
				</p>
				<p class="boxAuthorize" style="display: <?php echo (int) $tpl['arr']['p_accept_authorize'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_authorize_tz'); ?></label><br />
					<span class="l20">
						<select name="p_authorize_tz" class="pj-form-field">
						<?php
						foreach (__('timezones', true) as $k => $v)
						{
							?><option value="<?php echo $k; ?>"<?php echo $k == $tpl['arr']['p_authorize_tz'] ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
						}
						?>
						</select>
					</span>
				</p>
				<p class="boxAuthorize" style="display: <?php echo (int) $tpl['arr']['p_accept_authorize'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_authorize_key'); ?></label><br />
					<span class="l20"><input type="text" name="p_authorize_key" class="pj-form-field w200" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['p_authorize_key'])); ?>" /></span>
				</p>
				<p class="boxAuthorize" style="display: <?php echo (int) $tpl['arr']['p_accept_authorize'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_authorize_mid'); ?></label><br />
					<span class="l20"><input type="text" name="p_authorize_mid" class="pj-form-field w200" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['p_authorize_mid'])); ?>" /></span>
				</p>
				<p class="boxAuthorize" style="display: <?php echo (int) $tpl['arr']['p_accept_authorize'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_authorize_hash'); ?></label><br />
					<span class="l20"><input type="text" name="p_authorize_hash" class="pj-form-field w200" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['p_authorize_hash'])); ?>" /></span>
				</p>
				<p>
					<label class="l20"><input type="checkbox" name="p_accept_creditcard" value="1"<?php echo (int) $tpl['arr']['p_accept_creditcard'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_accept_creditcard'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" name="p_accept_bank" data-box=".boxBank" value="1"<?php echo (int) $tpl['arr']['p_accept_bank'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_accept_bank'); ?></label>
				</p>
				<p class="boxBank" style="display: <?php echo (int) $tpl['arr']['p_accept_bank'] === 1 ? NULL : 'none'; ?>">
					<label class="l20"><?php __('plugin_invoice_i_bank_account'); ?></label><br />
					<span class="l20"><textarea name="p_bank_account" class="pj-form-field w250 h50"><?php echo htmlspecialchars(stripslashes($tpl['arr']['p_bank_account'])); ?></textarea></span>
				</p>
				<p>
					<label><?php __('plugin_invoice_i_booking_url'); ?></label><br />
					<input type="text" name="o_booking_url" class="pj-form-field w250" value="<?php echo htmlspecialchars(stripslashes($tpl['arr']['o_booking_url'])); ?>" />
				</p>
				<p>
					<label><?php __('plugin_invoice_i_qty_is_int'); ?></label><br />
					<label class="l20"><input type="checkbox" name="o_qty_is_int" value="1"<?php echo (int) $tpl['arr']['o_qty_is_int'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_qty_int'); ?></label>
				</p>
			</div>
			<div class="float_right w340">
				<p>
					<label><input type="checkbox" class="align_middle" name="si_include" value="1"<?php echo (int) $tpl['arr']['si_include'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_include'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_shipping_address" value="1"<?php echo (int) $tpl['arr']['si_shipping_address'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_shipping_address'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_company" value="1"<?php echo (int) $tpl['arr']['si_company'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_company'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_name" value="1"<?php echo (int) $tpl['arr']['si_name'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_name'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_address" value="1"<?php echo (int) $tpl['arr']['si_address'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_address'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_street_address" value="1"<?php echo (int) $tpl['arr']['si_street_address'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_street_address'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_city" value="1"<?php echo (int) $tpl['arr']['si_city'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_city'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_state" value="1"<?php echo (int) $tpl['arr']['si_state'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_state'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_zip" value="1"<?php echo (int) $tpl['arr']['si_zip'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_zip'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_phone" value="1"<?php echo (int) $tpl['arr']['si_phone'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_phone'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_fax" value="1"<?php echo (int) $tpl['arr']['si_fax'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_fax'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_email" value="1"<?php echo (int) $tpl['arr']['si_email'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_email'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_url" value="1"<?php echo (int) $tpl['arr']['si_url'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_url'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_date" value="1"<?php echo (int) $tpl['arr']['si_date'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_date'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_terms" value="1"<?php echo (int) $tpl['arr']['si_terms'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_terms'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_is_shipped" value="1"<?php echo (int) $tpl['arr']['si_is_shipped'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_is_shipped'); ?></label>
				</p>
				<p>
					<label class="l20"><input type="checkbox" class="align_middle" name="si_shipping" value="1"<?php echo (int) $tpl['arr']['si_shipping'] === 1 ? ' checked="checked"' : NULL; ?> /> <?php __('plugin_invoice_i_s_shipping'); ?></label>
				</p>
			</div>
			<br class="clear_both" />
			<p>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
			</p>
		</fieldset>
		<fieldset class="fieldset white">
			<legend><?php __('plugin_invoice_template'); ?></legend>
			<p>
			{uuid},
			{order_id},
			{issue_date},
			{due_date},
			{created},
			{modified},
			{status},
			{subtotal},
			{discount},
			{tax},
			{shipping},
			{total},
			{paid_deposit},
			{amount_due},
			{currency},
			{notes},
			{y_logo},
			{y_company},
			{y_name},
			{y_street_address},
			{y_city},
			{y_state},
			{y_zip},
			{y_phone},
			{y_fax},
			{y_email},
			{y_url},
			{b_billing_address},
			{b_company},
			{b_name},
			{b_address},
			{b_street_address},
			{b_city},
			{b_state},
			{b_zip},
			{b_phone},
			{b_fax},
			{b_email},
			{b_url},
			{s_shipping_address},
			{s_company},
			{s_name},
			{s_address},
			{s_street_address},
			{s_city},
			{s_state},
			{s_zip},
			{s_phone},
			{s_fax},
			{s_email},
			{s_url},
			{s_date},
			{s_terms},
			{s_is_shipped},
			{items}
			</p>
			<div class="p5">
				<textarea name="y_template" id="y_template" class="pj-form-field w700 h600 mceEditor"><?php echo htmlspecialchars(stripslashes(@$tpl['arr']['y_template'])); ?></textarea>
			</div>
			<p>
				<input type="submit" value="<?php __('plugin_invoice_save'); ?>" class="pj-button float_left align_middle" />
			</p>
		</fieldset>
	</form>
	
	<div id="dialogDeleteLogo" style="display: none" title="<?php __('plugin_invoice_delete_logo_title'); ?>"><?php __('plugin_invoice_delete_logo_body'); ?></div>
	
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.btn_cancel = "<?php __('btnCancel'); ?>";
	myLabel.btn_delete = "<?php __('lblDelete'); ?>";
	</script>
	<?php
}
?>