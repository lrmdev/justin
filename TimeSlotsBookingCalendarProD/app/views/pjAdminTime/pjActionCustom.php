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
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminTime&amp;action=pjActionCustom" method="post" class="form pj-form" id="frmTimeCustom">
		<input type="hidden" name="custom_time" value="1" />
		<fieldset class="fieldset white">
			<legend><?php __('time_custom'); ?></legend>
			<div class="float_left w350">
				<p>
					<label class="title"><?php __('time_date'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-after">
						<input type="text" name="date" id="date" class="pj-form-field w80 datepick pointer required pps" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" />
						<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
					</span>
				</p>
				<p class="business">
					<label class="title"><?php __('time_from'); ?></label>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_hour')
						->attr('id', 'start_hour')
						->attr('class', 'pj-form-field w60 pps')
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_minute')
						->attr('id', 'start_minute')
						->attr('class', 'pj-form-field w60 pps')
						->prop('step', 5)
						->minute();
					?>
				</p>
				<p class="business">
					<label class="title"><?php __('time_to'); ?></label>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_hour')
						->attr('id', 'end_hour')
						->attr('class', 'pj-form-field w60 pps')
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_minute')
						->attr('id', 'end_minute')
						->attr('class', 'pj-form-field w60 pps')
						->prop('step', 5)
						->minute();
					?>
				</p>
				<p class="business">
					<label class="title"><?php __('time_price'); ?></label>
					<span class="pj-form-field-custom pj-form-field-custom-before">
						<span class="pj-form-field-before"><abbr class="pj-form-field-icon-text"><?php echo pjUtil::formatCurrencySign(NULL, $tpl['option_arr']['o_currency'], ""); ?></abbr></span>
						<input type="text" name="price" id="price" class="pj-form-field w70 align_right number" />
					</span>
				</p>
				<p class="business">
					<label class="title">&nbsp;</label>
					<input type="checkbox" name="single_price" id="single_price" value="1" checked="checked" class="pps" />
					<label for="single_price"><?php __('time_single_price'); ?></label>
				</p>
			</div>
			<div class="float_right w350">
				<p>
					<label class="title"><?php __('time_is'); ?></label>
					<span class="block float_left t5 b10"><input type="checkbox" name="is_dayoff" id="is_dayoff" value="T" /></span>
				</p>
				<p class="business">
					<label class="title"><?php __('time_lunch_from'); ?></label>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_lunch_hour')
						->attr('id', 'start_lunch_hour')
						->attr('class', 'pj-form-field w60')
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'start_lunch_minute')
						->attr('id', 'start_lunch_minute')
						->attr('class', 'pj-form-field w60')
						->prop('step', 5)
						->minute();
					?>
				</p>
				<p class="business">
					<label class="title"><?php __('time_lunch_to'); ?></label>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_lunch_hour')
						->attr('id', 'end_lunch_hour')
						->attr('class', 'pj-form-field w60')
						->hour();
					?>
					<?php
					echo $pjTime
						->reset()
						->attr('name', 'end_lunch_minute')
						->attr('id', 'end_lunch_minute')
						->attr('class', 'pj-form-field w60')
						->prop('step', 5)
						->minute();
					?>
				</p>
				<p class="business">
					<label class="title"><?php __('time_length'); ?></label>
					<select name="slot_length" id="slot_length" class="pj-form-field w120 pps">
					<?php
					$time_slot_length = __('time_slot_length', true);
					ksort($time_slot_length);
					foreach ($time_slot_length as $sk => $sv)
					{
						?><option value="<?php echo $sk; ?>"><?php echo $sv; ?></option><?php
					}
					?>
					</select>
				</p>
				<p class="business">
					<label class="title"><?php __('time_limit'); ?></label>
					<input type="text" name="slot_limit" id="slot_limit" class="pj-form-field spin w60" value="1" />
				</p>
			</div>
			<br class="clear_both" />
			<div id="boxPPS" class="p business"></div>
			<p>
				<label class="title">&nbsp;</label>
				<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button"  />
			</p>
		</fieldset>
	</form>
	
	<div class="b10">
		<?php
		$yesno = __('_yesno', true);
		?>
		<div class="float_right">
			<a href="#" class="pj-button btn-all"><?php __('lblAll'); ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="is_dayoff" data-value="T"><?php echo $yesno['T']; ?></a>
			<a href="#" class="pj-button btn-filter btn-status" data-column="is_dayoff" data-value="F"><?php echo $yesno['F']; ?></a>
		</div>
		<br class="clear_right" />
	</div>
	
	<div id="grid"></div>
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.jsDateFormat = "<?php echo pjUtil::jsDateFormat($tpl['option_arr']['o_date_format']); ?>";
	var myLabel = myLabel || {};
	myLabel.time_price = "<?php __('time_price', false, true); ?>";
	myLabel.time_date = "<?php __('time_date', false, true); ?>";
	myLabel.time_start = "<?php __('time_from', false, true); ?>";
	myLabel.time_end = "<?php __('time_to', false, true); ?>";
	myLabel.time_lunch_start = "<?php __('time_lunch_from', false, true); ?>";
	myLabel.time_lunch_end = "<?php __('time_lunch_to', false, true); ?>";
	myLabel.time_dayoff = "<?php __('time_is', false, true); ?>";
	myLabel.time_yesno = <?php echo pjAppController::jsonEncode(__('_yesno', true)); ?>;
	myLabel.delete_selected = "<?php __('delete_selected', false, true); ?>";
	myLabel.delete_confirmation = "<?php __('delete_confirmation', false, true); ?>";
	</script>
	<?php
}
?>