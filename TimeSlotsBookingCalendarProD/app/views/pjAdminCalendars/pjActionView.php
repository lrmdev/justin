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
	if (isset($_GET['err']))
	{
		$titles = __('error_titles', true);
		$bodies = __('error_bodies', true);
		pjUtil::printNotice(@$titles[$_GET['err']], @$bodies[$_GET['err']]);
	}
	$cid = $controller->getForeignId();
	?>
	<style type="text/css">
	#tsWrapper{
		float: left;
		width: 380px;
	}
	#tsContainer_<?php echo $cid; ?> .tsCalendarDateInner{
		padding: 13px 0;
	}
	#tsContainer_<?php echo $cid; ?> .tsContainerCalendar{
		height: 340px;
	}
	#tsContainer_<?php echo $cid; ?> .tsCalendarMonthInner{
		height: 100%;
	}
	</style>
	<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionIndex"><?php __('menuCalendars'); ?></a></li>
			<li class="ui-state-default ui-corner-top"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionCreate"><?php __('calendar_create'); ?></a></li>
			<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminCalendars&amp;action=pjActionView"><?php __('calendar_view'); ?></a></li>
		</ul>
	</div>
	
	<div id="tsWrapper">
		<div id="tsContainer_<?php echo $cid; ?>" class="tsContainer">
			<div id="tsContainerCalendar_<?php echo $cid; ?>" class="tsContainerCalendar"></div>
		</div>
	</div>
	
	<div id="gridReservations" class="float_right w350 pj-grid"></div>
	<div class="clear_both"></div>
	
	<div id="dialogTimeslotDelete" title="<?php __('cal_del_ts_title', false, true); ?>" style="display:none"><?php __('cal_del_ts_body'); ?></div>
	<div id="dialogBookingDelete" title="<?php __('cal_del_title', false, true); ?>" style="display:none"><?php __('cal_del_body'); ?></div>
	<?php
}
?>