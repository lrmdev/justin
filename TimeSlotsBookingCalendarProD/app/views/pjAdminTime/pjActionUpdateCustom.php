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
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	if (isset($_GET['err']))
	{
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	
	include dirname(__FILE__) . '/elements/menu_options.php';
	
	pjUtil::printNotice(@$titles['AT04'], @$bodies['AT04']);
	
	$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
	$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
	$pjTime = pjTime::factory();
	$business = $tpl['arr']['is_dayoff'] == 'T' ? 'none' : NULL;
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTime&amp;action=pjActionUpdateCustom" method="post" class="form pj-form" id="frmTimeCustom">
		<input type="hidden" name="custom_time" value="1" />
		<input type="hidden" name="id" value="<?php echo @$tpl['arr']['id']; ?>" />
		<fieldset class="fieldset white">
			<legend><?php __('time_custom'); ?></legend>
			<div class="float_left w350">
				<p>
					<label class="title"><?php __('time_date'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after">
						<input type="text" name="date" id="date" class="pj-form-field w80 datepick pointer required pps" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo pjUtil::formatDate($tpl['arr']['date'], 'Y-m-d', $tpl['option_arr']['o_date_format']); ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_from'); ?></label>
					<?php
					$start_time = explode(":", $tpl['arr']['start_time']);
					echo $pjTime
						->reset()
						->attr('name', 'start_hour')
						->attr('id', 'start_hour')
						->attr('class', 'pj-form-field w60 pps')
						->prop('selected', @$start_time[0])
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_minute')
						->attr('id', 'start_minute')
						->attr('class', 'pj-form-field w60 pps')
						->prop('step', 5)
						->prop('selected', @$start_time[1])
						->minute();
					?>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_to'); ?></label>
					<?php
					$end_time = explode(":", $tpl['arr']['end_time']);
					echo $pjTime
						->reset()
						->attr('name', 'end_hour')
						->attr('id', 'end_hour')
						->attr('class', 'pj-form-field w60 pps')
						->prop('selected', @$end_time[0])
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_minute')
						->attr('id', 'end_minute')
						->attr('class', 'pj-form-field w60 pps')
						->prop('step', 5)
						->prop('selected', @$end_time[1])
						->minute();
					?>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_price'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
						<input type="text" name="price" id="price" class="pj-form-field w70 align_right number" value="<?php echo number_format($tpl['arr']['price'], 2); ?>" />
					</span>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title">&nbsp;</label>
					<input type="checkbox" name="single_price" id="single_price" value="1"<?php echo !empty($tpl['price_arr']) ? NULL : ' checked="checked"'; ?> class="pps" />
					<label for="single_price"><?php __('time_single_price'); ?></label>
				</p>
			</div>
			<div class="float_right w350">
				<p>
					<label class="title"><?php __('time_is'); ?></label>
					<span class="block float_left t5 b10"><input type="checkbox" name="is_dayoff" id="is_dayoff" value="T"<?php echo $tpl['arr']['is_dayoff'] == 'T' ? ' checked="checked"' : NULL; ?> /></span>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_lunch_from'); ?></label>
					<?php
					$start_lunch = explode(":", $tpl['arr']['start_lunch']);
					echo $pjTime
						->reset()
						->attr('name', 'start_lunch_hour')
						->attr('id', 'start_lunch_hour')
						->attr('class', 'pj-form-field w60')
						->prop('selected', @$start_lunch[0])
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_lunch_minute')
						->attr('id', 'start_lunch_minute')
						->attr('class', 'pj-form-field w60')
						->prop('step', 5)
						->prop('selected', @$start_lunch[1])
						->minute();
					?>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_lunch_to'); ?></label>
					<?php
					$end_lunch = explode(":", $tpl['arr']['end_lunch']);
					echo $pjTime
						->reset()
						->attr('name', 'end_lunch_hour')
						->attr('id', 'end_lunch_hour')
						->attr('class', 'pj-form-field w60')
						->prop('selected', @$end_lunch[0])
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_lunch_minute')
						->attr('id', 'end_lunch_minute')
						->attr('class', 'pj-form-field w60')
						->prop('step', 5)
						->prop('selected', @$end_lunch[1])
						->minute();
					?>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_length'); ?></label>
					<select name="slot_length" id="slot_length" class="pj-form-field w120 pps">
					<?php
					$time_slot_length = __('time_slot_length', true);
					ksort($time_slot_length);
					foreach ($time_slot_length as $sk => $sv)
					{
						?><option value="<?php echo $sk; ?>"<?php echo $tpl['arr']['slot_length'] != $sk ? NULL : ' selected="selected"'; ?>><?php echo $sv; ?></option><?php
					}
					?>
					</select>
				</p>
				<p class="business" style="display: <?php echo $business; ?>">
					<label class="title"><?php __('time_limit'); ?></label>
					<input type="text" name="slot_limit" id="slot_limit" class="pj-form-field spin w60" value="<?php echo (int) $tpl['arr']['slot_limit']; ?>" />
				</p>
			</div>
			<br class="clear_both" />
			<div id="boxPPS" class="p business" style="display: <?php echo $business; ?>">
			<?php
			if (isset($tpl['price_arr']) && !empty($tpl['price_arr']))
			{
				?>
				<label class="title">&nbsp;</label>
				<table cellpadding="0" cellspacing="0" class="pj-table">
					<thead>
						<tr>
							<th><?php echo __('time_from'); ?></th>
							<th><?php echo __('time_to'); ?></th>
							<th><?php echo __('time_price'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					$step = $tpl['arr']['slot_length'] * 60;
					if ($step > 0)
					{
						$start_ts = strtotime($tpl['arr']['date'] . " " . $tpl['arr']['start_time']);
						$end_ts = strtotime($tpl['arr']['date'] . " " . $tpl['arr']['end_time']);
						# Fix for 24h support
						$offset = $end_ts <= $start_ts ? 86400 : 0;
							
						for ($i = $start_ts; $i < $end_ts + $offset; $i = $i + $step)
						{
							$value = NULL;
							foreach ($tpl['price_arr'] as $v)
							{
								if ($v['start_ts'] == $i && $v['end_ts'] == $i + $step)
								{
									$value = $v['price'];
									break;
								}
							}
							?>
							<tr>
								<td><?php echo date($tpl['option_arr']['o_time_format'], $i); ?></td>
								<td><?php echo date($tpl['option_arr']['o_time_format'], $i + $step); ?></td>
								<td>
									<span class="pj-form-field-custom pj-form-field-custom-before">
										<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
										<input type="text" name="price[<?php echo $i; ?>|<?php echo $i + $step; ?>]" id="price_<?php echo $i; ?>" class="pj-form-field w70 align_right" value="<?php echo $value; ?>" />
									</span>
								</td>
							</tr>
							<?php
						}
					}
					?>
					</tbody>
				</table>
				<?php
			}
			?>
			</div>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button"  />
			</p>
		</fieldset>
	</form>
	<?php
}
?>