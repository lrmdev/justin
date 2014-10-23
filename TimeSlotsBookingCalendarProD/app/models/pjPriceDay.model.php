<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjPriceDayModel extends pjAppModel
{
	protected $primaryKey = 'id';

	protected $table = 'prices_days';

	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'day', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'start_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'end_time', 'type' => 'time', 'default' => ':NULL'),
		array('name' => 'price', 'type' => 'decimal', 'default' => ':NULL')
	);
	
	public static function factory($attr=array())
	{
		return new pjPriceDayModel($attr);
	}
}
?>