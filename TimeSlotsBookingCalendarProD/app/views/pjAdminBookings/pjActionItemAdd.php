<?php
$week_start = isset($tpl['option_arr']['o_week_start']) && in_array((int) $tpl['option_arr']['o_week_start'], range(0,6)) ? (int) $tpl['option_arr']['o_week_start'] : 0;
$jqDateFormat = pjUtil::jqDateFormat($tpl['option_arr']['o_date_format']);
?>
<form action="" method="post" class="pj-form form">
	<input type="hidden" name="item_add" value="1" />
	<input type="hidden" name="booking_id" value="<?php echo @$_GET['id']; ?>" />
	<input type="hidden" name="hash" value="<?php echo @$_GET['hash']; ?>" />
					
	<div class="b10 p">
		<label class="title"><?php __('booking_date'); ?></label>
		<span class="pj-form-field-custom pj-form-field-custom-after float_left r5">
			<input type="text" name="date" class="pj-form-field w80 datepick pointer required" readonly="readonly" rel="<?php echo $week_start; ?>" rev="<?php echo $jqDateFormat; ?>" value="<?php echo date($tpl['option_arr']['o_date_format']); ?>" />
			<span class="pj-form-field-after"><abbr class="pj-form-field-icon-date"></abbr></span>
		</span>
	</div>
	
	<div class="item_details" style="display: none"></div>
</form>