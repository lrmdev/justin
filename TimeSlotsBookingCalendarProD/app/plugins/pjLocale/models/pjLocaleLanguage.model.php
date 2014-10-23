<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once dirname(__FILE__) . '/pjLocaleApp.model.php';
class pjLocaleLanguageModel extends pjLocaleAppModel
{
	protected $primaryKey = 'iso';
	
	protected $table = 'plugin_locale_languages';
	
	protected $schema = array(
		array('name' => 'iso', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'title', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'file', 'type' => 'varchar', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new pjLocaleLanguageModel($attr);
	}
}
?>