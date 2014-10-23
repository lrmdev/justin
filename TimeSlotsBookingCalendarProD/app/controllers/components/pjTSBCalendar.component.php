<?php
require_once dirname(__FILE__) . '/pjCalendar.component.php';
class pjTSBCalendar extends pjCalendar
{
	private $dayoff = array();
	
	private $dateoff = array();
	
	private $monthStatus = array();
	
	public function __construct()
	{
		parent::__construct();
		
		$this->classTable = "tsCalendarTable";
		$this->classWeekDay = "tsCalendarWeekDay";
		$this->classMonth = "tsCalendarMonth";
		$this->classMonthOuter = "tsCalendarMonthOuter";
		$this->classMonthInner = "tsCalendarMonthInner";
		$this->classMonthPrev = "tsCalendarMonthPrev";
		$this->classMonthNext = "tsCalendarMonthNext";
		$this->classPartly = "tsCalendarPartly";
		$this->classFully = "tsCalendarFully";
		$this->classDayoff = "tsCalendarDayoff";
		$this->classCalendar = "tsCalendarDate";
		$this->classCell = "tsCalendarCell";
		$this->classToday = "tsCalendarToday";
		$this->classSelected = "tsCalendarSelected";
		$this->classEmpty = "tsCalendarEmpty";
		$this->classWeekNum = "tsCalendarWeekNum";
		$this->classPast = "tsCalendarPast";
		$this->classDateOuter = "tsCalendarDateOuter";
		$this->classDateInner = "tsCalendarDateInner";
	}
	
	public function getMonthView($month, $year)
    {
        return $this->getMonthHTML($month, $year, 1);
    }
    
	public function getCalendarLink($month, $year)
	{
		return array('href' => '#', 'onclick' => '', 'class' => 'tsCalendarLinkMonth');
	}
	
	public function set($key, $value)
	{
		if (in_array($key, array('calendarId', 'weekNumbers', 'options', 'dayoff', 'dateoff', 'monthStatus')))
		{
			$this->$key = $value;
		}

		return $this;
	}
	
	public function getLegend($locale)
	{
		$html = '
		<div class="tsSelectorLegend tsLegendContainer" style="display:none">
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendAvailable"></span><span class="tsLegendLabel">'.@$locale['available'].'</span></div>
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendToday"></span><span class="tsLegendLabel">'.@$locale['today'].'</span></div>
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendFully"></span><span class="tsLegendLabel">'.@$locale['fully'].'</span></div>
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendPartly"></span><span class="tsLegendLabel">'.@$locale['partly'].'</span></div>
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendDayoff"></span><span class="tsLegendLabel">'.@$locale['dayoff'].'</span></div>
			<div class="tsLegendItem"><span class="tsLegendColor tsLegendPast"></span><span class="tsLegendLabel">'.@$locale['past'].'</span></div>
		</div>';
		
		return $html;
	}
	
	private function getClass($status)
	{
		$class = $this->classCalendar;
		
		switch ($status)
		{
			case 'partly':
				$class = $this->classCalendar ." ". $this->classPartly;
				break;
			case 'fully':
				$class = $this->classFully;
				break;
			case 'available':
			default:
				$class = $this->classCalendar;
				break;
		}
		
		return $class;
	}
	
	protected function onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $d)
    {
    	$date = getdate($timestamp);
    	$weekday = strtolower($date['weekday']);
    	
		if ($timestamp < $today[0])
		{
			$class = $this->classPast;
			
		} elseif (!empty($this->dateoff[$iso])) {
			
			switch ($this->dateoff[$iso]['is_dayoff'])
			{
				case 'T':
					$class = $this->classDayoff;
					break;
				case 'F':
					$class = $this->getClass($this->monthStatus[$iso]['text']);
					break;
			}
			
		} elseif (isset($this->dayoff[$weekday])) {
			
			$class = $this->classDayoff;
			
		} else {
			$class = $this->getClass($this->monthStatus[$iso]['text']);
		}
		
		if ($class == $this->classCalendar)
		{
			if ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"])
			{
				$class .= " " . $this->classToday;
			}
		}

		return array(
			'class' => $class,
			'html' => '<div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">'.$d.'</p></div>'
		);
    }
}
?>