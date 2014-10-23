<?php
if (!defined("ROOT_PATH"))
{
	header("HTTP/1.1 403 Forbidden");
	exit;
}
class pjCart
{
	private $session = array();
	
	public function __construct(&$session)
	{
		$this->session =& $session;
		
		return $this;
	}
	
	public function add($type, $article_id, $size_id, $qty)
	{
		if ($this->check($type, $article_id, $size_id))
		{
			$this->increase($type, $article_id, $size_id, $qty);
		} else {
			$this->insert($type, $article_id, $size_id, $qty);
		}
		
		return $this;
	}
	
	public function check($type, $article_id, $size_id)
	{
		return array_key_exists($type, $this->session) &&
			array_key_exists($article_id, $this->session[$type]) &&
			array_key_exists($size_id, $this->session[$type][$article_id]);
	}
	
	public function decrease($type, $article_id, $size_id, $qty)
	{
		$this->session[$type][$article_id][$size_id] -= intval($qty);
		
		if ($this->session[$type][$article_id][$size_id] < 0)
		{
			$this->session[$type][$article_id][$size_id] = 0;
		}
		
		return $this;
	}
		
	public function increase($type, $article_id, $size_id, $qty)
	{
		$this->session[$type][$article_id][$size_id] += intval($qty);
		
		return $this;
	}
	
	public function insert($type, $article_id, $size_id, $qty)
	{
		$this->session[$type][$article_id][$size_id] = intval($qty);
		
		return $this;
	}
	
	public function remove($type, $article_id, $size_id)
	{
		if ($this->check($type, $article_id, $size_id))
		{
			unset($this->session[$type][$article_id][$size_id]);
			if (empty($this->session[$type][$article_id]))
			{
				unset($this->session[$type][$article_id]);
			}
			if (empty($this->session[$type]))
			{
				unset($this->session[$type]);
			}
		}
		
		return $this;
	}

	public function update($type, $article_id, $size_id, $qty)
	{
		$this->session[$type][$article_id][$size_id] = intval($qty);
		
		if ($this->session[$type][$article_id][$size_id] < 0)
		{
			$this->session[$type][$article_id][$size_id] = 0;
		}
		
		return $this;
	}
	
	public function reset()
	{
		$this->session = array();

		return $this;
	}
	
	public function getAll()
	{
		return $this->session;
	}
	
	public function isEmpty()
	{
		return empty($this->session);
	}
	
	public function getCount()
	{
		$cnt = 0;
		foreach ($this->session as $cid => $items)
		{
			foreach ($items as $item)
			{
				$cnt += count($item);
			}
		}
		
		return $cnt;
	}
}
?>