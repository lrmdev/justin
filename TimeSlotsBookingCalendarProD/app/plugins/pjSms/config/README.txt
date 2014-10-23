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
	$CONFIG['plugins'] = array('pjPaypal', 'pjSms');
	//-- OR -- 
	$CONFIG['plugins'] = 'pjSms';
	?>


3. How to access a plugin.
-----------------------------------------------
	For example:
	index.php?controller=pjSms&action=pjActionIndex
	
	Add above url as hyperlink to the menu if you need to.
	

4. How to use a plugin accross the script
-----------------------------------------------
	4.1 Into controllers
		
		- Using the plugin model
		
			pjObject::import('Model', 'pjSms:pjSms');
			$data = pjSms::factory()->findAll()->getData();
			
		- Calling plugin's action (Send SMS)
		
			$params = array(
				'number' => '...', //359889452812
				'text' => '...' //test message
			);
			$response = $this->requestAction(array('controller' => 'pjSms', 'action' => 'pjActionSend', 'params' => $params), array('return'));
			
			//echo $response;
			//0 - Account limit reached
			//1 - Message sent
			//2 - Message not sent
			//3 - Account not confirmed.
			//4 - Incorrect API key.