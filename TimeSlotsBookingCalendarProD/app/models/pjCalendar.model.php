<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjCalendarModel extends pjAppModel
{
	protected $primaryKey = 'id';
	
	protected $table = 'calendars';
	
	protected $schema = array(
		array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
		array('name' => 'user_id', 'type' => 'int', 'default' => ':NULL')
	);
	
	protected $i18n = array(
		'title', 'terms_url', 'terms_body',
		'confirm_subject_client', 'confirm_tokens_client', 'payment_subject_client', 'payment_tokens_client',
		'confirm_subject_admin', 'confirm_tokens_admin', 'payment_subject_admin', 'payment_tokens_admin',
		'reminder_subject_client', 'reminder_tokens_client',
		'confirm_sms_admin', 'payment_sms_admin', 'reminder_sms_client'
	);
	
	protected $validate = array(
		'rules' => array(
			'user_id' => array(
				'pjActionNumeric' => true,
				'pjActionRequired' => true
			)
		)
	);
	
	public static function factory($attr=array())
	{
		return new pjCalendarModel($attr);
	}
	
	public function init($user_id, $locale)
	{
		$calendar_id = $this->setAttributes(array(
			'user_id' => $user_id
		))->insert()->getInsertId();
		
		if ($calendar_id !== FALSE && (int) $calendar_id > 0)
		{
			$records = array(
				array($calendar_id, 'pjCalendar', $locale, 'title', 'Calendar 1', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'terms_url', 'http://www.google.com/', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'terms_body', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque consectetur sollicitudin mi. Cras scelerisque lorem non nunc iaculis lacinia id nec mauris. Nunc suscipit tincidunt velit, et gravida enim blandit nec. Cras pellentesque blandit interdum. Ut porttitor risus felis. Donec vestibulum risus neque, in auctor tortor tincidunt at. Suspendisse varius metus dui, at consectetur turpis lobortis sit amet. Donec eget accumsan sapien. Proin posuere nibh et bibendum consectetur. Integer imperdiet nibh est.', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'confirm_subject_client', 'Client confirmation email', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'confirm_tokens_client', 'Confirmation email
---------------------------
{Name} - Customer name;
{Phone} - Customer phone number;
{Email} - Customer e-mail address;
{BookingID} - Booking ID;

{Price} - Price for selected slots;
{Deposit} - Deposit amount;
{Tax} - Tax amount;
{Total} - Total amount;', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'payment_subject_client', 'Client payment email', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'payment_tokens_client', 'Payment email
---------------------------
{Name} - Customer name;
{Phone} - Customer phone number;
{Email} - Customer e-mail address;
{BookingID} - Booking ID;

{Price} - Price for selected slots;
{Deposit} - Deposit amount;
{Tax} - Tax amount;
{Total} - Total amount;', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'confirm_subject_admin', 'Admin confirmation email', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'confirm_tokens_admin', 'Confirmation email
---------------------------
{Name} - Customer name;
{Phone} - Customer phone number;
{Email} - Customer e-mail address;
{BookingID} - Booking ID;

{Price} - Price for selected slots;
{Deposit} - Deposit amount;
{Tax} - Tax amount;
{Total} - Total amount;', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'payment_subject_admin', 'Admin payment email', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'payment_tokens_admin', 'Payment email
---------------------------
{Name} - Customer name;
{Phone} - Customer phone number;
{Email} - Customer e-mail address;
{BookingID} - Booking ID;

{Price} - Price for selected slots;
{Deposit} - Deposit amount;
{Tax} - Tax amount;
{Total} - Total amount;', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'reminder_subject_client', 'Booking Reminder', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'reminder_tokens_client', '{Name} - Customer name;
{Phone} - Customer phone number;
{Email} - Customer e-mail address;
{BookingID} - Booking ID;

{Price} - Price for selected slots;
{Deposit} - Deposit amount;
{Tax} - Tax amount;
{Total} - Total amount;', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'confirm_sms_admin', 'Booking received', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'payment_sms_admin', 'Payment received', 'data'),
				array($calendar_id, 'pjCalendar', $locale, 'reminder_sms_client', '{Name}, your booking is coming.', 'data')
			);
		
			$pjMultiLangModel = pjMultiLangModel::factory();
			$pjMultiLangModel->setBatchFields(array('foreign_id', 'model', 'locale', 'field', 'content', 'source'));
			foreach ($records as $record)
			{
				$pjMultiLangModel->addBatchRow($record);
			}
			$pjMultiLangModel->insertBatch();
		}
		
		return $calendar_id;
	}
}
?>