<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once dirname(__FILE__) . '/pjAuthorizeAppController.controller.php';
class pjAuthorize extends pjAuthorizeAppController
{
	public function pjActionConfirm()
	{
		$params = $this->getParams();
		if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT))
		{
			return FALSE;
		}
		
		$resp = array();
		
		if (isset($params['x_login']) && isset($params['transkey']) && isset($params['md5_setting']) &&
			!empty($params['x_login']) && !empty($params['transkey']))
		{
			define("AUTHORIZENET_API_LOGIN_ID", $params['x_login']);
			define("AUTHORIZENET_TRANSACTION_KEY", $params['transkey']);
			define("AUTHORIZENET_SANDBOX", PJ_TEST_MODE);
			define("TEST_REQUEST", PJ_TEST_MODE);
		
			require_once $this->getConst('PLUGIN_DIR') . 'anet_php_sdk/AuthorizeNet.php';
			$response = new AuthorizeNetSIM($params['x_login'], $params['md5_setting']);
			
	    	if ($response->isAuthorizeNet())
	    	{
	        	if ($response->approved)
	        	{
					// Transaction approved!
					$resp['transaction_id'] = $_POST['x_invoice_num'];
					$resp['status'] = 'OK';
				} else {
					// There was a problem.
					$resp['response_reason_code'] = $response->response_reason_code;
					$resp['response_code'] = $response->response_code;
					$resp['response_reason_text'] = $response->response_reason_text;
					$resp['status'] = 'FAIL';
				}
			} else {
				$resp['response_reason_text'] = "MD5 Hash failed";
				$resp['status'] = 'FAIL';
			}
		} else {
			$resp['response_reason_text'] = "Missing or empty parameters";
			$resp['status'] = 'FAIL';
		}

		return $resp;
	}
	
	public function pjActionForm()
	{
		$this->setAjax(true);
		//KEYS:
		//-------------
		//name
		//id
		//timezone
		//transkey
		//x_login
		//x_description
		//x_amount
		//x_invoice_num
		//x_receipt_link_url
		//x_relay_url
		//submit
		//submit_class
		//target
		$this->set('arr', $this->getParams());
	}
}
?>