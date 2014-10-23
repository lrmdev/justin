<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once PJ_CONTROLLERS_PATH . 'pjAppController.controller.php';
class pjCron extends pjAppController
{
	public function pjActionIndex()
	{
		$this->setLayout('pjActionEmpty');
		
		$pjOptionModel = pjOptionModel::factory();
		$pjBookingModel = pjBookingModel::factory();
		$pjBookingSlotModel = pjBookingSlotModel::factory();
		$pjEmail = new pjEmail();
		$pjEmail->setContentType('text/html');
		
		$isSms = (pjObject::getPlugin('pjSms') !== NULL);
		$priv_key = md5($this->option_arr['private_key'] . PJ_SALT);
		
		$calendar_arr = pjCalendarModel::factory()
			->select('t1.*, t2.email')
			->join('pjUser', 't2.id=t1.user_id', 'left outer')
			->findAll()
			->getData();
		foreach ($calendar_arr as $calendar)
		{
			$this->option_arr = $pjOptionModel->reset()->getPairs($calendar['id']);
			if ((int) $this->option_arr['o_reminder_enable'] === 0)
			{
				continue;
			}
			# Set time ----------------------------------------------
			pjAppController::setTime();

			# Emails
			if ($this->option_arr['o_send_email'] == 'smtp')
			{
				$pjEmail
					->setTransport('smtp')
					->setSmtpHost($this->option_arr['o_smtp_host'])
					->setSmtpPort($this->option_arr['o_smtp_port'])
					->setSmtpUser($this->option_arr['o_smtp_user'])
					->setSmtpPass($this->option_arr['o_smtp_pass']);
			} else {
				$pjEmail->setTransport('mail');
			}
			$booking_arr = $pjBookingModel
				->reset()
				->select('t1.*, t1.id AS `booking_id`, t2.content AS `country_title`,
					t3.content AS `reminder_subject_client`, t4.content AS `reminder_tokens_client`')
				->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.customer_country AND t2.locale=t1.locale_id AND t2.field='name'", 'left outer')
				->join('pjMultiLang', "t3.model='pjCalendar' AND t3.foreign_id=t1.calendar_id AND t3.locale=t1.locale_id AND t3.field='reminder_subject_client'", 'left outer')
				->join('pjMultiLang', "t4.model='pjCalendar' AND t4.foreign_id=t1.calendar_id AND t4.locale=t1.locale_id AND t4.field='reminder_tokens_client'", 'left outer')
				->where('t1.booking_status', 'confirmed')
				->where('t1.calendar_id', $calendar['id'])
				->where('t1.reminder_email', 0)
				->where(sprintf("0 < (SELECT COUNT(*)
					FROM `%1\$s`
					WHERE `booking_id` = `t1`.`id`
					AND (UNIX_TIMESTAMP() BETWEEN (`start_ts` - %2\$u) AND `start_ts`)
					LIMIT 1)", $pjBookingSlotModel->getTable(), (int) $this->option_arr['o_reminder_email_before'] * 3600))
				->findAll()
				->getData();

			foreach ($booking_arr as $booking)
			{
				$booking['bs_arr'] = $pjBookingSlotModel->reset()->where('t1.booking_id', $booking['id'])->findAll()->getData();
				
				$tokens = pjAppController::getTokens($booking, $this->option_arr);
				$subject_client = str_replace($tokens['search'], $tokens['replace'], $booking['reminder_subject_client']);
				$message_client = str_replace($tokens['search'], $tokens['replace'], $booking['reminder_tokens_client']);
				$message_client = pjUtil::textToHtml($message_client);
				
				$pjEmail->setTo($booking['customer_email']);
				$pjEmail->setSubject($subject_client);
				$pjEmail->setFrom($calendar['email']);
				$pjEmail->setReplyTo($calendar['email']);
				$pjEmail->setReturnPath($calendar['email']);
				
				if ($pjEmail->send($message_client))
				{
					$pjBookingModel->reset()->set('id', $booking['id'])->modify(array('reminder_email' => 1));
				}
			}
			
			# SMS
			if ($isSms)
			{
				$booking_arr = $pjBookingModel
					->reset()
					->select('t1.*, t2.content AS `country_title`, t3.content AS `reminder_sms_client`')
					->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.customer_country AND t2.locale=t1.locale_id AND t2.field='name'", 'left outer')
					->join('pjMultiLang', "t3.model='pjCalendar' AND t3.foreign_id=t1.calendar_id AND t3.locale=t1.locale_id AND t3.field='reminder_sms_client'", 'left outer')
					->where('t1.booking_status', 'confirmed')
					->where('t1.calendar_id', $calendar['id'])
					->where('t1.reminder_sms', 0)
					->where(sprintf("0 < (SELECT COUNT(*)
						FROM `%1\$s`
						WHERE `booking_id` = `t1`.`id`
						AND (UNIX_TIMESTAMP() BETWEEN (`start_ts` - %2\$u) AND `start_ts`)
						LIMIT 1)", $pjBookingSlotModel->getTable(), (int) $this->option_arr['o_reminder_sms_hours'] * 3600))
					->findAll()
					->getData();

				foreach ($booking_arr as $booking)
				{
					if (empty($booking['customer_phone']))
					{
						continue;
					}
					
					$booking['bs_arr'] = $pjBookingSlotModel->reset()->where('t1.booking_id', $booking['id'])->findAll()->getData();

					$tokens = pjAppController::getTokens($booking, $this->option_arr);
					$message_client = str_replace($tokens['search'], $tokens['replace'], $booking['reminder_sms_client']);

					$number = $booking['customer_phone'];
					$number = preg_replace('/\D/', '', $number);
					
					$result = $this->requestAction(array(
						'controller' => 'pjSms',
						'action' => 'pjActionSend',
						'params' => array(
							'key' => $priv_key,
							'number' => $number,
							'text' => $message_client
						)), array('return'));
					
					if ((int) $result === 1)
					{
						$pjBookingModel->reset()->set('id', $booking['id'])->modify(array('reminder_sms' => 1));
					}
				}
			}
		}
		exit;
	}
}
?>