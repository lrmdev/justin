<div class="tsBox tsCalendarOuter">
	<div class="tsCalendarInner">
		<div class="tsHeading"><?php __('front_select_time'); ?></div>
		<div class="tsSelectorCalendarWrap">
		<?php
		$start_ts = 0;
		$end_ts = 0;
		$cache = array();
		$slot_length = 0;
		
		$months = __('months', true);
		$suffix = __('day_suffix', true);
		list($year, $month, $day) = explode("-", $_GET['date']);
		list($to_year, $to_month, $to_day) = explode("-", date("Y-n-j", mktime(0,0,0, $month, $day+6, $year)));
		
		# Check slot length
		$isSlotLengthEqual = true;
		$tmp_length = 0;
		$i = 0;
		foreach ($tpl['t_arr'] as $iso_date => $data)
		{
			if ($i >= 5 && $data['end_ts'] >= $data['start_ts'])
			{
				break;
			}
			if ($data['is_dayoff'] == 'T')
			{
				continue;
			}
			if ($tmp_length === 0)
			{
				$tmp_length = $data['slot_length'];
			}
			if ($tmp_length != $data['slot_length'])
			{
				$isSlotLengthEqual = false;
				break;
			}
			$i += 1;
		}
		?>
			<div class="tsWeeklyHeading">
				<a href="#" class="tsWeeklyNav tsWeeklyNavPrev tsSelectorWeeklyNav" data-date="<?php echo date("Y/m/d", mktime(0, 0, 0, $month, $day-7, $year)); ?>"></a>
				<div class="tsWeeklyRange"><?php
				printf("%u%s %s - %u%s %s", $day, @$suffix[(int) $day], @$months[(int) $month], $to_day, @$suffix[$to_day], @$months[$to_month]);
				?></div>
				<a href="#" class="tsWeeklyNav tsWeeklyNavNext tsSelectorWeeklyNav" data-date="<?php echo date("Y/m/d", mktime(0, 0, 0, $month, $day+7, $year)); ?>"></a>
			</div>
		<?php
		if ($isSlotLengthEqual)
		{
			?>
			<table cellpadding="0" cellspacing="0" class="tsWeeklyTable">
				<thead>
					<tr>
						<th class="tsWeeklyTime">&nbsp;</th>
						<?php
						$days_short = __('days_short', true);
						$i = 0;
						foreach ($tpl['t_arr'] as $iso_date => $data)
						{
							if ($i > 6)
							{
								break;
							}
							$w = date("w", strtotime($iso_date));
							?><th class="tsWeeklyWeekday"><?php echo $days_short[$w]; ?></th><?php
							$i += 1;
							if ($data['is_dayoff'] == 'F')
							{
								$cache[$iso_date]['start_ts'] = mktime($data['start_hour'], $data['start_minutes'], 0);
								$cache[$iso_date]['end_ts'] = mktime($data['end_hour'], $data['end_minutes'], 0);
								if ($start_ts === 0 || $start_ts > $cache[$iso_date]['start_ts'])
								{
									$start_ts = $cache[$iso_date]['start_ts'];
								}
								if ($end_ts === 0 || $end_ts < $cache[$iso_date]['end_ts'])
								{
									$end_ts = $cache[$iso_date]['end_ts'];
								}
							}
							$slot_length = $data['slot_length'];
						}
						?>
					</tr>
				</thead>
				<tbody>
				<?php
				$CART = $controller->cart->getAll();
				$step = $slot_length * 60;
				$now = time();
				for ($j = $start_ts; $j < $end_ts; $j += $step)
				{
					?>
					<tr>
						<td class="tsWeeklyTime"><?php echo date("h:i A", $j); ?></td>
						<?php
						$k = 0;
						$offset = 0;
						foreach ($tpl['t_arr'] as $iso_date => $data)
						{
							if ($k > 6)
							{
								break;
							}
							$time = $j + $offset;
							list($y, $m, $d) = explode("-", $iso_date);
							list($h, $i) = explode(":", date("H:i", $time));
							$time = mktime((int) $h, (int) $i, 0, (int) $m, (int) $d, (int) $y);
							?><td><?php
							if ($data['is_dayoff'] == 'T')
							{
								# Dayoff
								echo '--';
							} elseif ($cache[$iso_date]['start_ts'] > $j) {
								# Too early
								echo '--';
							} elseif ($cache[$iso_date]['end_ts'] <= $j) {
								# Too late
								echo '--';
							} elseif ($time < $now) {
								# Start Time is in past
								echo '--';
								$state = 4;
							} elseif ($time < $now + $tpl['option_arr']['o_hours_before'] * 3600) {
								# Bookings are not allowed X hours before
								echo '--';
								$state = 6;
							} elseif (isset($data['lunch_start_ts'], $data['lunch_end_ts']) && $time >= $data['lunch_start_ts'] && $time < $data['lunch_end_ts']) {
								# Lunch break
								echo '--';
								$state = 5;
							} else {
								$booked = 0;
								foreach ($tpl['bs_arr'] as $bs)
								{
									if ($bs['start_ts'] == $time && $bs['end_ts'] == $time + $step)
									{
										$booked += 1;
									}
								}
								$attr = NULL;
								if ($booked < $data['slot_limit'])
								{
									$checked = NULL;
									if (isset($CART[$_GET['cid']][$iso_date][$time . "|" . ($time + $step)]))
									{
										# In basket
										$state = 1;
										$class = "tsWeeklyIconSelected tsSelectorRemoveFromCart tsSelectorRemoveTimeslot";
									} else {
										# Available
										$state = 2;
										$class = "tsWeeklyIconAvailable tsSelectorAddToCart";
									}
									$attr = ' data-date="'.$iso_date.'" data-start_ts="'.$time.'" data-end_ts="'.($time + $step).'"';
									?><a href="#" class="tsWeeklyIcon <?php echo $class; ?>"<?php echo $attr; ?>></a><?php
								} else {
									# Fully booked
									$state = 3;
									?><span class="tsWeeklyIcon tsWeeklyIconBooked"<?php echo $attr; ?>></span><?php
								}
							}
							?></td><?php
							$k += 1;
							$offset += 86400;
						}
						?>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<?php
		} else {
			?>
			<div class="tsElement tsElementOutline"><?php __('front_weekly_length'); ?></div>
			<?php
		}
		?>
		</div>
		
		<div class="tsElementOutline">
			<?php
			if ($isSlotLengthEqual && (int) $tpl['option_arr']['o_show_legend'] === 1)
			{
				?>
				<div class="tsWeeklyLegend">
					<div class="tsWeeklyLegendItem">
						<div class="tsWeeklyLegendIcon tsWeeklyLegendAvailable"></div>
						<div class="tsWeeklyLegendLabel"><?php __('front_weekly_available'); ?></div>
					</div>
					<div class="tsWeeklyLegendItem">
						<div class="tsWeeklyLegendIcon tsWeeklyLegendBooked"></div>
						<div class="tsWeeklyLegendLabel"><?php __('front_weekly_booked'); ?></div>
					</div>
					<div class="tsWeeklyLegendItem">
						<div class="tsWeeklyLegendIcon tsWeeklyLegendSelected"></div>
						<div class="tsWeeklyLegendLabel"><?php __('front_weekly_selected'); ?></div>
					</div>
				</div>
				<?php
			}
			
			if (!$controller->cart->isEmpty())
			{
				?><input type="button" class="tsButton tsButtonGreen tsSelectorButton tsSelectorCheckout tsFloatRight" value="<?php __('front_button_continue', false, true); ?>" /><?php
			}
			?>
		</div>
	</div>
</div>