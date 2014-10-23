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
	$CONFIG['plugins'] = array('pjPaypal', 'pjAdminBackup');
	//-- OR -- 
	$CONFIG['plugins'] = 'pjPaypal';
	?>


3. How to access a plugin.
-----------------------------------------------
	For example:
	index.php?controller=PLUGIN_NAME&action=SOME_ACTION
	
	Add above url as hyperlink to the menu if you need to.
	

4. How to use a plugin accross the script
-----------------------------------------------
	4.1 Into controllers
		
		- Using the plugin model
		
			(not applicable)

		- Using the plugin resources
		
			(not applicable)
			
		- Calling plugin's action
		
			// Confirm payment
			$params = array(
				'txn_id' => '...', //293487347
				'paypal_address' => '...', //test@mailbox.com
				'deposit' => '...', //10.00
				'currency' => '...' //USD
			);
			$response = $this->requestAction(array('controller' => 'pjPaypal', 'action' => 'confirm', 'params' => $params), array('return'));
			
		- Other
			
			//Build data for Paypal form
			$this->set('params', array(
				'name' => 'vrPaypal',
				'id' => 'vrPaypal',
				'business' => $booking_arr['o_paypal_address'],
				'item_name' => 'Vacation Rental',
				'custom' => $booking_arr['id'],
				'amount' => $booking_arr['deposit'],
				'currency_code' => $this->option_arr['currency'],
				'return' => $booking_arr['o_thankyou_page'],
				'notify_url' => PJ_INSTALL_URL . 'index.php?controller=pjListings&action=confirmPaypal'
			));
			
	4.2 Into presentation layer (views)
		
		// Next code display Paypal form
		
		$controller->requestAction(array(
			'controller' => 'pjPaypal', 
			'action' => 'form', 
			'params' => $tpl['params']
		));
		