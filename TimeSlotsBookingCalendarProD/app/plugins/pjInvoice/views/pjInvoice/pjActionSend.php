<form action="" method="post" class="pj-form form">
	<input type="hidden" name="uuid" value="<?php echo @$_GET['uuid']; ?>" />
	<?php
	$titles = __('error_titles', true);
	$bodies = __('error_bodies', true);
	pjUtil::printNotice($titles['PIN09'], $bodies['PIN09'], false);
	if (isset($tpl['arr']) && !empty($tpl['arr']))
	{
		?>
		<p>
			<label class="title"><span class="bold"><?php __('plugin_invoice_i_email'); ?></span><br />(<?php __('plugin_invoice_billing_info'); ?>)</label>
			<input type="checkbox" name="b_send" value="1" checked="checked" class="align_top" style="margin: 9px 5px 0 0" />
			<span class="pj-form-field-custom pj-form-field-custom-before">
				<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
				<input type="text" name="b_email" class="pj-form-field email w250" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['b_email'])); ?>" />
			</span>
		</p>
		<?php
		if ((int) $tpl['config_arr']['si_include'] === 1 && (int) $tpl['config_arr']['si_email'] === 1)
		{
			?>
			<p>
				<label class="title"><span class="bold"><?php __('plugin_invoice_i_email'); ?></span><br />(<?php __('plugin_invoice_shipping_info'); ?>)</label>
				<input type="checkbox" name="s_send" value="1" checked="checked" class="align_top" style="margin: 9px 5px 0 0" />
				<span class="pj-form-field-custom pj-form-field-custom-before">
					<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
					<input type="text" name="s_email" class="pj-form-field email w250" value="<?php echo htmlspecialchars(stripslashes(@$tpl['arr']['s_email'])); ?>" />
				</span>
			</p>
			<?php
		}
	}
	?>
</form>