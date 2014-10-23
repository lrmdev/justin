<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
require_once dirname(__FILE__) . '/pjInstallerAppController.controller.php';
class pjInstaller extends pjInstallerAppController
{
	public $defaultInstaller = 'Installer';
	
	public $defaultErrors = 'Errors';
	
	public function beforeFilter()
	{
		$this->appendJs('jquery-1.8.3.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendCss('admin.css');
		$this->appendCss('install.css', $this->getConst('PLUGIN_CSS_PATH'));
		$this->appendCss('pj-button.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');
		$this->appendCss('pj-form.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');
	}

	private static function pjActionImportSQL($dbo, $file, $prefix, $scriptPrefix=NULL)
	{
		if (!is_object($dbo))
		{
			return FALSE;
		}
		ob_start();
		readfile($file);
		$string = ob_get_contents();
		ob_end_clean();
		if ($string !== false)
		{
			$string = preg_replace(
				array('/(INSERT\s+INTO|INSERT\s+IGNORE\s+INTO|DROP\s+TABLE|DROP\s+TABLE\s+IF\s+EXISTS|DROP\s+VIEW|DROP\s+VIEW\s+IF\s+EXISTS|CREATE\s+TABLE|CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS|UPDATE|UPDATE\s+IGNORE|FROM|ALTER\s+TABLE|ALTER\s+IGNORE\s+TABLE)\s+`\b(.*)\b`/'),
				array("\${1} `".$prefix.$scriptPrefix."\${2}`"),
				$string);
			
			$arr = preg_split('/;(\s+)?\n/', $string);
			
			$dbo->query("START TRANSACTION;");
			foreach ($arr as $statement)
			{
				$statement = trim($statement);
				if (!empty($statement))
				{
					if (!$dbo->query($statement))
					{
						$error = $dbo->error();
						$dbo->query("ROLLBACK");
						return $error;
					}
				}
			}
			$dbo->query("COMMIT;");
			
			return TRUE;
		}
		return FALSE;
	}

	private static function pjActionGetPaths()
	{
		$absolutepath = str_replace("\\", "/", dirname(realpath(basename(getenv("SCRIPT_NAME")))));
		$localpath = str_replace("\\", "/", dirname(getenv("SCRIPT_NAME")));
		
		$localpath = str_replace("\\", "/", $localpath);
		$localpath = preg_replace('/^\//', '', $localpath, 1) . '/';
		$localpath = !in_array($localpath, array('/', '\\')) ? $localpath : NULL;

		return array(
			'install_folder' => '/' . $localpath,
			'install_path' => $absolutepath . '/',
			'install_url' => 'http://' . $_SERVER['SERVER_NAME'] . '/' . $localpath
		);
	}

	public function pjActionIndex()
	{
		pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep0&install=1");
	}
	
	private static function pjActionCheckConfig($redirect=true)
	{
		$filename = 'app/config/config.inc.php';
		$content = @file_get_contents($filename);
		if (strpos($content, 'PJ_HOST') === false && strpos($content, 'PJ_INSTALL_URL') === false)
		{
			//Continue with installation
			return true;
		} else {
			if ($redirect)
			{
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep0&install=1");
			}
			return false;
		}
	}
	
	private function pjActionCheckSession()
	{
		if (!isset($_SESSION[$this->defaultInstaller]))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}
	}
	
	private function pjActionCheckTables(&$dbo)
	{
		if (!is_object($dbo))
		{
			return FALSE;
		}
		ob_start();
		readfile('app/config/database.sql');
		$string = ob_get_contents();
		ob_end_clean();

		preg_match_all('/DROP\s+TABLE(\s+IF\s+EXISTS)?\s+`(\w+)`/i', $string, $match);
		if (count($match[0]) > 0)
		{
			$arr = array();
			foreach ($match[2] as $k => $table)
			{
				$result = $dbo->query(sprintf("SHOW TABLES FROM `%s` LIKE '%s'",
					$_SESSION[$this->defaultInstaller]['database'],
					$_SESSION[$this->defaultInstaller]['prefix'] . $table
				));
				if ($result !== FALSE && $dbo->numRows() > 0)
				{
					$row = $dbo->fetchAssoc()->getData();
					$row = array_values($row);
					$arr[] = $row[0];
				}
			}
			return count($arr) === 0;
		}
		return TRUE;
	}
	
