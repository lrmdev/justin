<?php
if (!isset($tpl['dayoff']))
{
	?>
	<div>
		<label class="title"><?php __('booking_slots'); ?></label>
	<?php
	$step = $tpl['t_arr']['slot_length'] * 60;
	if (/*$tpl['option_arr']['o_calendar_width']*/1000 >= 400)
	{
		$numOfColumns = 2;
	} else {
		$numOfColumns = 1;
	}
	# Fix for 24h support
	$offset = $tpl['t_arr']['end_ts'] <= $tpl['t_arr']['start_ts'] ? 86400 : 0;
	
	$numOfSlots = ceil(($offset + $tpl['t_arr']['end_ts'] - $tpl['t_arr']['start_ts']) / $step);
	$numOfSlotsPerColumn = ceil($numOfSlots / $numOfColumns);
	$firstHalfEndSlot = $tpl['t_arr']['start_ts'] + ($step * $numOfSlotsPerColumn);
	$now = time();
	
	$cid = $controller->getForeignId();
	$iso_date = pjUtil::formatDate($_GET['date'], $tpl['option_arr']['o_date_format']);
	#-------------------------------------
	ob_start();
	$total = 0;
	$CART = array();//$controller->getCart()->getAll();
	foreach (range(0, $numOfColumns - 1) as $column)
	{
		?>
		<table cellpadding="0" cellspacing="0" class="pj-table float_left r5 b5 w300">
			<thead>
				<tr>
					<th><?php __('front_cart_start_time'); ?></th>
					<th><?php __('front_cart_end_time'); ?></th>
					{PRICE}
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php
			for ($i = $tpl['t_arr']['start_ts'] + ($numOfSlotsPerColumn * $step * $column); $i < $tpl['t_arr']['end_ts'] + $offset; $i += $step)
			{
				if ($column == 0 && $i >= $firstHalfEndSlot)
				{
					break;
				}
				$booked = 0;
				foreach ($tpl['bs_arr'] as $bs)
				{
					if ($bs['start_ts'] == $i && $bs['end_ts'] == $i + $step)
					{
						$booked++;
					}
				}
				if ($i < $now)
				{
					# Start Time is in past
					$state = 4;
					$class = "pj-table-row-even";
				} elseif ($i < $now + $tpl['option_arr']['o_hours_before'] * 3600) {
					# Bookings are not allowed X hours before
					$state = 6;
					$class = "pj-table-row-even";
				} elseif (isset($tpl['t_arr']['lunch_start_ts']) && isset($tpl['t_arr']['lunch_end_ts']) && $i >= $tpl['t_arr']['lunch_start_ts'] && $i < $tpl['t_arr']['lunch_end_ts']) {
					# Lunch break
					$state = 5;
					$class = "pj-table-row-even";
				} else {
					if ($booked < $tpl['t_arr']['slot_limit'])
					{
						$checked = NULL;
						if (isset($CART[$cid][$iso_date][$i . "|" . ($i + $step)]))
						{
							# In basket
							$state = 1;
							$class = "";
						} else {
							# Available
							$state = 2;
							$class = "";
						}
					} else {
						# Fully booked
						$state = 3;
						$class = "pj-table-row-even";
					}
				}
				?>
				<tr class="<?php echo $class; ?>">
					<td><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></td>
					<td><?php echo date($tpl['option_arr']['o_time_format'], $i + $step); ?></td>
					<?php
					$price = (float) @$tpl['price_arr'][$i . "|" . ($i + $step)];
					if ((int) $tpl['option_arr']['o_hide_prices'] === 0 && $price > 0)
					{
						?><td><?php echo pjUtil::formatCurrencySign(number_format($price, 2, '.', ','), $tpl['option_arr']['o_currency']); ?></td><?php
						$total += @$tpl['price_arr'][$i . "|" . ($i + $step)];
					}
					?>
					<td class="align_center">
						<input type="hidden" name="price[<?php echo $i; ?>]" value="<?php echo $price; ?>" />
					<?php
					switch ($state)
					{
						case 1:
							# In basket
							?><input type="checkbox" name="timeslot[<?php echo $i; ?>]" value="<?php echo $i + $step; ?>" checked="checked" /><?php
							break;
						case 2:
							# Available
							?><input type="checkbox" name="timeslot[<?php echo $i; ?>]" value="<?php echo $i + $step; ?>" /><?php
							break;
						case 3:
							# Fully booked
							?><input type="checkbox" name="timeslot[<?php echo $i; ?>]" value="<?php echo $i + $step; ?>" checked="checked" disabled="disabled" /><?php
							break;
						case 4:
							# Past
							__('front_cart_passed');
							break;
						case 5:
							# Lunch break
							__('front_cart_lunch');
							break;
						case 6:
							# Not allowed X hours before
							__('front_cart_before');
							break;
					}
					?>
					</td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	}
	$content = ob_get_contents();
	ob_end_clean();
	$replacement = (int) $tpl['option_arr']['o_hide_prices'] === 0 && $total > 0 ? '<th>' . __('front_cart_price', true) . '</th>' : NULL;
	echo str_replace('{PRICE}', $replacement, $content);
	?>
		<br class="clear_left" />
	</div>
	<?php
} else {
	# Date/day is off
	__('front_cart_dayoff');
}
?>