<?php $active = " ui-tabs-active ui-state-active"; ?>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '3' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=3"><?php __('menuOptions'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '7' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=7"><?php __('menuPayments'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '4' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=4"><?php __('menuBookingForm'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '5' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=5"><?php __('menuNotifications'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '6' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=6"><?php __('menuTerms'); ?></a></li>
		<li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '8' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=8"><?php __('menuReminder'); ?></a></li>
	</ul>
</div>