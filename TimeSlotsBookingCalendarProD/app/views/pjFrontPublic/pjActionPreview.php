<?php
if (isset($tpl['status']) && $tpl['status'] == "OK")
{
	$FORM = @$_SESSION[$controller->defaultForm];
	include PJ_VIEWS_PATH . 'pjFrontEnd/elements/cart.php';
	include PJ_VIEWS_PATH . 'pjFrontEnd/elements/summary.php';
	?>
	<div class="tsBox tsServicesOuter">
		<div class="tsServicesInner">
			<div class="tsHeading"><?php __('front_preview_form'); ?></div>
			<div class="tsOverflowHidden">
			
				<form action="" method="post" class="tsSelectorPreviewForm">
					<input type="hidden" name="ts_preview" value="1" />
					
					<div class="tsElement tsElementOutline">
					<?php
					if (in_array($tpl['option_arr']['o_bf_name'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_name'); ?><?php if ((int) $tpl['option_arr']['o_bf_name'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_name']) ? pjSanitize::html($FORM['customer_name']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_email'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_email'); ?><?php if ((int) $tpl['option_arr']['o_bf_email'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_email']) ? pjSanitize::html($FORM['customer_email']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_phone'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_phone'); ?><?php if ((int) $tpl['option_arr']['o_bf_phone'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_phone']) ? pjSanitize::html($FORM['customer_phone']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_country'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_country'); ?><?php if ((int) $tpl['option_arr']['o_bf_country'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo pjSanitize::html(@$tpl['country_arr']['name']); ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_state'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_state'); ?><?php if ((int) $tpl['option_arr']['o_bf_state'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_state']) ? pjSanitize::html($FORM['customer_state']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_city'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_city'); ?><?php if ((int) $tpl['option_arr']['o_bf_zip'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_city']) ? pjSanitize::html($FORM['customer_city']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_address_1'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_address_1'); ?><?php if ((int) $tpl['option_arr']['o_bf_address_1'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_address_1']) ? pjSanitize::html($FORM['customer_address_1']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_address_2'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_address_2'); ?><?php if ((int) $tpl['option_arr']['o_bf_address_2'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_address_2']) ? pjSanitize::html($FORM['customer_address_2']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_zip'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_zip'); ?><?php if ((int) $tpl['option_arr']['o_bf_zip'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_zip']) ? pjSanitize::html($FORM['customer_zip']) : NULL; ?></span>
						</div>
						<?php
					}
					if (in_array($tpl['option_arr']['o_bf_notes'], array(2, 3)))
					{
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('opt_o_bf_notes'); ?><?php if ((int) $tpl['option_arr']['o_bf_notes'] === 3) : ?><span class="tsAsterisk">*</span><?php endif; ?></label>
							<span class="tsValue"><?php echo isset($FORM['customer_notes']) ? nl2br(pjSanitize::html($FORM['customer_notes'])) : NULL; ?></span>
						</div>
						<?php
					}
					if ((int) $tpl['option_arr']['o_disable_payments'] === 0 && isset($FORM['payment_method']) && (int) $tpl['option_arr']['o_hide_prices'] === 0)
					{
						$pm = __('payment_methods', true);
						$b_types = __('booking_cc_types', true);
						?>
						<div class="tsRow">
							<label class="tsLabel"><?php __('booking_payment_method'); ?><span class="tsAsterisk">*</span></label>
							<span class="tsValue"><?php echo isset($FORM['payment_method']) ? @$pm[$FORM['payment_method']] : NULL; ?></span>
						</div>
						<div class="tsRow" style="display: <?php echo @$FORM['payment_method'] != 'bank' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_bank_account'); ?></label>
							<span class="tsValue"><?php echo pjSanitize::html($tpl['option_arr']['o_bank_account']); ?></span>
						</div>
						<div class="tsRow" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_type'); ?></label>
							<span class="tsValue"><?php echo @$b_types[$FORM['cc_type']]; ?></span>
						</div>
						<div class="tsRow" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_num'); ?></label>
							<span class="tsValue"><?php echo isset($FORM['cc_num']) ? $FORM['cc_num'] : NULL; ?></span>
						</div>
						<div class="tsRow" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_exp'); ?></label>
							<span class="tsValue"><?php echo isset($FORM['cc_exp_year']) ? $FORM['cc_exp_year'] : NULL; ?>-<?php echo isset($FORM['cc_exp_month']) ? $FORM['cc_exp_month'] : NULL;?></span>
						</div>
						<div class="tsRow" style="display: <?php echo @$FORM['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
							<label class="tsLabel"><?php __('booking_cc_code'); ?></label>
							<span class="tsValue"><?php echo isset($FORM['cc_code']) ? $FORM['cc_code'] : NULL; ?></span>
						</div>
						<?php
					}
					?>
					</div>
					<div class="tsElement tsElementOutline tsElementNotice tsSelectorNotice" style="display: none"></div>
					<div class="tsElementOutline">
						<input type="button" value="<?php __('front_button_cancel', false, true); ?>" class="tsSelectorButton tsSelectorCheckout tsButton tsButtonGray" />
						<input type="submit" value="<?php __('front_button_confirm', false, true); ?>" class="tsSelectorButton tsButton tsButtonGreen tsFloatRight" />
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
				<div class="tsElement tsElementOutline"><?php __('front_preview_na'); ?></div>
				<div class="tsElementOutline">
					<input type="button" value="<?php __('front_start_over', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGreen" />
					<input type="button" value="<?php __('front_return_back', false, true); ?>" class="tsSelectorButton tsSelectorCheckout tsButton tsButtonGray" />
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>