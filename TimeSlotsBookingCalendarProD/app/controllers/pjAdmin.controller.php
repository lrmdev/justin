<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once PJ_CONTROLLERS_PATH . 'pjAppController.controller.php';
class pjAdmin extends pjAppController
{
	public $defaultUser = 'admin_user';
	
	public $requireLogin = true;
	
	protected $adminBooking = 'Admin_Booking';
	
	public function __construct($requireLogin=null)
	{
		$this->setLayout('pjActionAdmin');
		
		if (!is_null($requireLogin) && is_bool($requireLogin))
		{
			$this->requireLogin = $requireLogin;
		}
		
		if ($this->requireLogin)
		{
			if (!$this->isLoged() && !in_array(@$_GET['action'], array('pjActionLogin', 'pjActionForgot', 'pjActionPreview', 'pjActionMessages')))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
			}
		}
	}
	
	public function afterFilter()
	{
		parent::afterFilter();
		$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
	}
	
	public function beforeRender()
	{
		
	}
		
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin() || $this->isEditor())
		{
			$pjUserModel = pjUserModel::factory();
			$pjBookingModel = pjBookingModel::factory();
			$pjBookingSlotModel = pjBookingSlotModel::factory();
			
			$info_arr = pjAppModel::factory()
				->prepare(sprintf("SELECT 1,
					(SELECT COUNT(*) FROM `%1\$s` WHERE `booking_date` = CURDATE() GROUP BY `booking_id`, `booking_date` LIMIT 1) AS `bookings_today`,
					(SELECT COUNT(*) FROM `%1\$s` WHERE WEEKOFYEAR(`booking_date`) = WEEKOFYEAR(CURDATE()) GROUP BY `booking_id`, `booking_date` LIMIT 1) AS `bookings_week`,
					(SELECT COUNT(*) FROM `%2\$s` WHERE 1 LIMIT 1) AS `users`
					",
					$pjBookingSlotModel->getTable(),
					$pjUserModel->getTable()
				))
				->exec()
				->getData();
			
			$user_arr = $pjUserModel
				->orderBy('t1.last_login DESC')
				->limit(5)
				->findAll()
				->getData();
				
			$latest_arr = $pjBookingModel
				->orderBy('t1.created DESC')
				->limit(5)
				->findAll()
				->getData();
			
			$upcoming_arr = $pjBookingSlotModel
				->select('t1.*, t2.customer_name')
				->join('pjBooking', 't2.id=t1.booking_id', 'inner')
				->where('t1.booking_date = CURDATE()')
				->groupBy('t1.booking_id, t1.booking_date')
				->orderBy('t1.booking_date ASC, t1.start_ts ASC')
				->limit(5)
				->findAll()
				->getData();
				
			$this
				->set('info_arr', $info_arr)
				->set('user_arr', $user_arr)
				->set('latest_arr', $latest_arr)
				->set('upcoming_arr', $upcoming_arr);
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionForgot()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['forgot_user']))
		{
			if (!isset($_POST['forgot_email']) || !pjValidation::pjActionNotEmpty($_POST['forgot_email']) || !pjValidation::pjActionEmail($_POST['forgot_email']))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
			}
			$pjUserModel = pjUserModel::factory();
			$user = $pjUserModel
				->where('t1.email', $_POST['forgot_email'])
				->limit(1)
				->findAll()
				->getData();
				
			if (count($user) != 1)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=AA10");
			} else {
				$user = $user[0];
				
				$Email = new pjEmail();
				$Email
					->setTo($user['email'])
					->setFrom($user['email'])
					->setSubject(__('emailForgotSubject', true));
				
				if ($this->option_arr['o_send_email'] == 'smtp')
				{
					$Email
						->setTransport('smtp')
						->setSmtpHost($this->option_arr['o_smtp_host'])
						->setSmtpPort($this->option_arr['o_smtp_port'])
						->setSmtpUser($this->option_arr['o_smtp_user'])
						->setSmtpPass($this->option_arr['o_smtp_pass'])
					;
				}
				
				$body = str_replace(
					array('{Name}', '{Password}'),
					array($user['name'], $user['password']),
					__('emailForgotBody', true)
				);

				if ($Email->send($body))
				{
					$err = "AA11";
				} else {
					$err = "AA12";
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionForgot&err=$err");
			}
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionMessages()
	{
		$this->setAjax(true);
		header("Content-Type: text/javascript; charset=utf-8");
	}
	
	public function pjActionLogin()
	{
		$this->setLayout('pjActionAdminLogin');
		
		if (isset($_POST['login_user']))
		{
			if (!isset($_POST['login_email']) || !isset($_POST['login_password']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_email']) ||
				!pjValidation::pjActionNotEmpty($_POST['login_password']) ||
				!pjValidation::pjActionEmail($_POST['login_email']))
			{
				// Data not validate
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=4");
			}
			$pjUserModel = pjUserModel::factory();

			$user = $pjUserModel
				->where('t1.email', $_POST['login_email'])
				->where(sprintf("t1.password = AES_ENCRYPT('%s', '%s')", $pjUserModel->escapeStr($_POST['login_password']), PJ_SALT))
				->limit(1)
				->findAll()
				->getData();

			if (count($user) != 1)
			{
				# Login failed
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=1");
			} else {
				$user = $user[0];
				unset($user['password']);
															
				if (!in_array($user['role_id'], array(1,2)))
				{
					# Login denied
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=2");
				}
				
				if ($user['status'] != 'T')
				{
					# Login forbidden
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin&err=3");
				}
				
				# Login succeed
				$last_login = date("Y-m-d H:i:s");
    			$_SESSION[$this->defaultUser] = $user;
    			
    			# Update
    			$data = array();
    			$data['last_login'] = $last_login;
    			$pjUserModel->reset()->set('id', $user['id'])->modify($data);

				$calendar = pjCalendarModel::factory()->where('t1.user_id', $user['id'])->limit(1)->findAll()->getDataPair(NULL, 'id');
    			if (count($calendar) === 1)
    			{
    				$this->setForeignId($calendar[0]);
    			}
    			
    			if ($this->isAdmin() || $this->isEditor())
    			{
	    			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionIndex");
    			}
			}
		} else {
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			$this->appendJs('pjAdmin.js');
		}
	}
	
	public function pjActionLogout()
	{
		if ($this->isLoged())
        {
        	unset($_SESSION[$this->defaultUser]);
        }
       	pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionLogin");
	}
	
	public function pjActionProfile()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin())
		{
			if (isset($_POST['profile_update']))
			{
				$pjUserModel = pjUserModel::factory();
				$arr = $pjUserModel->find($this->getUserId())->getData();
				$data = array();
				$data['role_id'] = $arr['role_id'];
				$data['status'] = $arr['status'];
				$post = array_merge($_POST, $data);
				if (!$pjUserModel->validates($post))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA14");
				}
				$pjUserModel->set('id', $this->getUserId())->modify($post);
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdmin&action=pjActionProfile&err=AA13");
			} else {
				$this->set('arr', pjUserModel::factory()->find($this->getUserId())->getData());
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('pjAdmin.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionRedirect()
	{
		if (isset($_GET['calendar_id']) && (int) $_GET['calendar_id'] > 0)
		{
			if ((int) pjCalendarModel::factory()->where('t1.id', $_GET['calendar_id'])->findCount()->getData() == 1)
			{
				$this->setForeignId($_GET['calendar_id']);
			}
		}
		
		$qs = NULL;
		if (isset($_GET['nextParams']) && !empty($_GET['nextParams']))
		{
			parse_str($_GET['nextParams'], $params);
			if (!empty($params))
			{
				$qs = http_build_query($params);
				$qs = "&" . $qs;
			}
		}

		pjUtil::redirect(sprintf("%sindex.php?controller=%s&action=%s%s", PJ_INSTALL_URL, $_GET['nextController'], $_GET['nextAction'], $qs));
		exit;
	}

	protected function getSlots($iso_date, $hash=NULL)
	{
		$t_arr = pjAppController::getDailySlots($this->getForeignId(), $iso_date, $this->option_arr);
		if ($t_arr['is_dayoff'] == 'T')
		{
			# It's Day off
			$this->set('dayoff', true);
			return;
		}
		
		$this->set('price_arr', pjAppController::getPricesDate($this->getForeignId(), $iso_date, $this->option_arr));
		
		$pjBookingSlotModel = pjBookingSlotModel::factory();
		
		# Get booked slots for given date.
		# If 24h, include next date
		$d_arr = array($pjBookingSlotModel->escapeStr($iso_date));
		if ($t_arr['end_ts'] < $t_arr['start_ts'])
		{
			$d_arr[] = date("Y-m-d", strtotime($iso_date) + 86400);
		}
		
		$bs_arr = $pjBookingSlotModel
			->join('pjBooking', sprintf("t2.id=t1.booking_id AND t2.calendar_id='%u' AND t2.booking_status IN ('pending', 'confirmed')", $this->getForeignId()), 'inner')
			->whereIn('t1.booking_date', $d_arr)
			->where('t2.booking_status !=', 'cancelled')
			->findAll()
			->getData();
		
		$_arr = array();
		if (isset($hash) && !empty($hash) &&
			isset($_SESSION[$this->adminBooking]) && isset($_SESSION[$this->adminBooking][$hash])
		)
		{
			foreach ($_SESSION[$this->adminBooking][$hash] as $key => $slot)
			{
				if ($slot['booking_date'] == $iso_date)
				{
					$_arr[] = $slot;
				}
			}
		}
		
		$bs_arr = array_merge($bs_arr, $_arr);
		
		$this->set('bs_arr', $bs_arr);
		$this->set('t_arr', $t_arr);
	}
}
?>