<?php
if (isset($tpl['status']) && $tpl['status'] == 'OK')
{
	$FORM = @$_SESSION[$controller->defaultForm];
	include PJ_VIEWS_PATH . 'pjFrontEnd/elements/cart.php';
	include PJ_VIEWS_PATH . 'pjFrontEnd/elements/summary.php';
	?>
	<div class="tsBox tsServicesOuter">
		<div class="tsServicesInner">
			<div class="tsHeading"><?php __('front_booking_form'); ?></div>
			<div class="tsOverflowHidden">
	
				<form action="" method="post" class="tsSelectorCheckoutForm">
					<input type="hidden" name="ts_checkout" value="1" />
					
					<div class="tsElement tsElementOutline">
					<?php
					if (in_array($tpl['option_arr']['o_bf_name'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_name'); ?><?php if ((int) $tpl['option_arr']['o_bf_name'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_name" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_name'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_name']) ? pjSanitize::html($FORM['customer_name']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_name', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_email'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_email'); ?><?php if ((int) $tpl['option_arr']['o_bf_email'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_email" class="tsFormField tsStretch tsEmail<?php echo $tpl['option_arr']['o_bf_email'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_email']) ? pjSanitize::html($FORM['customer_email']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_email', false)); ?>" data-msg-email="<?php echo pjSanitize::html(__('front_v_email_format', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_phone'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_phone'); ?><?php if ((int) $tpl['option_arr']['o_bf_phone'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_phone" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_phone'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_phone']) ? pjSanitize::html($FORM['customer_phone']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_phone', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_country'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_country'); ?><?php if ((int) $tpl['option_arr']['o_bf_country'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><select name="customer_country" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_country'] == 3 ? ' tsRequired' : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_country', false)); ?>">
								<option value="">-- <?php __('co_select_country'); ?> --</option>
								<?php
								if (isset($tpl['country_arr']) && is_array($tpl['country_arr']))
								{
									foreach ($tpl['country_arr'] as $v)
									{
										?><option value="<?php echo $v['id']; ?>"<?php echo isset($FORM['customer_country']) && $FORM['customer_country'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($v['name']); ?></option><?php
									}
								}
								?>
							</select></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_state'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_state'); ?><?php if ((int) $tpl['option_arr']['o_bf_state'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_state" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_state'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_state']) ? pjSanitize::html($FORM['customer_state']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_state', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_city'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_city'); ?><?php if ((int) $tpl['option_arr']['o_bf_city'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_city" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_city'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_city']) ? pjSanitize::html($FORM['customer_city']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_city', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_address_1'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('booking_address_1'); ?><?php if ((int) $tpl['option_arr']['o_bf_address_1'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_address_1" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_address_1'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_address_1']) ? pjSanitize::html($FORM['customer_address_1']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_address_1', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_address_2'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('booking_address_2'); ?><?php if ((int) $tpl['option_arr']['o_bf_address_2'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_address_2" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_address_2'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_address_2']) ? pjSanitize::html($FORM['customer_address_2']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_address_2', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_zip'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_zip'); ?><?php if ((int) $tpl['option_arr']['o_bf_zip'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><input type="text" name="customer_zip" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_zip'] == 3 ? ' tsRequired' : NULL; ?>" value="<?php echo isset($FORM['customer_zip']) ? pjSanitize::html($FORM['customer_zip']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_zip', false)); ?>" /></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_notes'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_notes'); ?><?php if ((int) $tpl['option_arr']['o_bf_notes'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsRowControl"><textarea name="customer_notes" class="tsFormField tsStretch<?php echo $tpl['option_arr']['o_bf_notes'] == 3 ? ' tsRequired' : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_notes', false)); ?>"><?php echo isset($FORM['customer_notes']) ? pjSanitize::html($FORM['customer_notes']) : NULL; ?></textarea></span>
						</div>
						<?php
					}
					if ((int) $tpl['option_arr']['o_disable_payments'] === 0 &&
						(int) $tpl['option_arr']['o_hide_prices'] === 0 &&
						isset($tpl['amount']) && $tpl['amount']['deposit'] > 0)
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('booking_payment_method'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsRowControl"><select name="payment_method" class="tsFormField tsStretch tsRequired" data-msg-required="<?php echo pjSanitize::html(__('front_v_payment_method', false)); ?>">
								<option value="">-- <?php __('front_select_payment'); ?> --</option>
								<?php
								foreach (__('payment_methods', true) as $k => $v)
								{
									if ((int) @$tpl['option_arr']['o_allow_' . $k] === 1)
									{
										?><option value="<?php echo $k; ?>"<?php echo isset($FORM['payment_method']) && $FORM['payment_method'] == $k ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($v); ?></option><?php
									}
								}
								?>
							</select></span>
						</div>
						<div class="tsRow tsSelectorBank" style="display: <?php echo @$FORM['payment_method'] != 'bank' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_bank_account'); ?></label>
							<span class="tsValue"><?php echo pjSanitize::html($tpl['option_arr']['o_bank_account']); ?></span>
						</div>
						<div class="tsRow tsSelectorCCard" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_type'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsRowControl"><select name="cc_type" class="tsFormField tsStretch tsRequired" data-msg-required="<?php echo pjSanitize::html(__('front_v_cc_type', false)); ?>">
								<option value="">---</option>
								<?php
								foreach (__('booking_cc_types', true) as $k => $v)
								{
									if (isset($FORM['cc_type']) && $FORM['cc_type'] == $k)
									{
										?><option value="<?php echo $k; ?>" selected="selected"><?php echo $v; ?></option><?php
									} else {
										?><option value="<?php echo $k; ?>"><?php echo $v; ?></option><?php
									}
								}
								?>
							</select></span>
						</div>
						<div class="tsRow tsSelectorCCard" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_num'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsRowControl"><input type="text" name="cc_num" class="tsFormField tsStretch tsRequired" value="<?php echo isset($FORM['cc_num']) ? pjSanitize::html($FORM['cc_num']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_cc_num', false)); ?>" /></span>
						</div>
						<div class="tsRow tsSelectorCCard" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_code'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsRowControl"><input type="text" name="cc_code" class="tsFormField tsStretch tsRequired" value="<?php echo isset($FORM['cc_code']) ? pjSanitize::html($FORM['cc_code']) : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_cc_code', false)); ?>" /></span>
						</div>
						<div class="tsRow tsSelectorCCard" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_exp'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsRowControl">
							<?php
							echo pjTime::factory()
								->attr('name', 'cc_exp_month')
								->attr('id', 'cc_exp_month')
								->attr('class', 'tsFormField tsRequired')
								->attr('data-msg-required', __('front_v_cc_exp_month', true))
								->prop('format', 'M')
								->prop('selected', @$FORM['cc_exp_month'])
								->month();
							?>
							<?php
							echo pjTime::factory()
								->attr('name', 'cc_exp_year')
								->attr('id', 'cc_exp_year')
								->attr('class', 'tsFormField tsRequired')
								->attr('data-msg-required', __('front_v_cc_exp_year', true))
								->prop('left', 0)
								->prop('right', 10)
								->prop('selected', @$FORM['cc_exp_year'])
								->year();
							?>
							</span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_captcha'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_captcha'); ?></label>
							<span class="tsRowControl">
								<input type="text" name="captcha" maxlength="6" style="width: 100px" class="tsFormField<?php echo $tpl['option_arr']['o_bf_captcha'] == 3 ? ' tsRequired' : NULL; ?>" data-msg-required="<?php echo pjSanitize::html(__('front_v_captcha', false)); ?>" data-msg-remote="<?php echo pjSanitize::html(__('front_v_captcha_match', false)); ?>" />
								<img src="<?php echo PJ_INSTALL_FOLDER; ?>index.php?controller=pjFrontEnd&amp;action=pjActionCaptcha&amp;rand=<?php echo rand(1, 999999); ?>" alt="Captcha" style="vertical-align: middle" />
								
							</span>
						</div>
						<?php
					}
					if (in_array((int) $tpl['option_arr']['o_bf_terms'], array(3)))
					{
						?>
						<div class="tsRow tsRowEmptyLabel">
							<label class="tsLabel">&nbsp;</label>
							<span class="tsRowControl">
								<span style="float: left; width: 15px">
									<input type="checkbox" name="terms" id="terms_<?php echo $_GET['cid']; ?>" value="1" class="<?php echo (int) $tpl['option_arr']['o_bf_terms'] === 3 ? ' tsRequired' : NULL; ?>" style="margin: 0" data-msg-required="<?php echo pjSanitize::html(__('front_v_terms', false)); ?>" />
								</span>
								<label for="terms_<?php echo $_GET['cid']; ?>" style="float: left; width: 85%"><?php __('front_bf_terms'); ?></label>
							</span>
						</div>
						<?php
						if (isset($tpl['terms_arr']) && !empty($tpl['terms_arr']))
						{
							$t_url = $tpl['terms_arr']['terms_url'];
							$t_body = trim($tpl['terms_arr']['terms_body']);
							?>
							<div class="tsRow tsRowEmptyLabel">
								<label class="tsLabel">&nbsp;</label>
								<span class="tsRowControl"><?php
								if (!empty($t_url) && preg_match('/^http(s)?:\/\//i', $t_url))
								{
									?><a href="<?php echo pjSanitize::html($t_url); ?>" class="tsServiceLink" target="_blank"><?php __('front_terms_link'); ?></a><?php
								} elseif (!empty($t_body)) {
									?><a href="#" class="tsSelectorPayConditions tsServiceLink"><?php __('front_terms_link'); ?></a><?php
								}
								?></span>
							</div>
							<?php
						}
					}
					?>
					</div>
					<div class="tsElement tsElementOutline tsElementNotice tsSelectorNotice" style="display: none"></div>
					<div class="tsElementOutline">
						<input type="button" value="<?php __('front_button_cancel', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGray" />
						<input type="submit" value="<?php __('front_button_continue', false, true); ?>" class="tsSelectorButton tsButton tsButtonGreen tsFloatRight" />
					</div>
				</form>
	
			</div>
		</div>
	</div>
	<?php
} elseif (isset($tpl['status']) && $tpl['status'] == 'ERR') {
	?>
	<div class="tsBox">
		<div class="tsServicesInner">
			<div class="tsHeading"><?php __('front_system_msg'); ?></div>
			<div class="tsOverflowHidden">
				<div class="tsElement tsElementOutline"><?php __('front_checkout_na'); ?></div>
				<div class="tsElementOutline">
					<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>