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
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminUsers&amp;action=pjActionIndex"><?php __('menuUsers'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminUsers&amp;action=pjActionCreate"><?php __('lblAddUser'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminUsers&amp;action=pjActionUpdate&amp;id=<?php echo $tpl['arr']['id']; ?>"><?php __('lblUpdateUser'); ?></a></li>
		</ul>
	</div>

	<?php pjUtil::printNotice(@$titles['AU11'], @$bodies['AU11']); ?>
		
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminUsers&amp;action=pjActionUpdate" method="post" id="frmUpdateUser" class="form pj-form">
		<input type="hidden" name="user_update" value="1" />
		<input type="hidden" name="id" value="<?php echo (int) $tpl['arr']['id']; ?>" />
		<p>
			<label class="title"><?php __('lblRole'); ?></label>
			<span class="inline_block">
				<select name="role_id" id="role_id" class="pj-form-field required">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
				<?php
				foreach ($tpl['role_arr'] as $v)
				{
					?><option value="<?php echo $v['id']; ?>"<?php echo $tpl['arr']['role_id'] == $v['id'] ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($v['role']); ?></option><?php
				}
				?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('email'); ?></label>
			<span class="pj-form-field-custom pj-form-field-custom-before">
				<span class="pj-form-field-before"><abbr class="pj-form-field-icon-email"></abbr></span>
				<input type="text" name="email" id="email" class="pj-form-field required email w200" value="<?php echo pjSanitize::html($tpl['arr']['email']); ?>" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('pass'); ?></label>
			<span class="pj-form-field-custom pj-form-field-custom-before">
				<span class="pj-form-field-before"><abbr class="pj-form-field-icon-password"></abbr></span>
				<input type="text" name="password" id="password" class="pj-form-field required w200" value="<?php echo pjSanitize::html($tpl['arr']['password']); ?>" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblName'); ?></label>
			<span class="inline_block">
				<input type="text" name="name" id="name" value="<?php echo pjSanitize::html($tpl['arr']['name']); ?>" class="pj-form-field w250 required" />
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblReceiveEmails'); ?></label>
			<span class="inline_block">
				<select name="notify_email[]" class="pj-form-field" multiple="multiple" size="5">
					<?php
					foreach (__('receive_emails', true, false) as $k => $v)
					{
						if(empty($tpl['arr']['notify_email']))
						{
							?><option value="<?php echo $k;?>" selected="selected"><?php echo pjSanitize::html($v); ?></option><?php
						}else{
							?><option value="<?php echo $k;?>"<?php echo in_array($k, explode("::", $tpl['arr']['notify_email'])) ? ' selected="selected"' : null;?>><?php echo pjSanitize::html($v); ?></option><?php
						}
					}
					?>
				</select>
			</span>
		</p>
		<p>
			<label class="title"><?php __('lblStatus'); ?></label>
			<span class="inline_block">
				<select name="status" id="status" class="pj-form-field required">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
					<?php
					foreach (__('u_statarr', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"<?php echo $k == $tpl['arr']['status'] ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
					}
					?>
				</select>
			</span>
		</p>
		
		<?php
		if ($tpl['arr']['role_id'] == 3)
		{
			?>
			<p><label class="title"><?php __('lblIsActive'); ?></label>
				<select name="is_active" id="is_active" class="pj-form-field required">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
					<?php
					foreach (__('u_statarr', true) as $k => $v)
					{
						?><option value="<?php echo $k; ?>"<?php echo $k == $tpl['arr']['is_active'] ? ' selected="selected"' : NULL; ?>><?php echo $v; ?></option><?php
					}
					?>
				</select>
			</p>
			<?php
		}
		?>
		<p>
			<label class="title"><?php __('lblUserCreated'); ?></label>
			<span class="left"><?php echo date($tpl['option_arr']['o_date_format'], strtotime($tpl['arr']['created'])); ?>, <?php echo date("H:i", strtotime($tpl['arr']['created'])); ?></span>
		</p>
		<p>
			<label class="title"><?php __('lblIp'); ?></label>
			<span class="left"><?php echo $tpl['arr']['ip']; ?></span>
		</p>
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
		</p>
	</form>
	
	<script type="text/javascript">
	var myLabel = myLabel || {};
	myLabel.email_taken = "<?php __('vr_email_taken', false, true); ?>";
	</script>
	<?php
}
?>