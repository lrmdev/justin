<?php
class pjSmsApi
{
	private $apiKey;
	
	private $number;
	
	private $text;
	
	private $url = 'http://www.phpjabbers.com/web-sms/api/send.php';
	
	public function send()
	{
		$pjHttp = new pjHttp();
		
		$params = http_build_query(array(
			'number' => $this->number,
			'message' => substr($this->text, 0, 160),
			'key' => $this->apiKey
		));
		
		return $pjHttp->request($this->url ."?". $params)->getResponse();
	}
	
	public function setApiKey($str)
	{
		$this->apiKey = $str;
		return $this;
	}
	
	public function setNumber($str)
	{
		$this->number = $str;
		return $this;
	}
	
	public function setText($str)
	{
		$this->text = $str;
		return $this;
	}
}
?>