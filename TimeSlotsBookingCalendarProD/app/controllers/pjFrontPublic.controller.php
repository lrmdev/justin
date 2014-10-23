<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjFrontPublic extends pjFront
{
	public function __construct()
	{
		parent::__construct();
		
		$this->setAjax(true);
		
		$this->setLayout('pjActionEmpty');
	}
	
	public function pjActionCalendar()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if (isset($_GET['_escaped_fragment_']))
			{
				preg_match('/\/date:([\d\-\.\/]+)?/', $_GET['_escaped_fragment_'], $matches);
				if (!empty($matches))
				{
					$date = $matches[1];
				}
			} else {
				$date = @$_GET['date'];
			}
			
			$year = $month = $day = NULL;
			if (!empty($date))
			{
				list($year, $month, $day) = explode("-", $date);
			}
			
			$this->set('calendar', $this->getCalendar($_GET['cid'], $year, $month, $day));
		}
	}
	
	public function pjActionCart()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$this->set('cart_arr', $this->getCart($_GET['cid']));
			if ((int) $this->option_arr['o_hide_prices'] === 0)
			{
				$this->set('cart_price_arr', pjAppController::getCartPrices($_GET['cid'], $this->cart));
			}
		}
	}
	
	public function pjActionCheckout()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if (isset($_POST['ts_checkout']))
			{
				$_SESSION[$this->defaultForm] = array_merge($_SESSION[$this->defaultForm], $_POST);
				
				if (!isset($_GET['cid']) || (int) $_GET['cid'] <= 0)
				{
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Missing, empty or invalid parameters.'));
				}
				
				$response = $this->validateCheckout($_GET['cid']);
				pjAppController::jsonResponse($response);
				
			} else {
				if (!$this->cart->isEmpty())
				{
					if (in_array($this->option_arr['o_bf_country'], array(2,3)))
					{
						pjObject::import('Model', 'pjCountry:pjCountry');
						$this->set('country_arr', pjCountryModel::factory()
							->select('t1.*, t2.content AS name')
							->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->pjActionGetLocale()."'", 'left outer')
							->where('t1.status', 'T')
							->orderBy('`name` ASC')
							->findAll()
							->getData()
						);
					}
					$this->set('terms_arr', $this->getTerms($_GET['cid']));
					$this->set('amount', pjAppController::getCartTotal($_GET['cid'], $this->cart, $this->option_arr));
					
					$this->set('status', 'OK');
					//$this->set('summary', $this->getSummary());
					$this->set('cart_arr', $this->getCart($_GET['cid']));
					if ((int) $this->option_arr['o_hide_prices'] === 0)
					{
						$this->set('cart_price_arr', pjAppController::getCartPrices($_GET['cid'], $this->cart));
					}
				} else {
					$this->set('status', 'ERR');
					$this->set('code', '101'); //Empty cart
				}
			}
		}
	}
		
	public function pjActionPreview()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if (!$this->cart->isEmpty())
			{
				if (!isset($_SESSION[$this->defaultForm]) || empty($_SESSION[$this->defaultForm]))
				{
					$this->set('status', 'ERR');
					$this->set('code', '102'); //Checkout form not filled
				} else {
					if (in_array($this->option_arr['o_bf_country'], array(2,3)) && (int) @$_SESSION[$this->defaultForm]['customer_country'] > 0)
					{
						pjObject::import('Model', 'pjCountry:pjCountry');
						$this->set('country_arr', pjCountryModel::factory()
							->select('t1.*, t2.content AS name')
							->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
							->find($_SESSION[$this->defaultForm]['customer_country'])
							->getData()
						);
					}
					$this->set('amount', pjAppController::getCartTotal($_GET['cid'], $this->cart, $this->option_arr));
					$this->set('status', 'OK');
					//$this->set('summary', $this->getSummary());
					$this->set('cart_arr', $this->getCart($_GET['cid']));
					if ((int) $this->option_arr['o_hide_prices'] === 0)
					{
						$this->set('cart_price_arr', pjAppController::getCartPrices($_GET['cid'], $this->cart));
					}
				}
			} else {
				$this->set('status', 'ERR');
				$this->set('code', '101'); //Empty cart
			}
		}
	}
	
	public function pjActionTimeslots()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if (isset($_GET['_escaped_fragment_']))
			{
				preg_match('/\/date:([\d\-\.\/]+)?/', $_GET['_escaped_fragment_'], $matches);
				if (!empty($matches))
				{
					$date = $matches[1];
				}
			} else {
				$date = @$_GET['date'];
			}
			
			$year = $month = $day = NULL;
			if (!empty($date))
			{
				list($year, $month, $day) = explode("-", $date);
			}
			
			$result = $this->getTimeslots($_GET['cid'], $date);
			
			foreach ($result as $key => $value)
			{
				$this->set($key, $value);
			}
		}
	}

	public function pjActionBooking()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			$this->set('status', 'OK');
			
			if (isset($_GET['booking_uuid']) && !empty($_GET['booking_uuid']))
			{
				$booking_uuid = $_GET['booking_uuid'];
			} elseif (isset($_GET['_escaped_fragment_'])) {
				preg_match('/\/Booking\/([A-Z]{2}\d{10})/', $_GET['_escaped_fragment_'], $matches);
				if (isset($matches[1]))
				{
					$booking_uuid = $matches[1];
				}
			}
			
			$booking_arr = pjBookingModel::factory()->where('t1.uuid', $booking_uuid)->findAll()->limit(1)->getData();
			if (!empty($booking_arr))
			{
				$booking_arr = $booking_arr[0];
				
				pjObject::import('Model', 'pjInvoice:pjInvoice');
				$invoice_arr = pjInvoiceModel::factory()->where('t1.order_id', $booking_uuid)->findAll()->limit(1)->getData();
				if (!empty($invoice_arr))
				{
					$invoice_arr = $invoice_arr[0];
					
					switch ($booking_arr['payment_method'])
					{
						case 'paypal':
							$this->set('params', array(
								'name' => 'tsPaypal',
								'id' => 'tsPaypal',
								'target' => '_self',
								'business' => $this->option_arr['o_paypal_address'],
								'item_name' => $booking_arr['uuid'],
								'custom' => $invoice_arr['uuid'],
								'amount' => $invoice_arr['total'],
								'currency_code' => $invoice_arr['currency'],
								'return' => $this->option_arr['o_thankyou_page'],
								'notify_url' => PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionConfirmPaypal',
								'submit' => __('payment_paypal_submit', true),
								'submit_class' => 'tsSelectorButton tsButton tsButtonGreen'
							));
							break;
						case 'authorize':
							$this->set('params', array(
								'name' => 'tsAuthorize',
								'id' => 'tsAuthorize',
								'target' => '_self',
								'timezone' => $this->option_arr['o_authorize_tz'],
								'transkey' => $this->option_arr['o_authorize_key'],
								'x_login' => $this->option_arr['o_authorize_mid'],
								'x_description' => $booking_arr['uuid'],
								'x_amount' => $invoice_arr['total'],
								'x_invoice_num' => $invoice_arr['uuid'],
								'x_receipt_link_url' => $this->option_arr['o_thankyou_page'],
								'x_relay_url' => PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionConfirmAuthorize',
								'submit' => __('payment_authorize_submit', true),
								'submit_class' => 'tsSelectorButton tsButton tsButtonGreen'
							));
							break;
					}
					
					$this->set('booking_arr', $booking_arr);
					$this->set('invoice_arr', $invoice_arr);
				}
			}
		}
	}
	
	public function pjActionWeekly()
	{
		if ($this->isXHR() || isset($_GET['_escaped_fragment_']))
		{
			if (isset($_GET['_escaped_fragment_']))
			{
				preg_match('/\/date:([\d\-\.\/]+)?/', $_GET['_escaped_fragment_'], $matches);
				if (!empty($matches))
				{
					$date = $matches[1];
				}
			} else {
				$date = @$_GET['date'];
			}
			
			$result = $this->getWeeklyTimeslots($_GET['cid'], $date);
			
			foreach ($result as $key => $value)
			{
				$this->set($key, $value);
			}
		}
	}
	
	public function pjActionRouter()
	{
		$this->setAjax(false);

		if (isset($_GET['_escaped_fragment_']))
		{
			$templates = array('Checkout', 'Preview', 'Timeslots', 'Booking', 'Calendar', 'Cart', 'Weekly');
			preg_match('/^\/(\w+).*/', $_GET['_escaped_fragment_'], $m);
			if (isset($m[1]) && in_array($m[1], $templates))
			{
				$template = 'pjAction'.$m[1];
			
				if (method_exists($this, $template))
				{
					$this->$template();
				}
				$this->setTemplate('pjFrontPublic', $template);
			}
		}
	}
}
?>