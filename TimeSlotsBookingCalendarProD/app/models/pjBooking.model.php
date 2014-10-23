<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjBookingModel extends pjAppModel
{
	protected $primaryKey = 'id';

	protected $table = 'bookings';

	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'uuid', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'calendar_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'locale_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'booking_price', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'booking_total', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'booking_deposit', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'booking_tax', 'type' => 'decimal', 'default' => ':NULL'),
		array('name' => 'booking_status', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'payment_method', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'payment_option', 'type' => 'enum', 'default' => ':NULL'),
		array('name' => 'customer_name', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_email', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_phone', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_country', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'customer_state', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_city', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_address_1', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_address_2', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_zip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'customer_notes', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'cc_type', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'cc_num', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'cc_exp_month', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'cc_exp_year', 'type' => 'year', 'default' => ':NULL'),
		array('name' => 'cc_code', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'txn_id', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'processed_on', 'type' => 'datetime', 'default' => ':NULL'),
		array('name' => 'reminder_email', 'type' => 'tinyint', 'default' => 0),
		array('name' => 'reminder_sms', 'type' => 'tinyint', 'default' => 0),
		array('name' => 'ip', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'created', 'type' => 'datetime', 'default' => ':NOW()')
	);
	
	public static function factory($attr=array())
	{
		return new pjBookingModel($attr);
	}
}
?>