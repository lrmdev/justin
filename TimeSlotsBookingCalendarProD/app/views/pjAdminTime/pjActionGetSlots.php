<?php
$required = array('slot_length', 'date', 'start_hour', 'start_minute', 'end_hour', 'end_minute');
foreach ($required as $index)
{
	if (!array_key_exists($index, $_POST))
	{
		pjUtil::printNotice('Missing params', 'Prices per slot are unable to show up due missing parameters.');
		exit;
	}
}
?>
<label class="title">&nbsp;</label>
<table cellpadding="0" cellspacing="0" class="pj-table">
	<thead>
		<tr>
			<th><?php __('time_from'); ?></th>
			<th><?php __('time_to'); ?></th>
			<th><?php __('time_price'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$step = $_POST['slot_length'] * 60;
	$date = pjUtil::formatDate($_POST['date'], $tpl['option_arr']['o_date_format'], 'Y-m-d');
	$start_ts = strtotime($date . " " . $_POST['start_hour'] . ":" . $_POST['start_minute'] . ":00");
	$end_ts = strtotime($date . " " . $_POST['end_hour'] . ":" . $_POST['end_minute'] . ":00");
	
	# Fix for 24h support
	$offset = $end_ts <= $start_ts ? 86400 : 0;
		
	for ($i = $start_ts; $i < $end_ts + $offset; $i = $i + $step)
	{
		?>
		<tr>
			<td><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></td>
			<td><?php echo date($tpl['option_arr']['o_time_format'], $i + $step); ?></td>
			<td>
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
					<input type="text" name="price[<?php echo $i; ?>|<?php echo $i + $step; ?>]" id="price_<?php echo $i; ?>" class="pj-form-field w70 align_right" />
				</span>
			</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>