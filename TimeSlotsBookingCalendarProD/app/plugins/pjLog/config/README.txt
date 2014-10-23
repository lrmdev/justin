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
	$CONFIG['plugins'] = array('pjLog', 'pjAdminBackup');
	//-- OR -- 
	$CONFIG['plugins'] = 'pjLog';
	?>


3. How to access a plugin
-----------------------------------------------
	For example:
	index.php?controller=pjLog
	index.php?controller=PLUGIN_NAME&action=SOME_ACTION
	
	Add above url as hyperlink to the menu if you need to.
	

4. How to use a plugin accross the script
-----------------------------------------------
	4.1 Setup the plugin (Required)
		
		index.php?controller=pjLog&action=config
		
	4.1 Into controllers
		
		- Using the plugin model:
		
			pjObject::import('Model', 'pjLog:pjLog');
			$data = pjLog::factory()->findAll()->getData();

		- Calling the main action:
			
			$this->log('test 1');
			
	4.2 Into views
	
		$controller->log('test', 'custom', 'index', 'app/controllers/pjAdminExtras.controller.php');
		
5. Note

	$this->log('test') is just a wrapper for next one:

	$this->requestAction(
		array(
    		'controller' => 'pjLog',
    		'action' => 'logger',
    		'params' => array('value' => 'test')
		),
		array('return')
	);
			