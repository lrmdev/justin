<?php
if (!isset($tpl['dayoff']))
{
	$step = $tpl['t_arr']['slot_length'] * 60;
	$numOfColumns = 1;
	# Fix for 24h support
	$offset = $tpl['t_arr']['end_ts'] <= $tpl['t_arr']['start_ts'] ? 86400 : 0;

	$numOfSlots = ceil(($offset + $tpl['t_arr']['end_ts'] - $tpl['t_arr']['start_ts']) / $step);
	$numOfSlotsPerColumn = ceil($numOfSlots / $numOfColumns);
	$firstHalfEndSlot = $tpl['t_arr']['start_ts'] + ($step * $numOfSlotsPerColumn);

	$now = time();
	
	$i = $tpl['t_arr']['start_ts'];
	foreach (range(0, $numOfColumns - 1) as $column)
	{
		?>
		<table cellpadding="0" cellspacing="0" class="pj-table" style="width: 100%">
			<thead>
				<tr>
					<th colspan="4"><?php echo date($tpl['option_arr']['o_date_format'], strtotime($_GET['date'])); ?></th>
				</tr>
				<tr>
					<th><?php __('booking_start_time'); ?></th>
					<th><?php __('booking_end_time'); ?></th>
					<th><?php __('booking_price'); ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$n = 0;
				for ($i = $tpl['t_arr']['start_ts'] + ($numOfSlotsPerColumn * $step * $column); $i < $tpl['t_arr']['end_ts'] + $offset; $i += $step)
				{
					if ($column == 0 && $i >= $firstHalfEndSlot)
					{
						break;
					}
					?>
					<tr class="pj-table-row-<?php echo ($n % 2 !== 0 ? 'even' : 'odd'); ?>">
						<td><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></td>
						<td><?php echo date($tpl['option_arr']['o_time_format'], $i + $step); ?></td>
						<td><?php echo pjUtil::formatCurrencySign(number_format(@$tpl['price_arr'][$i . "|" . ($i + $step)], 2, '.', ','), $tpl['option_arr']['o_currency']); ?></td>
						<td class="align_center">
						<?php
						$booked = array();
						foreach ($tpl['bs_arr'] as $bs)
						{
							if (strtotime($bs['booking_date'] . " " . $bs['start_time']) == $i && strtotime($bs['booking_date'] . " " . $bs['end_time']) == $i + $step)
							{
								$booked[] = $bs;
							}
						}
						if (count($booked) < $tpl['t_arr']['slot_limit'])
						{
							# Available
							$state = 2;
							
							foreach ($booked as $k => $v)
							{
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $v['booking_id']; ?>" class="pj-table-icon-edit" title="<?php __('_edit', false, true); ?>"></a><?php
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars" class="pj-table-icon-cancel timeslot-delete" data-id="<?php echo $v['id']; ?>" data-iso="<?php echo $_GET['date']; ?>" title="<?php __('cal_del_ts_title', false, true); ?>"></a><?php
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars" class="pj-table-icon-delete booking-delete" data-booking_id="<?php echo $v['booking_id']; ?>" data-iso="<?php echo $_GET['date']; ?>" title="<?php __('cal_del_title', false, true); ?>"></a><?php
								?><br /><?php
							}
							if ($i < $now)
							{
								echo 'Passed';
							} else {
								echo 'Available';
							}
							
						} else {
							# Fully booked
							foreach ($booked as $k => $v)
							{
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $v['booking_id']; ?>" class="pj-table-icon-edit" title="<?php __('_edit', false, true); ?>"></a><?php
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars" class="pj-table-icon-cancel timeslot-delete" data-id="<?php echo $v['id']; ?>" data-iso="<?php echo $_GET['date']; ?>" title="<?php __('cal_del_ts_title', false, true); ?>"></a><?php
								?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars" class="pj-table-icon-delete booking-delete" data-booking_id="<?php echo $v['booking_id']; ?>" data-iso="<?php echo $_GET['date']; ?>" title="<?php __('cal_del_title', false, true); ?>"></a><?php
								?><br /><?php
							}
						}
						?>
						</td>
					</tr>
					<?php
					$n++;
				}
				?>
			</tbody>
		</table>
		<?php
	}
} else {
	# Date/day is off
	__('booking_dayoff');
}
?>