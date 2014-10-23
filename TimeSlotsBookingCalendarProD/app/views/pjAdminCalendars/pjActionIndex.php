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
	?>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionIndex"><?php __('menuCalendars'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionCreate"><?php __('calendar_create'); ?></a></li>
		</ul>
	</div>

	<?php pjUtil::printNotice(@$titles['AC10'], @$bodies['AC10']); ?>
	
	<div class="b10">
		<form action="" method="get" class="pj-form frm-filter">
			<input type="text" name="q" class="pj-form-field pj-form-field-search w150" placeholder="<?php __('btnSearch', false, true); ?>" />
		</form>
	</div>

	<div id="grid"></div>
	<script type="text/javascript">
	var pjGrid = pjGrid || {};
	pjGrid.currentCalendarId = <?php echo (int) $controller->getForeignId(); ?>;
	var myLabel = myLabel || {};
	myLabel.title = "<?php __('calendar_title', false, true); ?>";
	myLabel.name = "<?php __('lblName', false, true); ?>";
	myLabel.email = "<?php __('email', false, true); ?>";
	myLabel.delete_selected = "<?php __('delete_selected', false, true); ?>";
	myLabel.delete_confirmation = "<?php __('delete_confirmation', false, true); ?>";
	</script>
	<?php
}
?>