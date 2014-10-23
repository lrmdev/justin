<?php
$cartClass = NULL;
switch ($_GET['action'])
{
	case 'pjActionCheckout':
	case 'pjActionPreview':
		$cartClass = ' tsCartInnerPreview';
		break;
}
?>
<div class="tsBox tsCartOuter">
	<div class="tsCartInner<?php echo $cartClass; ?>">
		<div class="tsHeading"><?php __('front_selected_timeslots'); ?></div>
		<div class="tsSelectorCartWrap tsOverflowHidden">
		<?php
		if (isset($tpl['cart_arr']))
		{
			if (!empty($tpl['cart_arr']) && array_key_exists($_GET['cid'], $tpl['cart_arr']) && !empty($tpl['cart_arr'][$_GET['cid']]))
			{
				$hidePrices = (int) $tpl['option_arr']['o_hide_prices'] === 1;
				
				$total = 0;
				foreach ($tpl['cart_arr'] as $cid => $date_arr)
				{
					if ($cid != $_GET['cid'])
					{
						continue;
					}
					foreach ($date_arr as $date => $time_arr)
					{
						foreach ($time_arr as $time => $q)
						{
							$total += @$tpl['cart_price_arr'][$cid][$time];
						}
					}
				}
				?>
				<div class="tsElement tsElementOutline">
					<div class="tsCartInfo">
						<div class="tsCartDate tsCartHead"><?php __('front_cart_date'); ?></div>
						<div class="tsCartStart tsCartHead"><?php __('front_cart_start_time'); ?></div>
						<div class="tsCartEnd tsCartHead"><?php __('front_cart_end_time'); ?></div>
						<?php if (!$hidePrices) : ?>
						<div class="tsCartPrice tsCartHead"><?php echo __('front_cart_price', true); ?></div>
						<?php endif; ?>
						<?php if (!in_array($_GET['action'], array('pjActionCheckout', 'pjActionPreview'))) : ?>
						<div class="tsCartRemove">&nbsp;</div>
						<?php endif; ?>
					</div>
					<?php
					foreach ($tpl['cart_arr'] as $cid => $date_arr)
					{
						if ($cid != $_GET['cid'])
						{
							continue;
						}
						foreach ($date_arr as $date => $time_arr)
						{
							foreach ($time_arr as $time => $q)
							{
								list($start_ts, $end_ts) = explode("|", $time);
								$sd = date("Y-m-d", $start_ts);
								$_date = $date == $sd ? $date : $sd;
								if (!in_array($_GET['action'], array('pjActionCheckout', 'pjActionPreview')))
								{
									?><div class="tsCartInfo tsSelectorRemoveFromCart tsCartRowBasket" data-start_ts="<?php echo $start_ts; ?>" data-end_ts="<?php echo $end_ts; ?>" data-date="<?php echo $date; ?>"><?php
								} else {
									?><div class="tsCartInfo"><?php
								}
								?>
									<div class="tsCartDate"><?php echo date($tpl['option_arr']['o_date_format'], strtotime($_date)); ?></div>
									<div class="tsCartStart"><?php echo date($tpl['option_arr']['o_time_format'], $start_ts); ?></div>
									<div class="tsCartEnd"><?php echo date($tpl['option_arr']['o_time_format'], $end_ts); ?></div>
									<?php if (!$hidePrices) : ?>
									<div class="tsCartPrice"><?php echo pjUtil::formatCurrencySign(number_format(@$tpl['cart_price_arr'][$cid][$time], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
									<?php endif; ?>
									<?php if (!in_array($_GET['action'], array('pjActionCheckout', 'pjActionPreview'))) : ?>
									<div class="tsCartRemove">
										<span class="tsIconRemove"></span>
									</div>
									<?php endif; ?>
								</div>
								<?php
							}
						}
					}
					?>
				</div>
				<?php
				switch ($_GET['action'])
				{
					case 'pjActionTimeslots':
					case 'pjActionGetCart':
					case 'pjActionCart':
						?>
						<?php if (!$hidePrices) : ?>
						<div class="tsElement tsElementOutline">
							<div class="tsCartInfo">
								<div class="tsCartTotal"><?php __('front_cart_total'); ?>:</div>
								<div class="tsCartTotalPrice"><?php echo pjUtil::formatCurrencySign(number_format($total, 2, '.', ','), $tpl['option_arr']['o_currency']); ?></div>
							</div>
						</div>
						<?php endif; ?>
						<div class="tsElementOutline">
							<input type="button" value="<?php __('front_button_back_calendar', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGray" />
							<input type="button" value="<?php __('front_button_proceed', false, true); ?>" class="tsSelectorButton tsSelectorCheckout tsButton tsButtonGreen tsFloatRight" />
						</div>
						<?php
						break;
				}
			} else {
				?>
				<div class="tsElement tsElementOutline"><?php __('front_cart_empty'); ?></div>
				<div class="tsElementOutline">
					<input type="button" value="<?php __('front_button_back_calendar', false, true); ?>" class="tsSelectorButton tsSelectorCalendar tsButton tsButtonGray" />
				</div>
				<?php
			}
		}
		?>
		</div>
	</div>
</div>