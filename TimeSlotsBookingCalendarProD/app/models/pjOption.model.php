<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjOptionModel extends pjAppModel
{
	protected $primaryKey = NULL;
	
	protected $table = 'options';
	
	protected $schema = array(
		array('name' => 'foreign_id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'key', 'type' => 'varchar', 'default' => ':NULL'),
		array('name' => 'tab_id', 'type' => 'tinyint', 'default' => ':NULL'),
		array('name' => 'value', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'label', 'type' => 'text', 'default' => ':NULL'),
		array('name' => 'type', 'type' => 'varchar', 'default' => 'string'),
		array('name' => 'order', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'is_visible', 'type' => 'tinyint', 'default' => 1),
		array('name' => 'style', 'type' => 'varchar', 'default' => 'string')
	);
	
	public static function factory($attr=array())
	{
		return new pjOptionModel($attr);
	}
	
	public function getAllPairs($foreign_id)
	{
		return $this->where('t1.foreign_id', $foreign_id)->findAll()->getDataPair('key', 'value');
	}
	
	public function getPairs($foreign_id)
	{
		$_arr = $this->where('t1.foreign_id', $foreign_id)->findAll()->getData();
		$arr = array();
		foreach ($_arr as $row)
		{
			switch ($row['type'])
			{
				case 'enum':
				case 'bool':
					list(, $arr[$row['key']]) = explode("::", $row['value']);
					break;
				default:
					$arr[$row['key']] = $row['value'];
					break;
			}
		}
		return $arr;
	}

	public function init($foreign_id)
	{
		$records = array(
			array($foreign_id, 'o_allow_authorize', 7, '1|0::1', NULL, 'bool', 18, 1, NULL),
			array($foreign_id, 'o_allow_bank', 7, '1|0::1', NULL, 'bool', 24, 1, NULL),
			array($foreign_id, 'o_allow_creditcard', 7, '1|0::1', NULL, 'bool', 23, 1, NULL),
			array($foreign_id, 'o_allow_paypal', 7, '1|0::1', NULL, 'bool', 16, 1, NULL),
			array($foreign_id, 'o_authorize_hash', 7, NULL, NULL, 'string', 21, 1, NULL),
			array($foreign_id, 'o_authorize_key', 7, NULL, NULL, 'string', 20, 1, NULL),
			array($foreign_id, 'o_authorize_mid', 7, NULL, NULL, 'string', 19, 1, NULL),
			array($foreign_id, 'o_authorize_tz', 7, '-43200|-39600|-36000|-32400|-28800|-25200|-21600|-18000|-14400|-10800|-7200|-3600|0|3600|7200|10800|14400|18000|21600|25200|28800|32400|36000|39600|43200|46800::0', 'GMT-12:00|GMT-11:00|GMT-10:00|GMT-09:00|GMT-08:00|GMT-07:00|GMT-06:00|GMT-05:00|GMT-04:00|GMT-03:00|GMT-02:00|GMT-01:00|GMT|GMT+01:00|GMT+02:00|GMT+03:00|GMT+04:00|GMT+05:00|GMT+06:00|GMT+07:00|GMT+08:00|GMT+09:00|GMT+10:00|GMT+11:00|GMT+12:00|GMT+13:00', 'enum', 22, 1, NULL),
			array($foreign_id, 'o_bank_account', 7, 'Bank of America', NULL, 'text', 25, 1, NULL),
			array($foreign_id, 'o_bf_address_1', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 9, 1, NULL),
			array($foreign_id, 'o_bf_address_2', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 10, 1, NULL),
			array($foreign_id, 'o_bf_captcha', 4, '1|3::3', 'No|Yes (Required)', 'enum', 11, 1, NULL),
			array($foreign_id, 'o_bf_city', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 7, 1, NULL),
			array($foreign_id, 'o_bf_country', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 5, 1, NULL),
			array($foreign_id, 'o_bf_email', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 2, 1, NULL),
			array($foreign_id, 'o_bf_name', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 1, 1, NULL),
			array($foreign_id, 'o_bf_notes', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 4, 1, NULL),
			array($foreign_id, 'o_bf_phone', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 3, 1, NULL),
			array($foreign_id, 'o_bf_state', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 6, 1, NULL),
			array($foreign_id, 'o_bf_terms', 4, '1|3::3', 'No|Yes (Required)', 'enum', 12, 1, NULL),
			array($foreign_id, 'o_bf_zip', 4, '1|2|3::3', 'No|Yes|Yes (Required)', 'enum', 8, 1, NULL),
			array($foreign_id, 'o_currency', 1, 'AED|AFN|ALL|AMD|ANG|AOA|ARS|AUD|AWG|AZN|BAM|BBD|BDT|BGN|BHD|BIF|BMD|BND|BOB|BOV|BRL|BSD|BTN|BWP|BYR|BZD|CAD|CDF|CHE|CHF|CHW|CLF|CLP|CNY|COP|COU|CRC|CUC|CUP|CVE|CZK|DJF|DKK|DOP|DZD|EEK|EGP|ERN|ETB|EUR|FJD|FKP|GBP|GEL|GHS|GIP|GMD|GNF|GTQ|GYD|HKD|HNL|HRK|HTG|HUF|IDR|ILS|INR|IQD|IRR|ISK|JMD|JOD|JPY|KES|KGS|KHR|KMF|KPW|KRW|KWD|KYD|KZT|LAK|LBP|LKR|LRD|LSL|LTL|LVL|LYD|MAD|MDL|MGA|MKD|MMK|MNT|MOP|MRO|MUR|MVR|MWK|MXN|MXV|MYR|MZN|NAD|NGN|NIO|NOK|NPR|NZD|OMR|PAB|PEN|PGK|PHP|PKR|PLN|PYG|QAR|RON|RSD|RUB|RWF|SAR|SBD|SCR|SDG|SEK|SGD|SHP|SLL|SOS|SRD|STD|SYP|SZL|THB|TJS|TMT|TND|TOP|TRY|TTD|TWD|TZS|UAH|UGX|USD|USN|USS|UYU|UZS|VEF|VND|VUV|WST|XAF|XAG|XAU|XBA|XBB|XBC|XBD|XCD|XDR|XFU|XOF|XPD|XPF|XPT|XTS|XXX|YER|ZAR|ZMK|ZWL::EUR', NULL, 'enum', 3, 1, NULL),
			array($foreign_id, 'o_datetime_format', 1, 'd.m.Y, H:i|d.m.Y, H:i:s|m.d.Y, H:i|m.d.Y, H:i:s|Y.m.d, H:i|Y.m.d, H:i:s|j.n.Y, H:i|j.n.Y, H:i:s|n.j.Y, H:i|n.j.Y, H:i:s|Y.n.j, H:i|Y.n.j, H:i:s|d/m/Y, H:i|d/m/Y, H:i:s|m/d/Y, H:i|m/d/Y, H:i:s|Y/m/d, H:i|Y/m/d, H:i:s|j/n/Y, H:i|j/n/Y, H:i:s|n/j/Y, H:i|n/j/Y, H:i:s|Y/n/j, H:i|Y/n/j, H:i:s|d-m-Y, H:i|d-m-Y, H:i:s|m-d-Y, H:i|m-d-Y, H:i:s|Y-m-d, H:i|Y-m-d, H:i:s|j-n-Y, H:i|j-n-Y, H:i:s|n-j-Y, H:i|n-j-Y, H:i:s|Y-n-j, H:i|Y-n-j, H:i:s::j/n/Y, H:i', 'd.m.Y, H:i (25.09.2010, 09:51)|d.m.Y, H:i:s (25.09.2010, 09:51:47)|m.d.Y, H:i (09.25.2010, 09:51)|m.d.Y, H:i:s (09.25.2010, 09:51:47)|Y.m.d, H:i (2010.09.25, 09:51)|Y.m.d, H:i:s (2010.09.25, 09:51:47)|j.n.Y, H:i (25.9.2010, 09:51)|j.n.Y, H:i:s (25.9.2010, 09:51:47)|n.j.Y, H:i (9.25.2010, 09:51)|n.j.Y, H:i:s (9.25.2010, 09:51:47)|Y.n.j, H:i (2010.9.25, 09:51)|Y.n.j, H:i:s (2010.9.25, 09:51:47)|d/m/Y, H:i (25/09/2010, 09:51)|d/m/Y, H:i:s (25/09/2010, 09:51:47)|m/d/Y, H:i (09/25/2010, 09:51)|m/d/Y, H:i:s (09/25/2010, 09:51:47)|Y/m/d, H:i (2010/09/25, 09:51)|Y/m/d, H:i:s (2010/09/25, 09:51:47)|j/n/Y, H:i (25/9/2010, 09:51)|j/n/Y, H:i:s (25/9/2010, 09:51:47)|n/j/Y, H:i (9/25/2010, 09:51)|n/j/Y, H:i:s (9/25/2010, 09:51:47)|Y/n/j, H:i (2010/9/25, 09:51)|Y/n/j, H:i:s (2010/9/25, 09:51:47)|d-m-Y, H:i (25-09-2010, 09:51)|d-m-Y, H:i:s (25-09-2010, 09:51:47)|m-d-Y, H:i (09-25-2010, 09:51)|m-d-Y, H:i:s (09-25-2010, 09:51:47)|Y-m-d, H:i (2010-09-25, 09:51)|Y-m-d, H:i:s (2010-09-25, 09:51:47)|j-n-Y, H:i (25-9-2010, 09:51)|j-n-Y, H:i:s (25-9-2010, 09:51:47)|n-j-Y, H:i (9-25-2010, 09:51)|n-j-Y, H:i:s (9-25-2010, 09:51:47)|Y-n-j, H:i (2010-9-25, 09:51)|Y-n-j, H:i:s (2010-9-25, 09:51:47)', 'enum', 8, 1, NULL),
			array($foreign_id, 'o_date_format', 1, 'd.m.Y|m.d.Y|Y.m.d|j.n.Y|n.j.Y|Y.n.j|d/m/Y|m/d/Y|Y/m/d|j/n/Y|n/j/Y|Y/n/j|d-m-Y|m-d-Y|Y-m-d|j-n-Y|n-j-Y|Y-n-j::d/m/Y', 'd.m.Y (25.09.2012)|m.d.Y (09.25.2012)|Y.m.d (2012.09.25)|j.n.Y (25.9.2012)|n.j.Y (9.25.2012)|Y.n.j (2012.9.25)|d/m/Y (25/09/2012)|m/d/Y (09/25/2012)|Y/m/d (2012/09/25)|j/n/Y (25/9/2012)|n/j/Y (9/25/2012)|Y/n/j (2012/9/25)|d-m-Y (25-09-2012)|m-d-Y (09-25-2012)|Y-m-d (2012-09-25)|j-n-Y (25-9-2012)|n-j-Y (9-25-2012)|Y-n-j (2012-9-25)', 'enum', 8, 1, NULL),
			array($foreign_id, 'o_deposit', 7, '20', NULL, 'float', 12, 1, NULL),
			array($foreign_id, 'o_deposit_type', 7, 'amount|percent::percent', 'Amount|Percent', 'enum', NULL, 0, NULL),
			array($foreign_id, 'o_disable_payments', 7, '1|0::0', NULL, 'bool', 4, 1, NULL),
			array($foreign_id, 'o_hide_prices', 3, '1|0::0', NULL, 'bool', 2, 1, NULL),
			array($foreign_id, 'o_hours_before', 3, '0', NULL, 'int', 11, 1, NULL),
			array($foreign_id, 'o_layout', 1, '1|2::1', 'Default layout|Weekly layout', 'enum', 1, 1, NULL),
			array($foreign_id, 'o_multi_lang', 99, '1|0::0', NULL, 'enum', NULL, 0, NULL),
			array($foreign_id, 'o_paypal_address', 7, 'paypal_seller@example.com', NULL, 'string', 17, 1, NULL),
			array($foreign_id, 'o_reminder_email_before', 8, '2', NULL, 'int', 2, 1, NULL),
			array($foreign_id, 'o_reminder_enable', 8, '1|0::1', NULL, 'bool', 1, 1, NULL),
			array($foreign_id, 'o_reminder_sms_hours', 8, '1', NULL, 'int', 5, 1, NULL),
			array($foreign_id, 'o_send_email', 1, 'mail|smtp::mail', 'PHP mail()|SMTP', 'enum', 11, 1, NULL),
			array($foreign_id, 'o_show_legend', 3, '1|0::1', NULL, 'bool', 3, 1, NULL),
			array($foreign_id, 'o_show_week_numbers', 3, '1|0::0', NULL, 'bool', 5, 1, NULL),
			array($foreign_id, 'o_smtp_host', 1, NULL, NULL, 'string', 12, 1, NULL),
			array($foreign_id, 'o_smtp_pass', 1, NULL, NULL, 'string', 15, 1, NULL),
			array($foreign_id, 'o_smtp_port', 1, '25', NULL, 'int', 13, 1, NULL),
			array($foreign_id, 'o_smtp_user', 1, NULL, NULL, 'string', 14, 1, NULL),
			array($foreign_id, 'o_from_email', 1, 'admin@admin.com', NULL, 'string', 14, 1, NULL),
			array($foreign_id, 'o_status_if_not_paid', 3, 'confirmed|pending::pending', 'Confirmed|Pending', 'enum', 10, 1, NULL),
			array($foreign_id, 'o_status_if_paid', 3, 'confirmed|pending::confirmed', 'Confirmed|Pending', 'enum', 9, 1, NULL),
			array($foreign_id, 'o_tax', 7, '10', NULL, 'float', 14, 1, NULL),
			array($foreign_id, 'o_thankyou_page', 7, 'http://www.phpjabbers.com/', NULL, 'string', 26, 1, NULL),
			array($foreign_id, 'o_timezone', 1, '-43200|-39600|-36000|-32400|-28800|-25200|-21600|-18000|-14400|-10800|-7200|-3600|0|3600|7200|10800|14400|18000|21600|25200|28800|32400|36000|39600|43200|46800::0', 'GMT-12:00|GMT-11:00|GMT-10:00|GMT-09:00|GMT-08:00|GMT-07:00|GMT-06:00|GMT-05:00|GMT-04:00|GMT-03:00|GMT-02:00|GMT-01:00|GMT|GMT+01:00|GMT+02:00|GMT+03:00|GMT+04:00|GMT+05:00|GMT+06:00|GMT+07:00|GMT+08:00|GMT+09:00|GMT+10:00|GMT+11:00|GMT+12:00|GMT+13:00', 'enum', 10, 1, NULL),
			array($foreign_id, 'o_time_format', 1, 'H:i|G:i|h:i|h:i a|h:i A|g:i|g:i a|g:i A::H:i', 'H:i (09:45)|G:i (9:45)|h:i (09:45)|h:i a (09:45 am)|h:i A (09:45 AM)|g:i (9:45)|g:i a (9:45 am)|g:i A (9:45 AM)', 'enum', 7, 1, NULL),
			array($foreign_id, 'o_week_start', 1, '0|1|2|3|4|5|6::1', 'Sunday|Monday|Tuesday|Wednesday|Thursday|Friday|Saturday', 'enum', 9, 1, NULL)
		);

		$this->setBatchFields(array('foreign_id', 'key', 'tab_id', 'value', 'label', 'type', 'order', 'is_visible', 'style'));
		foreach ($records as $record)
		{
			$this->addBatchRow($record);
		}
		$this->insertBatch();
					
		return $this;
	}
}
?>