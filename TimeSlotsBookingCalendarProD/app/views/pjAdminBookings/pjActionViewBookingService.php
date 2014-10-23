<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
	?>
	<div class="form">
		<fieldset class="fieldset white">
			<legend><?php __('booking_general'); ?></legend>
			<div class="float_left w300">
				<p>
					<label class="title bold"><?php __('booking_uuid'); ?></label>
					<span class="left"><?php echo pjSanitize::html($tpl['arr']['uuid']); ?></span>
				</p>
				<p>
					<label class="title bold"><?php __('booking_status'); ?></label>
					<span class="left"><?php echo pjSanitize::html($tpl['arr']['booking_status']); ?></span>
				</p>
			</div>
			<div class="float_right w300">
				<p>
					<label class="title bold"><?php __('booking_created'); ?></label>
					<span class="left"><?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($tpl['arr']['created'])); ?></span>
				</p>
				<p>
					<label class="title bold"><?php __('booking_ip'); ?></label>
					<span class="left"><?php echo pjSanitize::html($tpl['arr']['ip']); ?></span>
				</p>
			</div>
			<br class="clear_both" />
			<p>
				<label class="title bold"><?php __('booking_service'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['service_name']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_dt'); ?></label>
				<span class="left"><?php echo date($tpl['option_arr']['o_datetime_format'], strtotime($tpl['arr']['date'] . " " . $tpl['arr']['start'])); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_notes'); ?></label>
				<span class=""><?php echo pjSanitize::html($tpl['arr']['c_notes']); ?></span>
			</p>
		</fieldset>
		<fieldset class="fieldset white">
			<legend><?php __('booking_customer'); ?></legend>
			<p>
				<label class="title bold"><?php __('booking_name'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_name']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_email'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_email']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_phone'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_phone']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_address_1'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_address_1']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_address_2'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_address_2']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_country'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['country_name']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_state'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_state']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_city'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_city']); ?></span>
			</p>
			<p>
				<label class="title bold"><?php __('booking_zip'); ?></label>
				<span class="left"><?php echo pjSanitize::html($tpl['arr']['c_zip']); ?></span>
			</p>
		</fieldset>
		
	</div>
	<?php
}
?>