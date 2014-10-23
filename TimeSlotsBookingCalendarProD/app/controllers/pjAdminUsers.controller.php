<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once PJ_CONTROLLERS_PATH . 'pjAdmin.controller.php';
class pjAdminUsers extends pjAdmin
{
	public function pjActionCheckEmail()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (!isset($_GET['email']) || empty($_GET['email']))
			{
				echo 'false';
				exit;
			}
			$pjUserModel = pjUserModel::factory()->where('t1.email', $_GET['email']);
			if (isset($_GET['id']) && (int) $_GET['id'] > 0)
			{
				$pjUserModel->where('t1.id !=', $_GET['id']);
			}
			echo $pjUserModel->findCount()->getData() == 0 ? 'true' : 'false';
		}
		exit;
	}
	
	public function pjActionCreate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if (isset($_POST['user_create']))
			{
				$data = array();
				$data['is_active'] = 'T';
				$data['ip'] = pjUtil::getClientIp();
				
				$data = array_merge($_POST, $data);
				$pjUserModel = pjUserModel::factory();
				
				if (!$pjUserModel->validateRequest(array('role_id', 'email', 'password', 'name', 'status'), $data))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminUsers&action=pjActionIndex&err=AU10");
				}
				
				if (!$pjUserModel->validates($data))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminUsers&action=pjActionIndex&err=AU10");
				}
				
				if (0 != $pjUserModel->where('t1.email', $data['email'])->findCount()->getData())
				{
					pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminUsers&action=pjActionIndex&err=AU09");
				}
				
				$id = $pjUserModel->reset()->setAttributes($data)->insert()->getInsertId();
				if ($id !== false && (int) $id > 0)
				{
					$pjUserModel->reset()->where('id', $id)->limit(1)->modifyAll(array('notify_email' => !empty($_POST['notify_email']) ? join("::", $_POST['notify_email']) : ':NULL'));
					
					$err = 'AU03';
					if (isset($_POST['i18n']))
					{
						pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjUser');
					}
				} else {
					$err = 'AU04';
				}
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminUsers&action=pjActionIndex&err=$err");
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
				$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
				
				$this->set('role_arr', pjRoleModel::factory()->orderBy('t1.id ASC')->findAll()->getData());
		
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendJs('jquery.multiselect.min.js', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendCss('jquery.multiselect.css', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendJs('pjAdminUsers.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionDeleteUser()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (!isset($_GET['id']) || (int) $_GET['id'] <= 0)
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 102, 'text' => 'Missing params.'));
			}

			if ($_GET['id'] != $this->getUserId())
			{
				if (pjUserModel::factory()->setAttributes(array('id' => $_GET['id']))->erase()->getAffectedRows() == 1)
				{
					pjMultiLangModel::factory()->where('model', 'pjUser')->where('foreign_id', $_GET['id'])->eraseAll();
					pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User has been deleted.'));
				} else {
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'User has not been deleted.'));
				}
			} else {
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'You can not delete your own account.'));
			}
		}
		exit;
	}
	
	public function pjActionDeleteUserBulk()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				pjUserModel::factory()
					->where('id !=', $this->getUserId())
					->whereIn('id', $_POST['record'])->eraseAll();
				pjMultiLangModel::factory()->where('model', 'pjUser')->whereIn('foreign_id', $_POST['record'])->eraseAll();
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Selected user(s) has been deleted.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty params.'));
		}
		exit;
	}
	
	public function pjActionExportUser()
	{
		$this->checkLogin();
		
		if (isset($_POST['record']) && is_array($_POST['record']) && $this->isAdmin())
		{
			$arr = pjUserModel::factory()->whereIn('id', $_POST['record'])->findAll()->getData();
			$csv = new pjCSV();
			$csv
				->setHeader(true)
				->setName("Users-".time().".csv")
				->process($arr)
				->download();
		} else {
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty params.'));
		}
		exit;
	}
	
	public function pjActionGetUser()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			$pjUserModel = pjUserModel::factory();
			
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = $pjUserModel->escapeStr($_GET['q']);
				$q = str_replace(array('_', '%'), array('\_', '\%'), $q);
				$pjUserModel->where('t1.email LIKE', "%$q%");
				$pjUserModel->orWhere('t1.name LIKE', "%$q%");
			}

			if (isset($_GET['status']) && !empty($_GET['status']) && in_array($_GET['status'], array('T', 'F')))
			{
				$pjUserModel->where('t1.status', $_GET['status']);
			}
				
			$column = 'name';
			$direction = 'ASC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjUserModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjUserModel->select('t1.id, t1.email, t1.name, DATE(t1.created) AS created, t1.status, t1.is_active, t1.role_id, t2.role')
				->join('pjRole', 't2.id=t1.role_id', 'left')
				->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
				
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjAdminUsers.js');
		} else {
			$this->set('status', 2);
		}
	}
	
	public function pjActionSetActive()
	{
		$this->setAjax(true);

		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (!isset($_POST['id']) || (int) $_POST['id'] <= 0)
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or invalid params.'));
			}
			
			$pjUserModel = pjUserModel::factory();
			$arr = $pjUserModel->find($_POST['id'])->getData();
			if (empty($arr))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 101, 'text' => 'User account has not been found.'));
			}
			
			switch ($arr['is_active'])
			{
				case 'T':
					$sql_status = 'F';
					break;
				case 'F':
					$sql_status = 'T';
					break;
				default:
					return;
			}
			$pjUserModel->reset()->setAttributes(array('id' => $_POST['id']))->modify(array('is_active' => $sql_status));
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User has been updated.'));
		}
		exit;
	}
	
	public function pjActionSaveUser()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (!isset($_POST['column']) || !isset($_POST['value']) || !isset($_GET['id']) || empty($_POST['column']) || (int) $_GET['id'] <= 0)
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, empty or invalid params.'));
			}
			
			$pjUserModel = pjUserModel::factory();
			if (!in_array($_POST['column'], $pjUserModel->getI18n()))
			{
				$pjUserModel->where('id', $_GET['id'])->limit(1)->modifyAll(array($_POST['column'] => $_POST['value']));
			} else {
				pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjUser');
			}
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User has been updated.'));
		}
		exit;
	}
	
	public function pjActionStatusUser()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				pjUserModel::factory()->whereIn('id', $_POST['record'])->modifyAll(array(
					'status' => ":IF(`status`='F','T','F')"
				));
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'User has been updated.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing params.'));
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if (isset($_POST['user_update']))
			{
				$pjUserModel = pjUserModel::factory();
				
				if (!$pjUserModel->validateRequest(array('id', 'role_id', 'email', 'password', 'name', 'status'), $_POST))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminUsers&action=pjActionIndex&err=AU10");
				}
				
				if (!$pjUserModel->validates($_POST))
				{
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminUsers&action=pjActionIndex&err=AU10");
				}
				
				if (0 != $pjUserModel->where('t1.email', $_POST['email'])->where('t1.id !=', $_POST['id'])->findCount()->getData())
				{
					pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminUsers&action=pjActionIndex&err=AU09");
				}
				$data = array();
				$data['notify_email'] = !empty($_POST['notify_email']) ? join("::", $_POST['notify_email']) : ':NULL';
				unset($_POST['notify_email']);
									
				$pjUserModel->reset()->set('id', $_POST['id'])->modify(array_merge($_POST, $data));
				if (isset($_POST['i18n']))
				{
					pjMultiLangModel::factory()->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjUser');
				}
				pjUtil::redirect(PJ_INSTALL_URL . "index.php?controller=pjAdminUsers&action=pjActionIndex&err=AU01");
				
			} else {
				if (!isset($_GET['id']) || empty($_GET['id']))
				{
					pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminUsers&action=pjActionIndex&err=AU08");
				}
				$arr = pjUserModel::factory()->find($_GET['id'])->getData();
				if (empty($arr))
				{
					pjUtil::redirect(PJ_INSTALL_URL. "index.php?controller=pjAdminUsers&action=pjActionIndex&err=AU08");
				}
				$arr['i18n'] = pjMultiLangModel::factory()->getMultiLang($arr['id'], 'pjUser');
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
				$this->set('locale_str', pjAppController::jsonEncode($lp_arr));
				
				$this->set('role_arr', pjRoleModel::factory()->orderBy('t1.id ASC')->findAll()->getData());
				
				$this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
				$this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
				$this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
				$this->appendJs('jquery.multiselect.min.js', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendCss('jquery.multiselect.css', PJ_THIRD_PARTY_PATH . 'multiselect/');
				$this->appendJs('pjAdminUsers.js');
			}
		} else {
			$this->set('status', 2);
		}
	}
}
?>