<div style="margin: 0 auto; width: 450px">
	<div class="tsContainer">
		<div id="tsContainer_1" class="tsContainerInner">
			
		<?php
		if (isset($tpl['response'], $tpl['response']['status']) && $tpl['response']['status'] == "OK")
		{
			?>
			<div class="tsBox tsCartOuter">
				<div class="tsCartInner tsCartInnerPreview">
					<div class="tsHeading"><?php __('front_selected_timeslots'); ?></div>
					<div class="tsOverflowHidden">
					<?php
					if (isset($tpl['arr'], $tpl['arr']['bs_arr']))
					{
						if (!empty($tpl['arr']['bs_arr']))
						{
							$hidePrices = (int) $tpl['option_arr']['o_hide_prices'] === 1;
							?>
							<div class="tsElement tsElementOutline">
								<div class="tsCartInfo">
									<div class="tsCartDate tsCartHead"><?php __('front_cart_date'); ?></div>
									<div class="tsCartStart tsCartHead"><?php __('front_cart_start_time'); ?></div>
									<div class="tsCartEnd tsCartHead"><?php __('front_cart_end_time'); ?></div>
									<?php if (!$hidePrices) : ?>
									<div class="tsCartPrice tsCartHead"><?php echo __('front_cart_price', true); ?></div>
									<?php endif; ?>
								</div>
								<?php
								foreach ($tpl['arr']['bs_arr'] as $slot)
								{
									$sd = date("Y-m-d", $slot['start_ts']);
									$_date = $slot['booking_date'] == $sd ? $slot['booking_date'] : $sd;
									?>
									<div class="tsCartInfo">
										<div class="tsCartDate"><?php echo date($tpl['option_arr']['o_date_format'], strtotime($_date)); ?></div>
										<div class="tsCartStart"><?php echo date($tpl['option_arr']['o_time_format'], $slot['start_ts']); ?></div>
										<div class="tsCartEnd"><?php echo date($tpl['option_arr']['o_time_format'], $slot['end_ts']); ?></div>
										<?php if (!$hidePrices) : ?>
										<div class="tsCartPrice"><?php echo pjUtil::formatCurrencySign(number_format($slot['price'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
										<?php endif; ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						} else {
							?>
							<div class="tsElement tsElementOutline"><?php __('front_cart_empty'); ?></div>
							<?php
						}
					}
					?>
					</div>
				</div>
			</div>
	
			<?php
			if ((int) $tpl['option_arr']['o_disable_payments'] === 0
				&& (int) $tpl['option_arr']['o_hide_prices'] === 0
				/*&& isset($tpl['arr']['booking_price'])
				&& (float) $tpl['arr']['booking_price'] > 0*/)
			{
				?>
				<div class="tsBox tsCartOuter">
					<div class="tsCartInner">
						<div class="tsHeading"><?php __('front_summary'); ?></div>
						<div class="tsOverflowHidden">
							<div class="tsElement tsElementOutline">
								<div class="tsCartInfo">
									<div class="tsCartTotal"><?php __('front_summary_price'); ?></div>
									<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['arr']['booking_price'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
								</div>
								<div class="tsCartInfo">
									<div class="tsCartTotal"><?php __('front_summary_tax'); ?></div>
									<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['arr']['booking_tax'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
								</div>
								<div class="tsCartInfo">
									<div class="tsCartTotal"><?php __('front_summary_total'); ?></div>
									<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['arr']['booking_total'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
								</div>
								<div class="tsCartInfo">
									<div class="tsCartTotal"><?php __('front_summary_deposit'); ?></div>
									<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['arr']['booking_deposit'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<div class="tsBox tsServicesOuter">
				<div class="tsServicesInner">
					<div class="tsHeading"><?php __('front_preview_form'); ?></div>
					<div class="tsOverflowHidden">
					
						<form action="<?php echo PJ_INSTALL_URL; ?>index.php?controller=pjFrontEnd&amp;action=pjActionCancel&amp;uuid=<?php echo $_GET['uuid']; ?>&amp;hash=<?php echo $_GET['hash']; ?>" method="post">
							<input type="hidden" name="ts_cancel_booking" value="1" />
							
							<div class="tsElement tsElementOutline">
							<?php
							if (in_array($tpl['option_arr']['o_bf_name'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_name'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_name']) ? pjSanitize::html($tpl['arr']['customer_name']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_email'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_email'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_email']) ? pjSanitize::html($tpl['arr']['customer_email']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_phone'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_phone'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_phone']) ? pjSanitize::html($tpl['arr']['customer_phone']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_country'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_country'); ?></label>
									<span class="tsValue"><?php echo pjSanitize::html(@$tpl['arr']['country_name']); ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_state'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_state'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_state']) ? pjSanitize::html($tpl['arr']['customer_state']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_city'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_city'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_city']) ? pjSanitize::html($tpl['arr']['customer_city']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_address_1'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_address_1'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_address_1']) ? pjSanitize::html($tpl['arr']['customer_address_1']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_address_2'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_address_2'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_address_2']) ? pjSanitize::html($tpl['arr']['customer_address_2']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_zip'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_zip'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_zip']) ? pjSanitize::html($tpl['arr']['customer_zip']) : NULL; ?></span>
								</div>
								<?php
							}
							if (in_array($tpl['option_arr']['o_bf_notes'], array(2, 3)))
							{
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('opt_o_bf_notes'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['customer_notes']) ? nl2br(pjSanitize::html($tpl['arr']['customer_notes'])) : NULL; ?></span>
								</div>
								<?php
							}
							if ((int) $tpl['option_arr']['o_disable_payments'] === 0 && isset($tpl['arr']['payment_method']) && (int) $tpl['option_arr']['o_hide_prices'] === 0)
							{
								$pm = __('payment_methods', true);
								$b_types = __('booking_cc_types', true);
								?>
								<div class="tsRow">
									<label class="tsLabel"><?php __('booking_payment_method'); ?></label>
									<span class="tsValue"><?php echo isset($tpl['arr']['payment_method']) ? @$pm[$tpl['arr']['payment_method']] : NULL; ?></span>
								</div>
								<div class="tsRow" style="display: <?php echo @$tpl['arr']['payment_method'] != 'bank' ? 'none' : NULL; ?>">
									<label class="tsLabel"><?php __('booking_bank_account'); ?></label>
									<span class="tsValue"><?php echo pjSanitize::html($tpl['option_arr']['o_bank_account']); ?></span>
								</div>
								<div class="tsRow" style="display: <?php echo @$tpl['arr']['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
									<label class="tsLabel"><?php __('booking_cc_type'); ?></label>
									<span class="tsValue">******</span>
								</div>
								<div class="tsRow" style="display: <?php echo @$tpl['arr']['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
									<label class="tsLabel"><?php __('booking_cc_num'); ?></label>
									<span class="tsValue">******</span>
								</div>
								<div class="tsRow" style="display: <?php echo @$tpl['arr']['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
									<label class="tsLabel"><?php __('booking_cc_exp'); ?></label>
									<span class="tsValue">******</span>
								</div>
								<div class="tsRow" style="display: <?php echo @$tpl['arr']['payment_method'] != 'creditcard' ? 'none' : NULL; ?>">
									<label class="tsLabel"><?php __('booking_cc_code'); ?></label>
									<span class="tsValue">******</span>
								</div>
								<?php
							}
							?>
							</div>
							<div class="tsElementOutline">
								<input type="submit" value="<?php __('front_button_cancel_booking', false, true); ?>" class="tsButton tsButtonGreen" />
							</div>
						</form>
						
					</div>
				</div>
			</div>
			<?php
		} elseif (isset($tpl['response'], $tpl['response']['status']) && $tpl['response']['status'] == 'ERR') {
			?>
			<div class="tsBox">
				<div class="tsServicesInner">
					<div class="tsHeading"><?php __('front_system_msg'); ?></div>
					<div class="tsOverflowHidden">
						<div class="tsElement tsElementOutline"><?php echo $tpl['response']['text']; ?></div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
			
		</div>
	</div>
</div>