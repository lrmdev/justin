<form action="<?php echo PJ_INSTALL_URL?>index.php?controller=pjAdminBookings&amp;action=pjActionExport" method="post" class="form pj-form">
	<input type="hidden" name="export_form" value="1" />
	<p>
		<label class="title"><?php __('booking_format_lbl'); ?></label>
		<select name="format" class="pj-form-field">
		<?php
		foreach (__('booking_format', true) as $key => $value)
		{
			?><option value="<?php echo $key; ?>"<?php echo $key != 'csv' ? NULL : ' selected="selected"'?>><?php echo pjSanitize::html($value); ?></option><?php
		}
		?>
		</select>
	</p>
	<p class="csvRelated">
		<label class="title"><?php __('booking_delimiter_lbl'); ?></label>
		<select name="delimiter" class="pj-form-field">
		<?php
		foreach (__('booking_delimiter', true) as $key => $value)
		{
			?><option value="<?php echo $key; ?>"><?php echo pjSanitize::html($value); ?></option><?php
		}
		?>
		</select>
	</p>
</form>