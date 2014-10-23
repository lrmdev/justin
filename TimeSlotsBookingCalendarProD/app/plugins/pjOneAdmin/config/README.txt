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
	$CONFIG['plugins'] = array('pjOneAdmin', 'pjAdminBackup');
	//-- OR -- 
	$CONFIG['plugins'] = 'pjOneAdmin';
	?>


3. How to access a plugin
-----------------------------------------------
	(not applicable)
	

4. How to use a plugin accross the script
-----------------------------------------------
	4.1 Into controllers
				
		(not applicable)
			
	4.2 Into views
	
	<?php
	# app/views/Layouts/elements/leftmenu.php
	$controller->requestAction(array('controller' => 'pjOneAdmin', 'action' => 'menu'));
	?>			