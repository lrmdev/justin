<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once dirname(__FILE__) . '/pjInstallerAppController.controller.php';
class pjLayouts extends pjInstallerAppController
{
	public function pjActionInstall(){}
}
?>