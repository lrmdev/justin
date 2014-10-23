<?php
if (isset($tpl['bi_arr']) && !empty($tpl['bi_arr']))
{
	?>
	<table class="pj-table b10 float_left" cellpadding="0" cellspacing="0" style="width: 79%">
		<thead>
			<tr>
				<th class="w110"><?php __('booking_date'); ?></th>
				<th class="w110"><?php __('booking_start_time'); ?></th>
				<th class="w110"><?php __('booking_end_time'); ?></th>
				<th class="w110 align_right"><?php __('booking_price'); ?></th>
				<th class="w20">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($tpl['bi_arr'] as $item)
		{
			?>
			<tr>
				<td><?php echo date($tpl['option_arr']['o_date_format'], strtotime($item['booking_date'])); ?></td>
				<td><?php echo date($tpl['option_arr']['o_time_format'], strtotime($item['start_time'])); ?></td>
				<td><?php echo date($tpl['option_arr']['o_time_format'], strtotime($item['end_time'])); ?></td>
				<td class="align_right"><?php echo pjUtil::formatCurrencySign(number_format($item['price'], 2), $tpl['option_arr']['o_currency']); ?></td>
				<td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminBookings" class="pj-table-icon-delete item-delete" data-id="<?php echo @$item['id']; ?>" data-hash="<?php echo @$_GET['hash']; ?>" data-key="<?php echo $item['booking_date'] . '~' . $item['start_time']; ?>"></a></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
} else {
	?><span class="left"><?php __('booking_i_empty'); ?></span><?php
}
?>