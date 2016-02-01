<?php

class calendar {
	
	// Events array
	private $events = array();
	// Defaults for day and month names
	private $dayNames = array ( 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá', 'Do');
	private $monthNames = array ( 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' );
	// Defaults for prev and next links
	private $prevMonthNavTxt = '<i class="fa fa-arrow-circle-left fa-lg"></i>';
	private $nextMonthNavTxt = '<i class="fa fa-arrow-circle-right fa-lg"></i>';
	private $calendarName;

	public function __construct($name='calendar') {
		// Assign name to calendar
		if (strpos($name, ' ') || strpos($name, '_') || is_numeric(substr($name, 0, 1)))
			throw new exception('El calendario debe tener un nombre CSS válido');
		$this->calendarName = $name;

		// Names for special cases
		$this->markup = array('current_day' => 'current-day',
							  'prev_month' => 'dia-mes-prev',
							  'next_month' => 'dia-mes-sig',
							  'event' => 'event',
							  'header' => 'header',
							  'nav' => 'nav',
							  'days_of_week' => 'days-of-week'
							 );
	}
	
	// Get calendar name
	public function getCalendarName(){
		return $this->calendarName;
	}

	// Set text for previous and next calendar links
	public function setNavigationText($prev, $next) {
		$this->prevMonthNavTxt = $prev;
		$this->nextMonthNavTxt = $next;
	}
	// Get text for previous and next calendar links
	public function getNavigationText() {
		return array(	'prev' => $this->prevMonthNavTxt,
						'next' => $this->nextMonthNavTxt
					);
	}

	// Set inner border width. Would be too annoying to do this with CSS
	public function setInnerBorder($size) {
		$this->innerBorder = intval($size);
	}
	// Set inner border width. Would be too annoying to do this with CSS
	public function getInnerBorder($size) {
		return $this->innerBorder;
	}

	// Set the names of the days
	public function setDayNames($array) {
		if (count($array) == 7)
			$this->dayNames = $array;
		else
			throw new exception ('Valor no válido para setDayNames()');
	}
	// Get the names of the days
	public function getDayNames($array) {
		return $this->dayNames;
	}

	// Set the names of the months
	public function setMonthNames($array) {
		if (count($array) == 12)
			$this->monthNames = $array;
		else
			throw new exception ('Valor no válido para setMonthNames()');
	}
	// Set the names of the months
	public function getMonthNames($array) {
		return $this->monthNames;
	}

	// Sets the calendar start day 0=monday, 1=sunday, 2=saturday etc...
	public function setStartDay($day) {
		if (is_int($day) && $day >= 0 && $day <=6) {
			$this->startDay=$day;
			for ($i=0;$i<$day;$i++)
			array_unshift($this->dayNames, array_pop($this->dayNames));
		}
		else
			throw new exception('Valor no válido para setStartDay()');
	}
	// Gets the calendar start day
	public function getStartDay($day) {
		return $this->startDay=$day;
	}

	// Enables prev and next month links
	public function enableNavigation() {
		$this->enableNav = true;
	}
	// Disables prev and next month links
	public function disableNavigation() {
		$this->enableNav = false;
	}
	
	// Enables prev and next month links
	public function enableYear() {
		$this->enableYear = true;
	}
	// Disables prev and next month links
	public function disableYear() {
		$this->enableYear = false;
	}

	// Gets the long name of the current month
	private function getMonthName() {
		return ucwords($this->monthNames[$this->month-1]);
	}
	// Get calendars month 1-12
	private function getMonth() {
		return $this->month;
	}
	// Get calendar year ####
	private function getYear() {
		return $this->year;
	}

	// Enables nicely formatted html instead of just one big line
	public function enablePrettyHTML() {
		$this->prettyHTML = true;
	}
	// Disables nicely formatted html instead of just one big line
	public function disablePrettyHTML() {
		$this->prettyHTML = false;
	}

	// Enables the displaying of prev and next month's days on the calendar
	public function enableNonMonthDays() {
		$this->displayNonMonthDays = true;
	}
	// Disables the displaying of previous and next month's days on the calendar
	public function disableNonMonthDays() {
		$this->displayNonMonthDays = false;
	}
	
	// get an event on a given date
	public function getEventByDate($year, $month, $day) {
		if (isset($this->events[$year][$month][$day]))
			return $this->events[$year][$month][$day];
		return FALSE;
	}

	// Add an event
	public function addEvent($eventTitle, $eventYear, $eventMonth, $eventDay, $eventLink) {
		$this->events[$eventYear][$eventMonth][$eventDay] = array(	'event_title' => $eventTitle, 'event_link' => $eventLink);
	}
	public function removeEvent($eventYear, $eventMonth, $eventDay) {
		unset($this->events[$eventYear][$eventMonth][$eventDay]);
	}

	// Offsets timestamp according to offset and returns the day month or year
	private function timeTravel($offset, $dmy, $timeStamp) {
		$dateVals = array (	'd' => 'j',
							'm' => 'n',
							'y' => 'Y'
							);
		return date($dateVals[$dmy], strtotime($offset, $timeStamp));
	}

	// Display calendar.true Supply month and year to override default value of current month
	public function display($month='', $year='') {
	
		// Remove whitespaces
		$year = trim($year);
		$month = trim($month);

		// Set day, month and year of calendar
		$this->day = 1;
		$this->month = ($month == '') ?	date('n') : $month;
		$this->year = ($year == '') ? date('Y') : $year;

		// Check for valid input	
		if (!preg_match('~[0-9]{4}~', $this->year))
			throw new exception('Año no válido');
		if (!is_numeric($this->month) || $this->month < 0 || $this->month > 13)
			throw new exception('Mes no válido');

		// Set the current timestamp
		$this->timeStamp = mktime(1,1,1,$this->month, $this->day, $this->year);
		// Set the number of days in teh current month
		$this->daysInMonth = date('t',$this->timeStamp);

		// Start table
		$calHTML = sprintf("<table id=\"%s\" class=\"table table-bordered table-condensed table-centered\"><thead><tr>", $this->calendarName);
	
		// Display previous month navigation
		if ($this->enableNav) {
			$pM = explode('-', date('n-Y', strtotime('-1 month', $this->timeStamp)));
			$calHTML .= sprintf("<th class=\"%s-%s\"><h4><a href=\"?%smonth=%d&amp;year=%d\">%s</a></h4></th>", $this->calendarName, $this->markup['nav'], $this->queryString, $pM[0], $pM[1],$this->prevMonthNavTxt);
		}
		
		// Month name and optional year
		$calHTML .= sprintf("<th colspan=\"%d\" id=\"%s-%s\"><h4>%s%s</h4></th>", ($this->enableNav ? 5 : 7), $this->calendarName, $this->markup['header'], $this->getMonthName(), ($this->enableYear) ? ' '.$this->getYear() : '');

		// Display next month navigation
		if ($this->enableNav) {
			$nM = explode('-', date('n-Y', strtotime('+1 month', $this->timeStamp)));
			$calHTML .= sprintf("<th class=\"%s-%s\"><h4><a href=\"?%smonth=%d&amp;year=%d\">%s</a></h4></th>", $this->calendarName, $this->markup['nav'], $this->queryString, $nM[0], $nM[1],$this->nextMonthNavTxt);
		}

		$calHTML .= sprintf("</tr><tr id=\"%s\">", $this->markup['days_of_week']);

		// Display day headers
		foreach($this->dayNames as $k => $dayName)
			$calHTML .= sprintf("<th>%s</th>", $dayName);

		$calHTML .= "</tr></thead><tbody><tr>";
		
		/// What the heck is this
		$sDay = date('N', $this->timeStamp) + $this->startDay - 1;
		
		// Print previous months days
			for ($e=1;$e<=$sDay;$e++)
				$calHTML .= sprintf("<td class=\"text-muted\">%s</td>", (($this->displayNonMonthDays) ? $this->timeTravel("-" . ($sDay -$e + 1) . " days", 'd', $this->timeStamp) : ''));
	
		// Print days
		for ($i=1;$i<=$this->daysInMonth;$i++) {
			// Set current day and timestamp
			$this->day = $i;
			$this->timeStamp = mktime(1,1,1,$this->month, $this->day, $this->year);
			
			// Set day as either plain text or event link
			if (isset($this->events[$this->year][$this->month][$this->day]))
				$this->htmlDay = sprintf("<a href=\"%s\" data-bs=\"tooltip\" title=\"%s\">%s</a>", $this->events[$this->year][$this->month][$this->day]['event_link'], $this->events[$this->year][$this->month][$this->day]['event_title'], $this->day);
			else
				$this->htmlDay = $this->day;			
	
			// Display calendar cell
			$calHTML .= sprintf("<td%s>%s</td>", ($this->timeStamp == mktime(1,1,1,date('n'),date('j'),date('Y')) ? ' class="calendar-today"' : (isset($this->events[$this->year][$this->month][$this->day])) ? ' class="calendar-red"' : ''), $this->htmlDay);				
						
			// End row if necessary			
			if (($sDay + $this->day) % 7 == 0)
				$calHTML .= "</tr><tr>";
		}
		
		// Print next months days
		for ($e2=1;$e2 < (7 - (($sDay + $this->daysInMonth -1) % 7)); $e2++)
			$calHTML .= sprintf("<td class=\"text-muted\">%s</td>", (($this->displayNonMonthDays) ? $this->timeTravel("+$e2 days", 'd', $this->timeStamp) : ''));
		
		$calHTML .= "</tr></tbody></table>";
	
		// Tidy up html
		if ($this->prettyHTML) {
			$replaceWhat = array('<tr', '<td', '<th', '</tr>', '</table>', '<thead>', '</thead>', '<tbody>', '</tbody>');
			$replaceWith = array("\n\t\t<tr", "\n\t\t\t<td", "\n\t\t\t<th", "\n\t\t</tr>", "\n</table>", "\n\t<thead>", "\n\t</thead>", "\n\t<tbody>", "\n\t</tbody>");
			$calHTML = str_replace($replaceWhat, $replaceWith, $calHTML);
		}
		
		// Print calendar
		echo $calHTML;
	}
	
}
?>