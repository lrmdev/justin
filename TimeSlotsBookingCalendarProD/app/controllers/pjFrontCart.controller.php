<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontCart extends pjFront
{
	public function pjActionAdd()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (isset($_GET['cid']) && (int) $_GET['cid'] > 0 &&
				isset($_POST['date']) && isset($_POST['start_ts']) && isset($_POST['end_ts']) &&
				preg_match('/^\d{10}$/', $_POST['start_ts']) && preg_match('/^\d{10}$/', $_POST['end_ts']) &&
				pjValidation::pjActionDate($_POST['date'])
			)
			{
				$this->cart->add($_GET['cid'], $_POST['date'], $_POST['start_ts'] ."|". $_POST['end_ts'], 1);
				
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Item was added to your cart.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty parameters.'));
		}
		exit;
	}

	protected function pjActionSort(&$arr)
	{
		$_arr = array();
		foreach ($arr as $cid => $date_arr)
		{
			foreach ($date_arr as $date => $time_arr)
			{
				$_time_arr = array();
				foreach ($time_arr as $time => $q)
				{
					list($start_ts, $end_ts) = explode("|", $time);
					$_time_arr[$start_ts] = $time;
				}
				ksort($_time_arr); //ksort, krsort
				$_arr[$cid][strtotime($date)] = array_flip($_time_arr);
			}
			ksort($_arr[$cid]); //ksort, krsort
		}
		$arr = array();
		foreach ($_arr as $cid => $date_arr)
		{
			foreach ($date_arr as $date => $time_arr)
			{
				$arr[$cid][date("Y-m-d", $date)] = $time_arr;
			}
		}
	}
	
	public function pjActionRemove()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (isset($_GET['cid']) && (int) $_GET['cid'] > 0 &&
				isset($_POST['date']) && isset($_POST['start_ts']) && isset($_POST['end_ts']) &&
				preg_match('/^\d{10}$/', $_POST['start_ts']) && preg_match('/^\d{10}$/', $_POST['end_ts']) &&
				pjValidation::pjActionDate($_POST['date'])
			)
			{
				$this->cart->remove($_GET['cid'], $_POST['date'], $_POST['start_ts'] ."|". $_POST['end_ts']);
				
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Item was removed from your cart.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty parameters.'));
		}
		exit;
	}
	
	public function pjActionReset()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			$this->cart->reset();
			pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Cart has been reset.'));
		}
		exit;
	}
	
	public function pjActionUpdate()
	{
		$this->setAjax(true);
		
		if ($this->isXHR())
		{
			if (isset($_GET['cid']) && (int) $_GET['cid'] > 0 && isset($_POST['timeslot']) && !empty($_POST['timeslot']))
			{
				foreach ($_POST['timeslot'] as $date => $time_arr)
				{
					foreach ($time_arr as $start_ts => $end_ts)
					{
						$this->cart->remove($_GET['cid'], $date, $start_ts . "|" . $end_ts);
					}
				}
				pjAppController::jsonResponse(array('status' => 'OK', 'code' => 200, 'text' => 'Cart has been updated.'));
			}
			pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing or empty parameters.'));
		}
		exit;
	}
}
?>