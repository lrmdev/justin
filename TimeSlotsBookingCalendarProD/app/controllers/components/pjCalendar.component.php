<?php
class pjCalendar
{
    private $startDay = 0;

    private $startMonth = 1;

    private $currentDate = NULL;
    
    private $dayNames = array("S", "M", "T", "W", "T", "F", "S");

    private $monthNames = array(
    	1 => "January",
    	2 => "February",
    	3 => "March",
    	4 => "April",
    	5 => "May",
    	6 => "June",
    	7 => "July",
    	8 => "August",
    	9 => "September",
    	10 => "October",
    	11 => "November",
    	12 => "December"
    );

    private $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
    private $showNextLink = true;
    
    private $showPrevLink = true;

    private $weekNumbers = false;
    
    private $weekTitle = "#";
    
    private $prevLink = "&lt;";
    
    private $nextLink = "&gt;";
    
    private $options = array(
    	'o_month_year_format' => 'Month, Year'
    );
    
    protected $classTable = "abCalendarTable";
    protected $classWeekDay = "abCalendarWeekDay";
    protected $classMonth = "abCalendarMonth";
    protected $classMonthOuter = "abCalendarMonthOuter";
    protected $classMonthInner = "abCalendarMonthInner";
    protected $classMonthPrev = "abCalendarMonthPrev";
    protected $classMonthNext = "abCalendarMonthNext";
    protected $classCalendar = "abCalendarDate";
    protected $classCell = "abCalendarCell";
    protected $classToday = "abCalendarToday";
    protected $classSelected = "abCalendarSelected";
    protected $classEmpty = "abCalendarEmpty";
    protected $classWeekNum = "abCalendarWeekNum";
    protected $classPast = "abCalendarPast";
	protected $classDateOuter = "abCalendarDateOuter";
	protected $classDateInner = "abCalendarDateInner";
    
    public function __construct()
    {
    	$this->setCurrentDate(time());
    }
    
    public function setPrevLink($value)
    {
    	$this->prevLink = $value;
    	return $this;
    }
    
	public function setNextLink($value)
    {
    	$this->nextLink = $value;
    	return $this;
    }
    
	public function getPrevLink()
    {
    	return $this->prevLink;
    }
    
	public function getNextLink()
    {
    	return $this->nextLink;
    }
    
    public function setShowNextLink($value)
    {
    	if (is_bool($value))
    	{
    		$this->showNextLink = $value;
    	}
    	return $this;
    }
    
    public function getShowNextLink()
    {
    	return $this->showNextLink;
    }
    
	public function setShowPrevLink($value)
    {
    	if (is_bool($value))
    	{
    		$this->showPrevLink = $value;
    	}
    	return $this;
    }
    
    public function getShowPrevLink()
    {
    	return $this->showPrevLink;
    }

 	public function getCurrentDate()
    {
        return $this->currentDate;
    }

    public function setCurrentDate($time)
    {
        $this->currentDate = $time;
        return $this;
    }
    
    public function getDayNames()
    {
        return $this->dayNames;
    }

    public function setDayNames($names)
    {
        $this->dayNames = $names;
        return $this;
    }

    public function getMonthNames()
    {
        return $this->monthNames;
    }

    public function setMonthNames($names)
    {
        $this->monthNames = $names;
        return $this;
    }

    public function getStartDay()
    {
        return $this->startDay;
    }

    public function setStartDay($day)
    {
        $this->startDay = $day;
        return $this;
    }

    public function getStartMonth()
    {
        return $this->startMonth;
    }

    public function setStartMonth($month)
    {
        $this->startMonth = $month;
        return $this;
    }
    
	public function getWeekNumbers()
    {
        return $this->weekNumbers;
    }

    public function setWeekNumbers($value)
    {
        $this->weekNumbers = (bool) $value;
        return $this;
    }

    public function getCalendarLink($month, $year)
    {
        return "";
    }

    public function getDateLink($day, $month, $year)
    {
        return "";
    }

    public function getCurrentMonthView()
    {
        $d = getdate(time());
        return $this->getMonthView($d["mon"], $d["year"]);
    }

    public function getMonthView($month, $year)
    {
        return $this->getMonthHTML($month, $year);
    }

    public function getDaysInMonth($month, $year)
    {
        if ($month < 1 || $month > 12)
        {
            return 0;
        }
   
        $d = $this->daysInMonth[$month - 1];
   
        if ($month == 2)
        {
            if ($year%4 == 0)
            {
                if ($year%100 == 0)
                {
                    if ($year%400 == 0)
                    {
                        $d = 29;
                    }
                } else {
                    $d = 29;
                }
            }
        }
    
        return $d;
    }

