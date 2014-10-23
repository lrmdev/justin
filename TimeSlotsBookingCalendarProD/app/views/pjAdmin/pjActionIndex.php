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
	?>
	<div class="dashboard_header">
		<div class="dashboard_header_item">
			<div class="dashboard_info">
				<abbr><?php echo (int) @$tpl['info_arr'][0]['bookings_today']; ?></abbr>
				<label><?php (int) @$tpl['info_arr'][0]['bookings_today'] !== 1 ? __('dashboard_bookings_today_plural') : __('dashboard_bookings_today_singular'); ?></label>
			</div>
		</div>
		<div class="dashboard_header_item">
			<div class="dashboard_info">
				<abbr><?php echo (int) @$tpl['info_arr'][0]['bookings_week']; ?></abbr>
				<label><?php (int) @$tpl['info_arr'][0]['bookings_week'] !== 1 ? __('dashboard_bookings_week_plural') : __('dashboard_bookings_week_singular'); ?></label>
			</div>
		</div>
		<div class="dashboard_header_item dashboard_header_item_last">
			<div class="dashboard_info">
				<abbr><?php echo (int) @$tpl['info_arr'][0]['users']; ?></abbr>
				<label><?php (int) @$tpl['info_arr'][0]['users'] !== 1 ? __('dashboard_users_plural') : __('dashboard_users_singular'); ?></label>
			</div>
		</div>
	</div>
	
	<div class="dashboard_box">
		<div class="dashboard_top">
			<div class="dashboard_column_top"><?php __('dashboard_upcoming_bookings'); ?></div>
			<div class="dashboard_column_top"><?php __('dashboard_latest_bookings'); ?></div>
			<div class="dashboard_column_top dashboard_column_top_last"><?php __('dashboard_last_logged_users'); ?></div>
		</div>
		<div class="dashboard_middle">
			<div class="dashboard_column">
				<?php
				if (empty($tpl['upcoming_arr']))
				{
					?><div class="dashboard_item bold"><?php __('dashboard_upcoming_bookings_empty'); ?></div><?php
				} else {
					foreach ($tpl['upcoming_arr'] as $booking)
					{
						?>
						<div class="dashboard_item">
							<span class="bold"><?php echo pjSanitize::html($booking['customer_name']); ?></span>
							<div class="b10">
								<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $booking['booking_id']; ?>"><?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($booking['booking_date'] . " " . $booking['start_time'])); ?></a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="dashboard_column">
			<?php
			if (empty($tpl['latest_arr']))
			{
				?><div class="dashboard_item bold"><?php __('dashboard_latest_bookings_empty'); ?></div><?php
			} else {
				foreach ($tpl['latest_arr'] as $booking)
				{
					?>
					<div class="dashboard_item">
						<span class="bold"><?php echo pjSanitize::html($booking['customer_name']); ?></span>
						<div class="b10">
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings&amp;action=pjActionUpdate&amp;id=<?php echo $booking['id']; ?>"><?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($booking['created'])); ?></a>
						</div>
					</div>
					<?php
				}
			}
			?>
			</div>
			<div class="dashboard_column dashboard_column_last">
			<?php
			if (empty($tpl['user_arr']))
			{
				?><div class="dashboard_item bold"><?php __('dashboard_last_logged_users_empty'); ?></div><?php
			} else {
				foreach ($tpl['user_arr'] as $user)
				{
					?>
					<div class="dashboard_item">
						<?php
						if ($controller->isAdmin())
						{
							?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminUsers&amp;action=pjActionUpdate&amp;id=<?php echo $user['id']; ?>"><?php echo pjSanitize::html($user['name']); ?></a><?php
						} else {
							?><span class="bold"><?php echo pjSanitize::html($user['name']); ?></span><?php
						}
						?>
						<div class="b10">
						<?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($user['last_login'])); ?>
						</div>
					</div>
					<?php
				}
			}
			?>
			</div>
		</div>
		<div class="dashboard_bottom"></div>
	</div>
	<?php
	$months = __('months', true);
	$days = __('days', true);
	?>
	<div class="clear_left t20 overflow">
		<div class="float_left black pt15">
			<span class="gray"><?php echo ucfirst(__('dashboard_last_login', true)); ?>:</span>
			<?php
			list($month_index, $other) = explode("_", date("n_d, Y H:i", strtotime($_SESSION[$controller->defaultUser]['last_login'])));
			printf("%s %s", $months[$month_index], $other);
			?>
		</div>
		<div class="float_right overflow">
		<?php
		list($hour, $day, $month_index, $other) = explode("_", date("H:i_w_n_d, Y"));
		?>
			<div class="dashboard_date">
				<abbr><?php echo @$days[$day]; ?></abbr>
				<?php printf("%s %s", $months[$month_index], $other); ?>
			</div>
			<div class="dashboard_hour"><?php echo $hour; ?></div>
		</div>
	</div>
	<?php
}
?>