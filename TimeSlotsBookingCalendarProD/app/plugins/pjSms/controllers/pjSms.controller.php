<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once dirname(__FILE__) . '/pjSmsAppController.controller.php';
class pjSms extends pjSmsAppController
{
	public function pjActionGetSms()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged() && $this->isAdmin())
		{
			pjObject::import('Model', 'pjSms:pjSms');
			$pjSmsModel = pjSmsModel::factory();
			
			if (isset($_GET['q']) && !empty($_GET['q']))
			{
				$q = $pjSmsModel->escapeStr($_GET['q']);
				$q = str_replace(array('%', '_'), array('\%', '\_'), $q);
				$pjSmsModel->where("(t1.number LIKE '%$q%' OR t1.text LIKE '%$q%')");
			}
			
			$column = 'created';
			$direction = 'DESC';
			if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC')))
			{
				$column = $_GET['column'];
				$direction = strtoupper($_GET['direction']);
			}

			$total = $pjSmsModel->findCount()->getData();
			$rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
			$pages = ceil($total / $rowCount);
			$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
			$offset = ((int) $page - 1) * $rowCount;
			if ($page > $pages)
			{
				$page = $pages;
			}

			$data = $pjSmsModel->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();
						
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionIndex()
	{
		$this->checkLogin();
		
		if ($this->isAdmin())
		{
			if (isset($_POST['sms_post']))
			{
				$pjOptionModel = pjOptionModel::factory();
				
				if (0 != $pjOptionModel
					->where('foreign_id', $this->getForeignId())
					->where('`key`', 'plugin_sms_api_key')
					->findCount()->getData()
				)
				{
					$pjOptionModel
						->limit(1)
						->modifyAll(array(
							'value' => $_POST['plugin_sms_api_key']
						));
				} else {
					$pjOptionModel->setAttributes(array(
						'foreign_id' => $this->getForeignId(),
						'key' => 'plugin_sms_api_key',
						'tab_id' => '99',
						'value' => $_POST['plugin_sms_api_key'],
						'type' => 'string',
						'is_visible' => 0
					))->insert();
				}
				
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjSms&action=pjActionIndex&err=PSS02");
			}
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjSms.js', $this->getConst('PLUGIN_JS_PATH'));
		} else {
			$this->set('status', 2);
		}
	}

	public function pjActionSend()
	{
		$this->setAjax(true);
		
		$params = $this->getParams();
		
		if (!isset($params['key']) || $params['key'] != md5($this->option_arr['private_key'] . PJ_SALT) ||
			!isset($params['number']) || !isset($params['text']) || !isset($this->option_arr['plugin_sms_api_key']))
		{
			return FALSE;
		}
		
		pjObject::import('Component', 'pjSms:pjSmsApi');
		
		$pjSmsApi = new pjSmsApi();
		
		$response = $pjSmsApi
			->setApiKey($this->option_arr['plugin_sms_api_key'])
			->setNumber($params['number'])
			->setText($params['text'])
			->send();
			
		pjObject::import('Model', 'pjSms:pjSms');
		pjSmsModel::factory()->setAttributes(array(
			'number' => $params['number'],
			'text' => $params['text'],
			'status' => $response
		))->insert();
		
		return $response;
	}
}
?>