    protected function onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $d)
    {
		if ($timestamp < $today[0])
		{
			$class = $this->classPast;
		} else {
			$class = $this->classCalendar;

			if ($year == $today["year"] && $month == $today["mon"] && $d == $today["mday"])
			{
				$class .= " " . $this->classToday;
			}
			if ($year == $current["year"] && $month == $current["mon"] && $d == $current["mday"])
			{
				$class .= " " . $this->classSelected;
			}
		}

		return array(
			'class' => $class,
			'html' => '<div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">'.$d.'</p></div>'
		);
    }
    
	public function getMonthHTML($m, $y, $showYear = 1)
	{
		$s = "";

		$a = $this->adjustDate($m, $y);
        $month = $a[0];
		$year = $a[1];
        
    	$daysInMonth = $this->getDaysInMonth($month, $year);
    	$date = getdate(mktime(12, 0, 0, $month, 1, $year));
    	
    	$first = $date["wday"];
    	$monthName = $this->monthNames[$month];
    	
    	$prev = $this->adjustDate($month - 1, $year);
    	$next = $this->adjustDate($month + 1, $year);
    	
    	if ($showYear == 1)
    	{
    	    $prevMonth = $this->getCalendarLink($prev[0], $prev[1]);
    	    $nextMonth = $this->getCalendarLink($next[0], $next[1]);
    	} else {
    	    $prevMonth = "";
    	    $nextMonth = "";
    	}
    	
    	$search = array('Month', 'Year');
    	$replace = array($monthName, $showYear > 0 ? $year : "");
    	$header = str_replace($search, $replace, $this->options['o_month_year_format']);
		    	
    	$prevM = ((int) $month - 1) < 1 ? 12 : (int) $month - 1;
    	$prevY = ((int) $month - 1) < 1 ? (int) $year - 1 : (int) $year;
    	
    	$nextM = ((int) $month + 1) > 12 ? 1 : (int) $month + 1;
    	$nextY = ((int) $month + 1) > 12 ? (int) $year + 1 : (int) $year;
    	
    	$cols = $this->getWeekNumbers() ? 8 : 7;
    	
    	$s .= "<table class=\"".$this->classTable."\" cellspacing=\"0\" cellpadding=\"0\">\n";
    	$s .= "<tbody><tr>\n";
    	$s .= "<td class=\"".$this->classMonth." ".$this->classMonthPrev."\">" . (!$this->getShowPrevLink() ? "&nbsp;" : '<div class="'.$this->classMonthInner.'"><a data-direction="prev" data-month="'.$prevM.'" data-year="'.$prevY.'" href="'.@$prevMonth['href'].'" class="'.@$prevMonth['class'].'">'.$this->getPrevLink().'</a></div>')  . "</td>\n";
    	$s .= "<td class=\"".$this->classMonth."\" colspan=\"".($cols == 7 ? 5 : 6)."\"><div class=\"".$this->classMonthOuter."\"><p class=\"".$this->classMonthInner."\">$header</p></div></td>\n";
    	$s .= "<td class=\"".$this->classMonth." ".$this->classMonthNext."\">" . (!$this->getShowNextLink() ? "&nbsp;" : '<div class="'.$this->classMonthInner.'"><a data-direction="next" data-month="'.$nextM.'" data-year="'.$nextY.'" href="'.@$nextMonth['href'].'" class="'.@$nextMonth['class'].'">'.$this->getNextLink().'</a></div>')  . "</td>\n";
    	$s .= "</tr>\n";
    	
    	$s .= "<tr>\n";
    	if ($this->getWeekNumbers())
    	{
    		$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->weekTitle, "\n");
    		$weekNumPattern = "<td class=\"".$this->classWeekNum."\"><div class=\"".$this->classDateOuter."\"><p class=\"".$this->classDateInner."\">{WEEK_NUM}</p></div></td>";
    	}
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+1)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+2)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+3)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+4)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+5)%7], "\n");
    	$s .= sprintf('<td class="%s"><div class="'.$this->classDateOuter.'"><p class="'.$this->classDateInner.'">%s</p></div></td>%s', $this->classWeekDay, $this->dayNames[($this->startDay+6)%7], "\n");
    	$s .= "</tr>\n";

    	$d = $this->startDay + 1 - $first;
    	while ($d > 1)
    	{
    	    $d -= 7;
    	}

        $today = getdate(strtotime("today midnight"));
		$current = getdate($this->getCurrentDate());
    	
        $rows = 0;
    	while ($d <= $daysInMonth)
    	{
    	    $s .= "<tr>\n";
    	    
    	    if ($this->getWeekNumbers())
    	    {
    	    	$s .= $weekNumPattern;
    	    }
    	    for ($i = 0; $i < 7; $i++)
    	    {
    	    	$timestamp = mktime(0, 0, 0, $month, $d, $year);
    	    	$iso = date('Y-m-d', $timestamp);

        	    if ($d < 1 || $d > $daysInMonth) {
        	    	$s .= '<td class="'.$this->classEmpty.'">&nbsp;</td>';
        	    } else {
        	    	$s .= $this->getCell($timestamp, $iso, $today, $current, $year, $month, $d);
        	    }
        	    $d++;
    	    }
    	    if ($this->getWeekNumbers())
    	    {
    	    	$s = str_replace('{WEEK_NUM}', date("W", $timestamp), $s);
    	    }
    	    $s .= "</tr>\n";
    	    $rows++;
    	}
    	
    	if ($rows == 5)
    	{
    		if ($cols == 7)
    		{
    			$s .= "<tr>" . str_repeat('<td class="'.$this->classEmpty.'">&nbsp;</td>', $cols) . "</tr>";
    		} else {
    			$s .= '<tr><td class="'.$this->classWeekNum.'">&nbsp;</td>' . str_repeat('<td class="'.$this->classEmpty.'">&nbsp;</td>', 7) . "</tr>";
    		}
    	}
    	
    	$s .= "</tbody></table>\n";

    	return $s;
    }

    protected function getCell($timestamp, $iso, $today, $current, $year, $month, $d)
    {
    	$result = $this->onBeforeShow($timestamp, $iso, $today, $current, $year, $month, $d);
    	
    	return '<td
			class="'.$this->classCell.' '.$result['class'].'"
			data-iso="'.$iso.'"
			data-time="'.$timestamp.'">'.$result['html'].'</td>';
    }
    
    static public function adjustDate($month, $year)
    {
        $a = array();
        $a[0] = $month;
        $a[1] = $year;
        
        while ($a[0] > 12)
        {
            $a[0] -= 12;
            $a[1]++;
        }
        
        while ($a[0] <= 0)
        {
            $a[0] += 12;
            $a[1]--;
        }
        
        return $a;
    }
}
?>