<?php
if (isset($tpl['arr']) && !empty($tpl['arr']))
{
	?>
	<form action="" method="post" class="form pj-form">
		<input type="hidden" name="send_email" value="1" />
		<input type="hidden" name="id" value="<?php echo $tpl['arr']['id']; ?>" />
		<input type="hidden" name="from" value="<?php echo $tpl['arr']['from']; ?>" />
		<p>
			<span class="bold inline_block b5"><?php __('booking_subject'); ?></span>
			<span><input type="text" name="subject" id="confirm_subject" class="pj-form-field w600 required" value="<?php echo pjSanitize::html($tpl['arr']['subject']); ?>" /></span>
		</p>
		<p>
			<span class="bold inline_block b5"><?php __('booking_message'); ?></span>
			<span><textarea name="message" id="confirm_message" class="pj-form-field w600 h300 required"><?php echo stripslashes(str_replace(array('\r\n', '\n'), '&#10;', $tpl['arr']['message'])); ?></textarea></span>
		</p>
		<?php if (!empty($tpl['arr']['client_email'])) : ?>
		<p>
			<label><input class="required" type="checkbox" name="to[]" value="<?php echo pjSanitize::html($tpl['arr']['client_email']); ?>" checked="checked" /> <?php __('booking_reminder_client'); ?> (<?php echo pjSanitize::html($tpl['arr']['client_email']); ?>)</label>
		</p>
		<?php endif; ?>
	</form>
	<?php
}
?>