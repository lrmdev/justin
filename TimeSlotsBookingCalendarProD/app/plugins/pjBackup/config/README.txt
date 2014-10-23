1. How to install a plugin
-----------------------------------------------
	1.1 Before script installation
		- Copy the plugin folder and paste it into 'app/plugins/'
		- Do the same for all the plugins you need, then install the script
	
	1.2 After script installation
		- Copy the plugin folder and paste it into 'app/plugins/'
		- Manually run the plugin *.sql file(s), located in 'app/plugins/PLUGIN_NAME/config/'


2. How to enable a plugin
-----------------------------------------------
	Add plugin name to $CONFIG['plugins'] array into 'app/config/config.inc.php' and 'app/config/config.sample.php'
	For example: 
	<?php
	$CONFIG['plugins'] = array('pjGallery', 'pjBackup');
	//-- OR -- 
	$CONFIG['plugins'] = 'pjBackup';
	?>


3. How to access the plugin
-----------------------------------------------
	For example:
	index.php?controller=pjBackup
	index.php?controller=PLUGIN_NAME&action=SOME_ACTION
	
	Add above url as hyperlink to the menu 