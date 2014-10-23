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
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionIndex"><?php __('menuCalendars'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionCreate"><?php __('calendar_create'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionUpdate&amp;id=<?php echo $tpl['arr']['id']; ?>"><?php __('calendar_update'); ?></a></li>
		</ul>
	</div>
	<?php pjUtil::printNotice(@$titles['AC12'], @$bodies['AC12']); ?>
	
	<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
	<div class="multilang"></div>
	<?php endif; ?>
	
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionUpdate" method="post" id="frmUpdateCalendar" class="form pj-form">
		<input type="hidden" name="calendar_update" value="1" />
		<input type="hidden" name="id" value="<?php echo (int) $tpl['arr']['id']; ?>" />
		<p>
			<label class="title"><?php __('calendar_user'); ?></label>
			<span class="inline_block">
				<select name="user_id" id="user_id" class="pj-form-field required">
					<option value="">-- <?php __('lblChoose'); ?>--</option>
					<?php
					if (isset($tpl['user_arr']))
					{
						foreach ($tpl['user_arr'] as $user)
						{
							?><option value="<?php echo $user['id']; ?>"<?php echo $tpl['arr']['user_id'] == $user['id'] ? ' selected="selected"' : NULL; ?>><?php echo pjSanitize::html($user['name']); ?></option><?php
						}
					}
					?>
				</select>
			</span>
		</p>
		<?php
		foreach ($tpl['lp_arr'] as $v)
		{
		?>
			<p class="pj-multilang-wrap" data-index="<?php echo $v['id']; ?>" style="display: <?php echo (int) $v['is_default'] === 0 ? 'none' : NULL; ?>">
				<label class="title"><?php __('calendar_title'); ?>:</label>
				<span class="inline_block">
					<input type="text" name="i18n[<?php echo $v['id']; ?>][title]" class="pj-form-field w300<?php echo (int) $v['is_default'] === 0 ? NULL : ' required'; ?>" value="<?php echo pjSanitize::html(@$tpl['arr']['i18n'][$v['id']]['title']); ?>" />
					<?php if ((int) $tpl['option_arr']['o_multi_lang'] === 1) : ?>
					<span class="pj-multilang-input"><img src="<?php echo PJ_INSTALL_URL . PJ_FRAMEWORK_LIBS_PATH . 'pj/img/flags/' . $v['file']; ?>" alt="" /></span>
					<?php endif; ?>
				</span>
			</p>
			<?php
		}
		?>
		<p>
			<label class="title">&nbsp;</label>
			<input type="submit" value="<?php __('btnSave', false, true); ?>" class="pj-button" />
		</p>
	</form>
	<?php
}
?>