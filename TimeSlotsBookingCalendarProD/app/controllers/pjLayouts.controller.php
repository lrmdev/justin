<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once PJ_CONTROLLERS_PATH . 'pjAppController.controller.php';
class pjLayouts extends pjAppController
{
	public function pjActionAdminLogin(){}
	
	public function pjActionAdmin(){}
	
	public function pjActionCancel(){}

	public function pjActionEmpty(){}
	
	public function pjActionFront(){}
	
	public function pjActionIframe(){}
	
	public function pjActionPrint(){}
}
?>