	private function pjActionCheckVars()
	{
		return isset(
			$_GET['install'],
			$_SESSION[$this->defaultInstaller],
			$_SESSION[$this->defaultInstaller]['hostname'],
			$_SESSION[$this->defaultInstaller]['username'],
			$_SESSION[$this->defaultInstaller]['password'],
			$_SESSION[$this->defaultInstaller]['database'],
			$_SESSION[$this->defaultInstaller]['prefix'],
			$_SESSION[$this->defaultInstaller]['admin_email'],
			$_SESSION[$this->defaultInstaller]['admin_password'],
			$_SESSION[$this->defaultInstaller]['private_key'],
			$_SESSION[$this->defaultInstaller]['install_folder'],
			$_SESSION[$this->defaultInstaller]['install_path'],
			$_SESSION[$this->defaultInstaller]['install_url'],
			$_SESSION[$this->defaultInstaller]['license_key']
		);
	}
	
	public function pjActionStep0()
	{
		if (self::pjActionCheckConfig(false))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}
	}
	
	public function pjActionStep1()
	{
		self::pjActionCheckConfig();
		
		if (!isset($_SESSION[$this->defaultInstaller]))
		{
			$_SESSION[$this->defaultInstaller] = array();
		}
		if (!isset($_SESSION[$this->defaultErrors]))
		{
			$_SESSION[$this->defaultErrors] = array();
		}
		
		# PHP Session check -------------------
		if (!headers_sent())
		{
			@session_start();
			$_SESSION['PJ_SESSION_CHECK'] = 1;
			@session_write_close();
			
			$_SESSION = array();
			@session_start();
			
			$session_check = isset($_SESSION['PJ_SESSION_CHECK']);
			$this->set('session_check', $session_check);
			if ($session_check)
			{
				$_SESSION['PJ_SESSION_CHECK'] = NULL;
				unset($_SESSION['PJ_SESSION_CHECK']);
			}
		}
		
		ob_start();
		phpinfo(INFO_MODULES);
		$content = ob_get_contents();
		ob_end_clean();
		
		# MySQL version -------------------
		if (!PJ_DISABLE_MYSQL_CHECK)
		{
			$drivers = array('mysql', 'mysqli');
			$mysql_version = NULL;
			foreach ($drivers as $driver)
			{
				$mysql_content = explode('name="module_'.$driver.'"', $content);
				if (count($mysql_content) > 1)
				{
					$mysql_content = explode("Client API", $mysql_content[1]);
					if (count($mysql_content) > 1)
					{
						preg_match('/<td class="v">(.*)<\/td>/', $mysql_content[1], $m);
						if (count($m) > 0)
						{
							$mysql_version = trim($m[1]);
							
							if (preg_match('/(\d+\.\d+\.\d+)/', $mysql_version, $m))
							{
								$mysql_version = $m[1];
							}
						}
					}
				}
			
				$mysql_check = true;
				if (is_null($mysql_version) || version_compare($mysql_version, '5.0.0', '<'))
				{
					$mysql_check = false;
				}
			}
			$this->set('mysql_check', $mysql_check);
		}
		
		# PHP version -------------------
		$php_check = true;
		if (version_compare(phpversion(), '5.1.0', '<'))
		{
			$php_check = false;
		}
		$this->set('php_check', $php_check);

		# File permissions
		$filename = 'app/config/config.inc.php';
		$err_arr = array();
		if (!is_writable($filename))
		{
		    $err_arr[] = sprintf('%1$s \'<span class="bold">%2$s</span>\' is not writable. %3$s \'<span class="bold">%2$s</span>\'', 'File', $filename, 'You need to set write permissions (chmod 777) to options file located at');
		}

		# Folder permissions
		$folders = array();
		foreach ($folders as $dir)
		{
			if (!is_writable($dir))
			{
				$err_arr[] = sprintf('%1$s \'<span class="bold">%2$s</span>\' is not writable. %3$s \'<span class="bold">%2$s</span>\'', 'Folder', $dir, 'You need to set write permissions (chmod 777) to directory located at');
			}
		}
		
		# Script (file/folder) permissions
		$result = $this->requestAction(array(
			'controller' => 'pjAppController',
			'action' => 'pjActionCheckInstall'
		), array('return'));
		
		if ($result !== NULL && isset($result['status'], $result['info']) && $result['status'] == 'ERR')
		{
			$err_arr = array_merge($err_arr, $result['info']);
		}
		
		# Plugin (file/folder) permissions
		$filename = 'app/config/options.inc.php';
		$options = @file_get_contents($filename);
		if ($options !== FALSE)
		{
			preg_match('/\$CONFIG\s*\[\s*[\'\"]plugins[\'\"]\s*\](.*);/sxU', $options, $match);
			if (!empty($match))
			{
				eval($match[0]);
			
				if (isset($CONFIG['plugins']))
				{
					if (!is_array($CONFIG['plugins']))
					{
						$CONFIG['plugins'] = array($CONFIG['plugins']);
					}
					foreach ($CONFIG['plugins'] as $plugin)
					{
						$result = $this->requestAction(array(
							'controller' => $plugin,
							'action' => 'pjActionCheckInstall'
						), array('return'));

						if ($result !== NULL && isset($result['status'], $result['info']) && $result['status'] == 'ERR')
						{
							$err_arr = array_merge($err_arr, $result['info']);
						}
					}
				}
			}
		}

		$this->set('folder_check', count($err_arr) === 0);
		$this->set('folder_arr', $err_arr);
			
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep2()
	{
		self::pjActionCheckConfig();
		
		$this->pjActionCheckSession();
		
		if (isset($_POST['step1']))
		{
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step1']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep1&install=1");
		}
		
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionStep3()
	{
		self::pjActionCheckConfig();
		
		$this->pjActionCheckSession();
		
		if (isset($_POST['step2']))
		{
			$_POST = array_map('trim', $_POST);
			$_POST = pjSanitize::clean($_POST, array('encode' => false));
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
			
			$err = NULL;
			
			if (!isset($_POST['hostname']) || !isset($_POST['username']) || !isset($_POST['database']) ||
				!pjValidation::pjActionNotEmpty($_POST['hostname']) ||
				!pjValidation::pjActionNotEmpty($_POST['username']) ||
				!pjValidation::pjActionNotEmpty($_POST['database']))
			{
				$err = "Hostname, Username and Database are required and can't be empty.";
			} else {
				
				$driver = function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';
				$params = array(
					'hostname' => $_POST['hostname'],
					'username' => $_POST['username'],
					'password' => $_POST['password'],
					'database' => $_POST['database']
				);
				if (strpos($params['hostname'], ":") !== FALSE)
				{
					list($hostname, $value) = explode(":", $params['hostname'], 2);
					if (preg_match('/\D/', $value))
					{
						$params['socket'] = $value;
					} else {
						$params['port'] = $value;
					}
					$params['hostname'] = $hostname;
				}
				$dbo = pjSingleton::getInstance($driver, $params);
				if (!$dbo->init())
				{
					$err = $dbo->connectError();
					if (empty($err))
					{
						$err = $dbo->error();
					}
				} else {
					if (!$this->pjActionCheckTables($dbo))
					{
						$this->set('warning', 1);
					}
					
					$tempTable = 'stivasoft_temp_install';
					
					$dbo->query("DROP TABLE IF EXISTS `$tempTable`;");
					
					if (!$dbo->query("CREATE TABLE IF NOT EXISTS `$tempTable` (`created` datetime DEFAULT NULL);"))
					{
						$err .= "CREATE command denied to current user<br />";
					} else {
						if (!$dbo->query("INSERT INTO `$tempTable` (`created`) VALUES (NOW());"))
						{
							$err .= "INSERT command denied to current user<br />";
						}
						if (!$dbo->query("SELECT * FROM `$tempTable` WHERE 1=1;"))
						{
							$err .= "SELECT command denied to current user<br />";
						}
						if (!$dbo->query("UPDATE `$tempTable` SET `created` = NOW();"))
						{
							$err .= "UPDATE command denied to current user<br />";
						}
						if (!$dbo->query("DELETE FROM `$tempTable` WHERE 1=1;"))
						{
							$err .= "DELETE command denied to current user<br />";
						}
					}
					if (!$dbo->query("DROP TABLE IF EXISTS `$tempTable`;"))
					{
						$err .= "DROP command denied to current user<br />";
					}
				}
			}
			if (!is_null($err))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = $err;
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep2&install=1&err=" . $time);
			}
			
			$this->set('paths', self::pjActionGetPaths());
			
			$this->set('status', 'ok');
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step2']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep2&install=1");
		}
		
		/* else if (isset($_SESSION[$this->defaultInstaller])) {
			$this->set('status', 'ok');
		}*/
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}

	public function pjActionStep4()
	{
		self::pjActionCheckConfig();
		
		$this->pjActionCheckSession();
		
		if (isset($_POST['step3']))
		{
			$_POST = array_map('trim', $_POST);
			
			if (!isset($_POST['install_folder']) || !isset($_POST['install_url']) || !isset($_POST['install_path']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_folder']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_url']) ||
				!pjValidation::pjActionNotEmpty($_POST['install_path']))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = "Folder Name, Full URL and Server Path are required and can't be empty.";
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep3&install=1&err=" . $time);
			} else {
				$_POST = pjSanitize::clean($_POST, array('encode' => false));
				$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
			}
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step3']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep3&install=1");
		}
		
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionStep5()
	{
		self::pjActionCheckConfig();
		
		$this->pjActionCheckSession();
		
		if (isset($_POST['step4']))
		{
			$_POST = array_map('trim', $_POST);
			
			if (!isset($_POST['admin_email']) || !isset($_POST['admin_password']) ||
				!pjValidation::pjActionNotEmpty($_POST['admin_email']) ||
				!pjValidation::pjActionEmail($_POST['admin_email']) ||
				!pjValidation::pjActionNotEmpty($_POST['admin_password']))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = "E-Mail and Password are required and can't be empty.";
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep4&install=1&err=" . $time);
			} else {
				$_POST = pjSanitize::clean($_POST, array('encode' => false));
				$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
			}
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step4']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep4&install=1");
		}
		
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionStep6()
	{
		self::pjActionCheckConfig();
		
		$this->pjActionCheckSession();
		
		if (isset($_POST['step5']))
		{
			$_POST = array_map('trim', $_POST);
			
			if (!isset($_POST['license_key']) || !pjValidation::pjActionNotEmpty($_POST['license_key']))
			{
				$time = time();
				$_SESSION[$this->defaultErrors][$time] = "License Key is required and can't be empty.";
				pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep5&install=1&err=" . $time);
			} else {
				$_POST = pjSanitize::clean($_POST, array('encode' => false));
				$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
				
				$Http = new pjHttp();
				$Http->request(base64_decode("aHR0cDovL3N1cHBvcnQuc3RpdmFzb2Z0LmNvbS8=") . 'index.php?controller=Api&action=newInstall&key=' . urlencode($_POST['license_key']) .
					"&version=". urlencode(PJ_SCRIPT_VERSION) ."&script_id=" . urlencode(PJ_SCRIPT_ID) .
					"&server_name=" . urlencode($_SERVER['SERVER_NAME']) . "&ip=" . urlencode($_SERVER['REMOTE_ADDR']) .
					"&referer=" . urlencode($_SERVER['HTTP_REFERER']));
				$resp = $Http->getResponse();
				$error = $Http->getError();
				$time = time();
				if ($resp === FALSE || (!empty($error) && $error['code'] == 109))
				{
					$_SESSION[$this->defaultErrors][$time] = "Installation key cannot be verified. Please, make sure you install on a server which is connected to the internet.";
					pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep5&install=1&err=" . $time);
				} else {
					$output = unserialize($resp);
				
					if (isset($output['hash']) && isset($output['code']) && $output['code'] == 200)
					{
						$_SESSION[$this->defaultInstaller]['private_key'] = $output['hash'];
					} else {
						$text = 'Key is wrong or not valid. Please check you data again.';
						if (isset($output['code']))
						{
							switch ((int) $output['code'])
							{
								case 101:
									$text = 'License key is not valid';
									break;
								case 106:
									$text = 'Number of installations allowed has been reached';
									break;
							}
						}

						$_SESSION[$this->defaultErrors][$time] = $text;
						pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep5&install=1&err=" . $time);
					}
				}
			}
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step5']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep5&install=1");
		}
		
		$this->appendJs('jquery.validate.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
		$this->appendJs('pjInstaller.js', $this->getConst('PLUGIN_JS_PATH'));
	}
	
	public function pjActionStep7()
	{
		$this->pjActionCheckSession();
		
		if (isset($_POST['step6']))
		{
			$_POST = pjSanitize::clean($_POST, array('encode' => false));
			$_SESSION[$this->defaultInstaller] = array_merge($_SESSION[$this->defaultInstaller], $_POST);
		}
		
		if (!isset($_SESSION[$this->defaultInstaller]['step6']))
		{
			pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjInstaller&action=pjActionStep6&install=1");
		}
		
		unset($_SESSION[$this->defaultInstaller]);
		unset($_SESSION[$this->defaultErrors]);
	}
	
	public function pjActionSetDb()
	{
		$this->setAjax(true);

		if ($this->isXHR())
		{
			if (!self::pjActionCheckVars())
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 108, 'text' => 'Missing, empty or invalid parameters.'));
			}
			@set_time_limit(300); //5 minutes
			
			$resp = array();
			
			$driver = function_exists('mysqli_connect') ? 'pjMysqliDriver' : 'pjMysqlDriver';
			$params = array(
				'hostname' => $_SESSION[$this->defaultInstaller]['hostname'],
				'username' => $_SESSION[$this->defaultInstaller]['username'],
				'password' => $_SESSION[$this->defaultInstaller]['password'],
				'database' => $_SESSION[$this->defaultInstaller]['database']
			);
			if (strpos($params['hostname'], ":") !== FALSE)
			{
				list($hostname, $value) = explode(":", $params['hostname'], 2);
				if (preg_match('/\D/', $value))
				{
					$params['socket'] = $value;
				} else {
					$params['port'] = $value;
				}
				$params['hostname'] = $hostname;
			}
			$dbo = pjSingleton::getInstance($driver, $params);
			if (!$dbo->init())
			{
				$err = $dbo->connectError();
				if (!empty($err))
				{
					$resp['code'] = 100;
				    $resp['text'] = 'Could not connect: ' . $err;
				    self::pjActionDbError($resp);
				} else {
					$resp['code'] = 101;
				    $resp['text'] = $dbo->error();
				    self::pjActionDbError($resp);
				}
			} else {
				$idb = self::pjActionImportSQL($dbo, 'app/config/database.sql', $_SESSION[$this->defaultInstaller]['prefix']);
				if ($idb === true)
				{
					$_GET['install'] = 2;
					require 'app/config/options.inc.php';
					
					$result = $this->requestAction(array(
						'controller' => 'pjAppController',
						'action' => 'pjActionBeforeInstall'
					), array('return'));
					
					if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
					{
						$resp['text'] = join("<br>", $result['info']);
						$resp['code'] = 104;
						self::pjActionDbError($resp);
					}
					
					if (isset($CONFIG['plugins']))
					{
						if (!is_array($CONFIG['plugins']))
						{
							$CONFIG['plugins'] = array($CONFIG['plugins']);
						}
						foreach ($CONFIG['plugins'] as $plugin)
						{
							$file = PJ_PLUGINS_PATH . $plugin . '/config/database.sql';
							if (is_file($file))
							{
								$response = self::pjActionExecuteSQL($dbo, $file, $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
								if ($response['status'] == "ERR")
								{
									self::pjActionDbError($response);
								}
								
								$update_folder = PJ_PLUGINS_PATH . $plugin . '/config/updates';
								if (is_dir($update_folder))
								{
									$files = array();
									pjToolkit::readDir($files, $update_folder);
									foreach ($files as $path)
									{
										if (preg_match('/\.sql$/', basename($path)) && is_file($path))
										{
											$response = self::pjActionExecuteSQL($dbo, $path, $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
											if ($response['status'] == "ERR")
											{
												self::pjActionDbError($response);
											}
										}
									}
								}
							}
							$model = $modelName = pjObject::getConstant($plugin, 'PLUGIN_MODEL');
							if (substr($model, -5) === 'Model')
							{
								$model = substr($model, 0, -5);
							}
							pjObject::import('Model', "$plugin:$model");
							if (class_exists($modelName) && method_exists($modelName, 'pjActionSetup'))
							{
								$pluginModel = new $modelName;
								$pluginModel->begin();
								$pluginModel->pjActionSetup();
								$pluginModel->commit();
							}

							$result = $this->requestAction(array(
								'controller' => $plugin,
								'action' => 'pjActionBeforeInstall'
							), array('return'));
							
							if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
							{
								$resp['text'] = join("<br>", $result['info']);
								$resp['code'] = 104;
								self::pjActionDbError($resp);
							}
						}
					}
					
					$updates = self::pjActionGetUpdates();
					foreach ($updates as $record)
					{
						$file_path = $record['path'];
						$response = self::pjActionExecuteSQL($dbo, $file_path, $_SESSION[$this->defaultInstaller]['prefix'], PJ_SCRIPT_PREFIX);
						if ($response['status'] == "ERR")
						{
							self::pjActionDbError($response);
						}
					}
					
					$result = $this->requestAction(array(
						'controller' => 'pjAppController',
						'action' => 'pjActionAfterInstall'
					), array('return'));
					
					if ($result !== NULL && isset($result['code']) && $result['code'] != 200 && isset($result['info']))
					{
						$resp['text'] = join("<br>", $result['info']);
						$resp['code'] = 105;
						self::pjActionDbError($resp);
					}

					pjUserModel::factory()
						->setPrefix($_SESSION[$this->defaultInstaller]['prefix'])
						->setAttributes(array(
							'email' => $_SESSION[$this->defaultInstaller]['admin_email'],
							'password' => $_SESSION[$this->defaultInstaller]['admin_password'],
							'role_id' => 1,
							'name' => "Administrator",
							'ip' => $_SERVER['REMOTE_ADDR']
						))
						->insert();
					
					pjOptionModel::factory()
						->setPrefix($_SESSION[$this->defaultInstaller]['prefix'])
						->setAttributes(array(
							'foreign_id' => $this->getForeignId(),
							'key' => 'private_key',
							'tab_id' => 99,
							'value' => $_SESSION[$this->defaultInstaller]['private_key'],
							'type' => 'string'
						))
						->insert();
					
					if (!isset($resp['code']))
					{
						$resp['code'] = 200;
					}
				} elseif ($idb === false) {
					$resp['code'] = 102; //File not found (can't be open/read)
					$resp['text'] = "File not found (or can't be read)";
					self::pjActionDbError($resp);
				} else {
					$resp['code'] = 103; //MySQL error
					$resp['text'] = $idb;
					self::pjActionDbError($resp);
				}
			}
			
			if (isset($resp['code']) && $resp['code'] != 200)
			{
				self::pjActionDbError($resp);
			}
			pjAppController::jsonResponse($resp);
		}
		exit;
	}
	
	private static function pjActionDbError($resp)
	{
		@file_put_contents('app/config/config.inc.php', '');
		pjAppController::jsonResponse($resp);
	}
	
	public function pjActionSetConfig()
	{
		$this->setAjax(true);
	
		if ($this->isXHR())
		{
			if (!self::pjActionCheckConfig(false))
			{
				pjAppController::jsonResponse(array('code' => 107, 'text' => 'Product is already installed. If you need to re-install it empty app/config/config.inc.php file.'));
			}
			$resp = array();
			
			$sample = 'app/config/config.sample.php';
			$filename = 'app/config/config.inc.php';
			ob_start();
			readfile($sample);
			$string = ob_get_contents();
			ob_end_clean();
			if ($string === FALSE)
			{
				$resp['code'] = 100;
				$resp['text'] = "An error occurs while reading 'app/config/config.sample.php'";
			} else {
				if (!self::pjActionCheckVars())
				{
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 108, 'text' => 'Missing, empty or invalid parameters.'));
				}
				$string = str_replace('[hostname]', $_SESSION[$this->defaultInstaller]['hostname'], $string);
				$string = str_replace('[username]', $_SESSION[$this->defaultInstaller]['username'], $string);
				$string = str_replace('[password]', str_replace(
						array('$'),
						array('\$'),
						$_SESSION[$this->defaultInstaller]['password']
					), $string);
				$string = str_replace('[database]', $_SESSION[$this->defaultInstaller]['database'], $string);
				$string = str_replace('[prefix]', $_SESSION[$this->defaultInstaller]['prefix'], $string);
				$string = str_replace('[install_folder]', $_SESSION[$this->defaultInstaller]['install_folder'], $string);
				$string = str_replace('[install_path]', $_SESSION[$this->defaultInstaller]['install_path'], $string);
				$string = str_replace('[install_url]', $_SESSION[$this->defaultInstaller]['install_url'], $string);
				$string = str_replace('[salt]', pjUtil::getRandomPassword(8), $string);
					
				$Http = new pjHttp();
				$Http->request(base64_decode("aHR0cDovL3N1cHBvcnQuc3RpdmFzb2Z0LmNvbS8=") . 'index.php?controller=Api&action=getInstall'.
					"&key=" . urlencode($_SESSION[$this->defaultInstaller]['license_key']) .
					"&modulo=". urlencode(PJ_RSA_MODULO) .
					"&private=" . urlencode(PJ_RSA_PRIVATE) .
					"&server_name=" . urlencode($_SERVER['SERVER_NAME']));
				$response = $Http->getResponse();
				$output = unserialize($response);
				
				if (isset($output['hash']) && isset($output['code']) && $output['code'] == 200)
				{
					$string = str_replace('[pj_installation]', $output['hash'], $string);
				
					if (is_writable($filename))
					{
					    if (!$handle = @fopen($filename, 'wb'))
					    {
							$resp['code'] = 103;
							$resp['text'] = "'app/config/config.inc.php' open fails";
					    } else {
						    if (fwrite($handle, $string) === FALSE)
						    {
								$resp['code'] = 102;
								$resp['text'] = "An error occurs while writing to 'app/config/config.inc.php'";
						    } else {
					    		fclose($handle);
					    		$resp['code'] = 200;
						    }
					    }
					} else {
						$resp['code'] = 101;
						$resp['text'] = "'app/config/config.inc.php' do not exists or not writable";
					}
				} else {
					$resp['code'] = 104;
					$resp['text'] = "Security vulnerability detected";
				}
			}
			pjAppController::jsonResponse($resp);
		}
		exit;
	}
	
	public function pjActionLicense()
	{
		$arr = pjOptionModel::factory()
			->where('t1.foreign_id', $this->getForeignId())
			->where('t1.key', 'private_key')
			->limit(1)
			->findAll()
			->getData();

		$hash = NULL;
		if (count($arr) === 1)
		{
			$hash = $arr[0]['value'];
		}
		pjUtil::redirect(base64_decode("aHR0cDovL3N1cHBvcnQuc3RpdmFzb2Z0LmNvbS9jaGVja2xpY2Vuc2Uv") . $hash);
	}

	public function pjActionVersion()
	{
		if ($this->isLoged())
		{
			printf('PJ_SCRIPT_ID: %s<br>', PJ_SCRIPT_ID);
			printf('PJ_SCRIPT_BUILD: %s<br><br>', PJ_SCRIPT_BUILD);
			
			$plugins = pjRegistry::getInstance()->get('plugins');
			foreach ($plugins as $plugin => $whtvr)
			{
				printf("%s: %s<br>", $plugin, pjObject::getConstant($plugin, 'PLUGIN_BUILD'));
			}
		}
		exit;
	}
	
	public function pjActionHash()
	{
		@set_time_limit(0);
		
		if (!function_exists('md5_file'))
		{
			die("Function <b>md5_file</b> doesn't exists");
		}
		
		require 'app/config/config.inc.php';
		
		# Origin hash -------------
		if (!is_file(PJ_CONFIG_PATH . 'files.check'))
		{
			die("File <b>files.check</b> is missing");
		}
		$json = @file_get_contents(PJ_CONFIG_PATH . 'files.check');
		$Services_JSON = new pjServices_JSON();
		$data = $Services_JSON->decode($json);
		if (is_null($data))
		{
			die("File <b>files.check</b> is empty or broken");
		}
		$origin = get_object_vars($data);
				
		# Current hash ------------
		$data = array();
		pjUtil::readDir($data, PJ_INSTALL_PATH);
		$current = array();
		foreach ($data as $file)
		{
			$current[str_replace(PJ_INSTALL_PATH, '', $file)] = md5_file($file);
		}
		
		$html = '<style type="text/css">
		table{border: solid 1px #000; border-collapse: collapse; font-family: Verdana, Arial, sans-serif; font-size: 14px}
		td{border: solid 1px #000; padding: 3px 5px; background-color: #fff; color: #000}
		.diff{background-color: #0066FF; color: #fff}
		.miss{background-color: #CC0000; color: #fff}
		</style>
		<table cellpadding="0" cellspacing="0">
		<tr><td><strong>Filename</strong></td><td><strong>Status</strong></td></tr>
		';
		foreach ($origin as $file => $hash)
		{
			if (isset($current[$file]))
			{
				if ($current[$file] == $hash)
				{
					
				} else {
					$html .= '<tr><td>'. $file . '</td><td class="diff">changed</td></tr>';
				}
			} else {
				$html .= '<tr><td>'. $file . '</td><td class="miss">missing</td></tr>';
			}
		}
		$html .= '<table>';
		echo $html;
		exit;
	}
	
	private static function pjActionGetUpdates($update_folder='app/config/updates', $override_data=array())
	{
		if (!is_dir($update_folder))
		{
			return array();
		}

		$files = array();
		pjToolkit::readDir($files, $update_folder);
		
		$data = array();
		foreach ($files as $path)
		{
			$name = basename($path);
			if (preg_match('/\.sql$/', $name))
			{
				$data[] = array_merge(array(
					'name' => $name,
					'path' => $path
				), $override_data);
			}
		}
			
		return $data;
	}
	
	private static function pjActionExecuteSQL($dbo, $file_path, $prefix=PJ_PREFIX, $scriptPrefix=PJ_SCRIPT_PREFIX)
	{
		$name = basename($file_path);
				
		$pdb = self::pjActionImportSQL($dbo, $file_path, $prefix, $scriptPrefix);
		
		if ($pdb === false)
		{
			$text = sprintf("File '%s' not found (or can't be read).", $name);
			return array('status' => 'ERR', 'code' => 102, 'text' => $text);
		} elseif ($pdb === true) {
			$text = sprintf("File '%s' have been executed.", $name);
			return array('status' => 'OK', 'code' => 200, 'text' => $text);
		} else {
			$text = sprintf("File '%s': %s", $name, $pdb);
			return array('status' => 'ERR', 'code' => 103, 'text' => $text);
		}
	}
	
	public function pjActionSecureSetUpdate()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			# Next will init dbo
			pjAppModel::factory();
			
			$dbo = NULL;
			$registry = pjRegistry::getInstance();
			if ($registry->is('dbo'))
			{
				$dbo = $registry->get('dbo');
			}
			
			if (!isset($_REQUEST['module']))
			{
				pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Module parameter is missing.'));
			}
			switch ($_REQUEST['module'])
			{
				case 'plugin':
					$pattern = '|^'.str_replace('\\', '/', PJ_PLUGINS_PATH).'|';
					break;
				case 'script':
				default:
					$pattern = '|^app/config/updates|';
					break;
			}
			
			if (isset($_POST['path']) && !empty($_POST['path']))
			{
				if (preg_match($pattern, str_replace('\\', '/', $_POST['path'])))
				{
					$response = self::pjActionExecuteSQL($dbo, $_POST['path']);
					pjAppController::jsonResponse($response);
				} else {
					pjAppController::jsonResponse(array('status' => 'ERR', 'code' => 100, 'text' => 'Filename pattern doesn\'t match.'));
				}
			}
			
			if (isset($_POST['record']) && !empty($_POST['record']))
			{
				foreach ($_POST['record'] as $record)
				{
					if (!preg_match($pattern, str_replace('\\', '/', $record)))
					{
						continue;
					}
					$response = self::pjActionExecuteSQL($dbo, $record);
					if ($response !== TRUE)
					{
						pjAppController::jsonResponse($response);
					}
				}
				
				pjAppController::jsonResponse($response);
			}
		}
		exit;
	}
	
	public function pjActionSecureGetUpdate()
	{
		$this->setAjax(true);
	
		if ($this->isXHR() && $this->isLoged())
		{
			$data = array();
			if (isset($_GET['module']))
			{
				switch ($_GET['module'])
				{
					case 'plugin':
						if (isset($GLOBALS['CONFIG']['plugins']))
						{
							if (!is_array($GLOBALS['CONFIG']['plugins']))
							{
								$GLOBALS['CONFIG']['plugins'] = array($GLOBALS['CONFIG']['plugins']);
							}
							foreach ($GLOBALS['CONFIG']['plugins'] as $plugin)
							{
								$data = array_merge($data, self::pjActionGetUpdates(PJ_PLUGINS_PATH . $plugin . '/config/updates', array('plugin' => $plugin)));
							}
						}
						break;
					case 'script':
						$data = self::pjActionGetUpdates();
						break;
				}
			}
			
			$total = count($data);
			$rowCount = $total;
			$pages = 1;
			$page = 1;
			$offset = 0;
						
			pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
		}
		exit;
	}
	
	public function pjActionSecureUpdate()
	{
		if ($this->isLoged())
		{
			$this->appendJs('jquery-1.8.3.min.js', $this->getConst('PLUGIN_LIBS_PATH'));
	    	$this->appendJs('jquery-ui.custom.min.js', PJ_THIRD_PARTY_PATH . 'jquery_ui/js/');
			$this->appendCss('jquery-ui.min.css', PJ_THIRD_PARTY_PATH . 'jquery_ui/css/smoothness/');
			$this->appendCss('pj-table.css', PJ_FRAMEWORK_LIBS_PATH . 'pj/css/');
			
			$this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
			$this->appendJs('pjInstallerUpdate.js', $this->getConst('PLUGIN_JS_PATH'));
			$this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', "");
		} else {
			$this->set('status', 2);
		}
	}
}
?>