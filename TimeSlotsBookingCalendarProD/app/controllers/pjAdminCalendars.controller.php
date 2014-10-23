<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once PJ_CONTROLLERS_PATH . 'pjAdmin.controller.php';
class pjAdminCalendars extends pjAdmin
{
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin() && !$this->isEditor())
		{
			$this->set('status', 2);
			return;
		}

		if (isset($_POST['calendar_create']))
		{
			$data = $required = array();
			if ($this->isEditor())
			{
				$data['user_id'] = $this->getUserId();
			} else {
				$required[] = 'user_id';
			}
			$data = array_merge($_POST, $data);
			
			$pjCalendarModel = pjCalendarModel::factory();
			if (!$pjCalendarModel->validateRequest($required, $data))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminCalendars&action=pjActionIndex&err=AC13");
			}

			if (!$pjCalendarModel->validates($data))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminCalendars&action=pjActionIndex&err=AC13");
			}
			
			$id = $pjCalendarModel->setAttributes($data)->insert()->getInsertId();
			if ($id !== false && (int) $id > 0)
			{
				$err = 'AC03';
				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjCalendar');
				}
				
				pjWorkingTimeModel::factory()->init($id);
				pjOptionModel::factory()->init($id);
				
			} else {
				$err = 'AC04';
			}
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminCalendars&action=pjActionIndex&err=$err");
		} else {
			pjObject::import('Model', array('pjLocale:pjLocale', 'pjLocale:pjLocaleLanguage'));
			$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
				->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
				->where('t2.file IS NOT NULL')
				->orderBy('t1.sort ASC')->findAll()->getData();
					
			$lp_arr = array();
			foreach ($locale_arr as $item)
			{
				$lp_arr[$item['id']."_"] = $item['file']; //Hack for jquery $.extend, to prevent (re)order of numeric keys in object
			}
			$this->set('lp_arr', $locale_arr);
			
			$this->set('user_arr', pjUserModel::factory()->orderBy('t1.name ASC')->findAll()->getData());
	
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			if ((int) $this->option_arr['o_multi_lang'] === 1)
			{
				$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
				$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
			}
			$this->appendJs('pjAdminCalendars.js');
		}
	}
	
	public function pjActionDeleteCalendar()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				if ($_GET['id'] == $this->getForeignId())
				{
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Current calendar can not be deleted.'));
				}
				
				if (pjCalendarModel::factory()->set('id', $_GET['id'])->erase()->getAffectedRows() == 1)
				{
					pjMultiLangModel::factory()->where('model', 'pjCalendar')->where('foreign_id', $_GET['id'])->eraseAll();
					pjDateModel::factory()->where('foreign_id', $_GET['id'])->eraseAll();
					pjPriceModel::factory()->where('calendar_id', $_GET['id'])->eraseAll();
					pjPriceDayModel::factory()->where('calendar_id', $_GET['id'])->eraseAll();
					pjWorkingTimeModel::factory()->where('foreign_id', $_GET['id'])->limit(1)->eraseAll();
					pjOptionModel::factory()->where('foreign_id', $_GET['id'])->eraseAll();
					
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Calendar has been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Calendar has not been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty params.'));
		}
		exit;
	}
	
	public function pjActionDeleteCalendarBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				$cnt = count($_POST['record']);
				pjCalendarModel::factory()
					->where('id !=', $this->getForeignId())
					->whereIn('id', $_POST['record'])
					->limit($cnt)
					->eraseAll();
				pjMultiLangModel::factory()->where('model', 'pjCalendar')->whereIn('foreign_id', $_POST['record'])->eraseAll();
				pjDateModel::factory()->whereIn('foreign_id', $_POST['record'])->eraseAll();
				pjPriceModel::factory()->whereIn('calendar_id', $_POST['record'])->eraseAll();
				pjPriceDayModel::factory()->whereIn('calendar_id', $_POST['record'])->eraseAll();
				pjWorkingTimeModel::factory()->whereIn('foreign_id', $_POST['record'])->limit($cnt)->eraseAll();
				pjOptionModel::factory()->whereIn('foreign_id', $_POST['record'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Calendar(s) has been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty params.'));
		}
		exit;
	}
	
	private function __getCalendar($cid, $year, $month, $view=1)
	{
		$TSBCalendar = new pjTSBCalendar();
		$TSBCalendar
			->setPrevLink("&nbsp;")
			->setNextLink("&nbsp;")
			->set('calendarId', $cid)
			->set('options', $this->option_arr)
			->set('weekNumbers', (int) $this->option_arr['o_show_week_numbers'] === 1 ? true : false)
			->setStartDay($this->option_arr['o_week_start'])
			->setDayNames(__('day_names', true))
			->setMonthNames(__('months', true))
			->set('dayoff', pjWorkingTimeModel::factory()->getDaysOff($cid))
			->set('dateoff', pjDateModel::factory()->getDatesOff($cid, $month, $year))
			->set('monthStatus', pjAppController::getMonthStatus($cid, $month, $year));
		;
		if ((int) $this->option_arr['o_hide_prices'] === 0)
		{
			$TSBCalendar
				//->set('prices', $price_arr['priceData'])
				->set('showPrices', true);
		}
		
		$this->set('TSBCalendar', $TSBCalendar);
	}
	
	public function pjActionGetCal()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			$this->__getCalendar($this->getForeignId(), $_GET['year'], $_GET['month']);
		}
	}
	
	public function pjActionGetCalendar()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$pjCalendarModel = pjCalendarModel::factory()
				->join('pjMultiLang', sprintf("t2.model='pjCalendar' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='%u'", $this->getLocaleId()), 'left outer')
				->join('pjUser', 't3.id=t1.user_id', 'left outer');

			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = $pjCalendarModel->escapeStr(trim($_GET['q']));
				$q = str_replace(array('%', '_'), array('\%', '\_'), $q);
				$pjCalendarModel->where('t2.content LIKE', "%$q%");
				$pjCalendarModel->orWhere('t3.name LIKE', "%$q%");
				$pjCalendarModel->orWhere('t3.email LIKE', "%$q%");
			}
			
			if ($this->isEditor())
			{
				$pjCalendarModel->where('t1.user_id', $this->getUserId());
			}

			$column = '`title`';
			$direction = 'ASC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjCalendarModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjCalendarModel->select('t1.id, t1.user_id, t2.content AS `title`, t3.email, t3.name')
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin() && !$this->isEditor())
		{
			$this->set('status', 2);
			return;
		}
		
		$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
		$this->appendJs('pjAdminCalendars.js');
	}
	
	public function pjActionSaveCalendar()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			if (!isset($_POST['column']) || empty($_POST['column']) || !isset($_POST['value']) || !isset($_GET['id']) || (int) $_GET['id'] <= 0)
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, invalid or empty params.'));
			}
			$pjCalendarModel = pjCalendarModel::factory();
			if (!in_array($_POST['column'], $pjCalendarModel->getI18n()))
			{
				$pjCalendarModel->set('id', $_GET['id'])->modify(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjCalendar');
			}
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Calendar has been updated.'));
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin() && !$this->isEditor())
		{
			$this->set('status', 2);
			return;
		}
		
		if (isset($_POST['calendar_update']))
		{
			$required = array('id');
			if (!$this->isEditor())
			{
				$required[] = 'user_id';
			} else {
				if (isset($_POST['user_id']))
				{
					unset($_POST['user_id']);
				}
			}
			
			$pjCalendarModel = pjCalendarModel::factory();
			if (!$pjCalendarModel->validateRequest($required, $_POST))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminCalendars&action=pjActionIndex&err=AC13");
			}

			if (!$pjCalendarModel->validates($_POST))
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminCalendars&action=pjActionIndex&err=AC13");
			}
			
			$pjCalendarModel->set('id', $_POST['id'])->modify($_POST);
			if (isset($_POST['i18n']))
			{
				pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjCalendar');
			}
			pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminCalendars&action=pjActionIndex&err=AC01");
			
		} else {
			if (!isset($_GET['id']) || (int) $_GET['id'] <= 0)
			{
				pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminCalendars&action=pjActionIndex&err=AC13");
			}
			
			$arr = pjCalendarModel::factory()->find($_GET['id'])->getData();
			if (empty($arr))
			{
				pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminCalendars&action=pjActionIndex&err=AC08");
			}
			$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjCalendar');
			$this->set('arr', $arr);
			
			pjObject::import('Model', array('pjLocale:pjLocale', 'pjLocale:pjLocaleLanguage'));
			$locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
				->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
				->where('t2.file IS NOT NULL')
				->orderBy('t1.sort ASC')->findAll()->getData();
			
			$lp_arr = array();
			foreach ($locale_arr as $item)
			{
				$lp_arr[$item['id']."_"] = $item['file']; //Hack for jquery $.extend, to prevent (re)order of numeric keys in object
			}
			$this->set('lp_arr', $locale_arr);
			
			$this->set('user_arr', pjUserModel::factory()->orderBy('t1.name ASC')->findAll()->getData());
			
			$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
			if ((int) $this->option_arr['o_multi_lang'] === 1)
			{
				$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
				$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
			}
			$this->appendJs('pjAdminCalendars.js');
		}
	}
	
	public function pjActionView()
	{
		$this->checkLogin();
		
		if (!$this->isAdmin() && !$this->isEditor())
		{
			$this->set('status', 2);
			return;
		}
		
		if (isset($_GET['id']) && (int) $_GET['id'] > 0)
		{
			if ((int) pjCalendarModel::factory()->where('t1.id', $_GET['id'])->findCount()->getData() !== 1)
			{
				pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminCalendars&action=pjActionIndex");
			}
			$this->setForeignId($_GET['id']);
		}

		$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
		$this->appendCss('index.php?controller=pjFrontEnd&action=pjActionLoadCss&skip_jqueryui=1&cid=' . $this->getForeignId() . '&' . rand(1,99999), PJ_INSTALL_URL, true);
		$this->appendJs('jquery.noty.packaged.min.js', PJ_THIRD_PARTY_PATH . 'noty/packaged/');
		$this->appendJs('pjAdminCalendars.js');
	}
	
	function pjActionGetSlots()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_GET['date']) && !empty($_GET['date']))
			{
				$this->getSlots($_GET['date']);
			}
		}
	}
	
	public function pjActionDeleteTimeslot()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['id']) && (int) $_POST['id'] > 0)
			{
				if (1 == pjBookingSlotModel::factory()->set('id', $_POST['id'])->erase()->getAffectedRows())
				{
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Time slot has been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Time slot has not been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing or empty parameters.'));
		}
		exit;
	}
	
	public function pjActionDeleteBooking()
	{
		$this->setAjax(true);
		
		if ($this->isXHR() && $this->isLoged())
		{
			if (isset($_POST['booking_id']) && (int) $_POST['booking_id'] > 0)
			{
				if (1 == pjBookingModel::factory()->set('id', $_POST['booking_id'])->erase()->getAffectedRows())
				{
					pjBookingSlotModel::factory()->where('booking_id', $_POST['booking_id'])->eraseAll();
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Booking has been deleted.'));
				}
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Booking has not been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'Missing or empty parameters.'));
		}
		exit;
	}
	
	/*
	function updateDate()
	{
		if ($this->isLoged())
		{
			if ($this->isAdmin() || $this->isEditor())
			{
				Object::import('Model', 'Date');
				$DateModel = new DateModel();
				
				$arr = $DateModel->getAll(array('t1.calendar_id' => $_POST['calendar_id'], 't1.event_date' => $_POST['event_date'], 'col_name' => 't1.calendar_id', 'direction' => 'asc'));
				
				if (count($arr) == 1)
				{
					$DateModel->update($_POST, array('calendar_id' => $_POST['calendar_id'], 'event_date' => $_POST['event_date']));
				} elseif (count($arr) == 0) {
					$DateModel->save($_POST);
				}
				
				Util::redirect($_SERVER['PHP_SELF']."?controller=AdminCalendars&action=view&cid=".$_POST['calendar_id'] . "&err=10");
            			
			} else {
				$this->tpl['status'] = 2;
			}
		} else {
			$this->tpl['status'] = 1;
		}
	}
	*/
}
?>