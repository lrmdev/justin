<div class="tsBox tsServicesOuter">
	<div class="tsServicesInner">
		<div class="tsHeading"><?php __('front_select_timeslots'); ?> <?php echo pjUtil::formatDate($_GET['date'], 'Y-m-d', $tpl['option_arr']['o_date_format']); ?></div>
		<div class="tsSelectorTimeslotsWrap tsOverflowHidden">
		<?php
		if (!isset($tpl['dayoff']))
		{
			$hidePrices = (int) $tpl['option_arr']['o_hide_prices'] === 1;
			$step = $tpl['t_arr']['slot_length'] * 60;
			# Fix for 24h support
			$offset = $tpl['t_arr']['end_ts'] <= $tpl['t_arr']['start_ts'] ? 86400 : 0;
			$now = time();
			?>
			<div class="tsElement tsElementOutline">
			<?php
			$total = 0;
			if (!$hidePrices)
			{
				for ($i = $tpl['t_arr']['start_ts']; $i < $tpl['t_arr']['end_ts'] + $offset; $i += $step)
				{
					if ((float) @$tpl['price_arr'][$i . "|" . ($i + $step)] > 0)
					{
						$total += @$tpl['price_arr'][$i . "|" . ($i + $step)];
					}
				}
			}
			
			$CART = $controller->cart->getAll();
			?>
			<div class="tsCartInfo">
				<div class="tsTimeslotStart tsCartHead"><?php __('front_cart_start_time'); ?></div>
				<div class="tsTimeslotEnd tsCartHead"><?php __('front_cart_end_time'); ?></div>
				<?php if (!$hidePrices) : ?>
				<div class="tsTimeslotPrice tsCartHead"><?php echo __('front_cart_price', true); ?></div>
				<?php endif; ?>
				<div class="tsTimeslotRemove">&nbsp;</div>
				<div class="tsTimeslotClear"></div>
			</div>
			<?php
			for ($i = $tpl['t_arr']['start_ts']; $i < $tpl['t_arr']['end_ts'] + $offset; $i += $step)
			{
				$booked = 0;
				foreach ($tpl['bs_arr'] as $bs)
				{
					if ($bs['start_ts'] == $i && $bs['end_ts'] == $i + $step)
					{
						$booked++;
					}
				}
				$attr = NULL;
				if ($i < $now)
				{
					# Start Time is in past
					$state = 4;
					$class = "tsCartRowPast";
				} elseif ($i < $now + $tpl['option_arr']['o_hours_before'] * 3600) {
					# Bookings are not allowed X hours before
					$state = 6;
					$class = "tsCartRowPast";
				} elseif (isset($tpl['t_arr']['lunch_start_ts']) && isset($tpl['t_arr']['lunch_end_ts']) && $i >= $tpl['t_arr']['lunch_start_ts'] && $i < $tpl['t_arr']['lunch_end_ts']) {
					# Lunch break
					$state = 5;
					$class = "tsCartRowPast";
				} else {
					if ($booked < $tpl['t_arr']['slot_limit'])
					{
						$checked = NULL;
						if (isset($CART[$_GET['cid']][$_GET['date']][$i . "|" . ($i + $step)]))
						{
							# In basket
							$state = 1;
							$class = "tsCartRowBasket tsSelectorRemoveFromCart tsSelectorRemoveTimeslot";
						} else {
							# Available
							$state = 2;
							$class = "tsCartRowEnabled tsSelectorAddToCart";
						}
						$attr = ' data-date="'.$_GET['date'].'" data-start_ts="'.$i.'" data-end_ts="'.($i + $step).'"';
					} else {
						# Fully booked
						$state = 3;
						$class = "tsCartRowDisabled";
					}
				}
				?>
				<div class="tsCartInfo <?php echo $class; ?>"<?php echo $attr; ?>>
					<div class="tsTimeslotStart"><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></div>
					<div class="tsTimeslotEnd"><?php echo date($tpl['option_arr']['o_time_format'], $i + $step); ?></div>
					<?php if (!$hidePrices) : ?>
					<div class="tsTimeslotPrice"><?php
					if (!in_array($state, array(4,5,6)))
					{
						if (isset($tpl['price_arr'][$i . "|" . ($i + $step)]))
						{
							echo pjUtil::formatCurrencySign(number_format(@$tpl['price_arr'][$i . "|" . ($i + $step)], 2, '.', ','), $tpl['option_arr']['o_currency']);
						} else {
							echo pjUtil::formatCurrencySign(0.00, $tpl['option_arr']['o_currency']);
						}
					} else {
						switch ($state)
						{
							case 4:
								# Past
								__('front_cart_passed');
								break;
							case 5:
								# Lunch break
								__('front_cart_lunch');
								break;
							case 6:
								# Bookings are not allowed X hours before
								__('front_cart_before');
								break;
						}
					}
					?></div>
					<?php endif; ?>
					<div class="tsTimeslotRemove"><?php
					switch ($state)
					{
						case 1:
							# In basket
							?><span class="tsIconRemove"></span><?php
							break;
						case 2:
							# Available
							?><span class="tsIconAdd"></span><?php
							break;
						case 3:
							# Fully booked
							?><span class="tsIconDisabled"></span><?php
							break;
					}
					?></div>
					<div class="tsTimeslotClear"></div>
				</div>
				<?php
			}
			?>
			</div>
			<?php
		} else {
			# Date/day is off
			?><div class="tsElement tsElementOutline"><?php __('front_cart_dayoff'); ?></div><?php
		}
		?>
			<div class="tsElementOutline">
				<input type="button" class="tsButton tsButtonGray tsSelectorButton tsSelectorCalendar" value="<?php __('front_button_cancel', false, true); ?>" />
				<input type="button" class="tsButton tsButtonGray tsSelectorButton tsSelectorCart" value="<?php
				$slots = $controller->cart->getCount();
				if ($slots != 1)
				{
					printf(__('front_button_basket_plural', true, true), $slots);
				} else {
					printf(__('front_button_basket_singular', true, true), $slots);
				}
				?>" />
				<?php if ($slots > 0) : ?>
				<input type="button" class="tsButton tsButtonGreen tsSelectorButton tsSelectorCheckout tsFloatRight" value="<?php __('front_button_checkout', false, true); ?>" />
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>