<?php
$active = " ui-tabs-active ui-state-active";
?>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all b10">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
		<?php
		if ($controller->isAdmin())
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || $_GET['tab'] != '1' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=1"><?php __('menuGeneral'); ?></a></li><?php
		}
		if ($controller->isAdmin())
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjAdminOptions' || !in_array($_GET['tab'], array(3,4,5,6,7,8)) ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjAdminOptions&amp;tab=3"><?php __('menuBookings'); ?></a></li><?php
		}
		if ($controller->isAdmin() && pjObject::getPlugin('pjLocale') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjLocale' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjLocale&amp;action=pjActionIndex"><?php __('menuLocales'); ?></a></li><?php
		}
		if ($controller->isAdmin() && pjObject::getPlugin('pjCountry') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjCountry' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjCountry&amp;action=pjActionIndex"><?php __('plugin_country_menu_countries'); ?></a></li><?php
		}
		if ($controller->isAdmin() && pjObject::getPlugin('pjBackup') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjBackup' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjBackup&amp;action=pjActionIndex"><?php __('menuBackup'); ?></a></li><?php
		}
		if (pjObject::getPlugin('pjInvoice') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjInvoice' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjInvoice&amp;action=pjActionIndex"><?php __('plugin_invoice_menu_invoices'); ?></a></li><?php
		}
		if ($controller->isAdmin() && pjObject::getPlugin('pjSms') !== NULL)
		{
			?><li class="ui-state-default ui-corner-top<?php echo $_GET['controller'] != 'pjSms' ? NULL : $active; ?>"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?controller=pjSms&amp;action=pjActionIndex"><?php __('plugin_sms_menu_sms'); ?></a></li><?php
		}
		?>
	</ul>
</div>