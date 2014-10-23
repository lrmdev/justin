<?php
if ((int) $tpl['option_arr']['o_disable_payments'] === 0
	&& (int) $tpl['option_arr']['o_hide_prices'] === 0
	/*&& isset($tpl['amount']['price'])
	&& (float) $tpl['amount']['price'] > 0*/)
{
	?>
	<div class="tsBox tsCartOuter">
		<div class="tsCartInner">
			<div class="tsHeading"><?php __('front_summary'); ?></div>
			<div class="tsOverflowHidden">
				<div class="tsElement tsElementOutline">
					<div class="tsCartInfo">
						<div class="tsCartTotal"><?php __('front_summary_price'); ?></div>
						<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['amount']['price'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
					</div>
					<div class="tsCartInfo">
						<div class="tsCartTotal"><?php __('front_summary_tax'); ?></div>
						<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['amount']['tax'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
					</div>
					<div class="tsCartInfo">
						<div class="tsCartTotal"><?php __('front_summary_total'); ?></div>
						<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['amount']['total'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
					</div>
					<div class="tsCartInfo">
						<div class="tsCartTotal"><?php __('front_summary_deposit'); ?></div>
						<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($tpl['amount']['deposit'], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>