<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
# PHP Calendar (version 2.3), written by Keith Devens
# http://keithdevens.com/software/php_calendar
#  see example at http://keithdevens.com/weblog
# License: http://keithdevens.com/software/license
if ( ! function_exists('generate_calendar'))
{
function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	#remember that mktime will automatically correct if invalid dates are entered
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
	# this provides a built in "rounding" feature to generate_calendar()

	$day_names = array(); #generate all the day names according to the current locale
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
	if($p) $p = ''.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'&nbsp;';
	if($n) $n = '&nbsp;'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'';
	$calendar = '<table class="calendar">'."\n".
		'<tr><td align="center" colspan="7"><table width="180" cellpadding="0" cellspacing="0" border="0" align="center"><tr><td class="calendar-prev" width="20">'.$p.'</td><td class="calendar-month" width="140" align="center">'.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).'</td><td class="calendar-next" width="20">'.$n."</td></tr></table></td></tr>\n";
		// add a class for the table header row.
		$calendar .= "<tr class=\"topcalendarlinks\">";

	if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
		#if day_name_length is >3, the full name of the day will be printed
		foreach($day_names as $d)
			$calendar .= '<th width=75 height=40 align=center valign=middle abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
		$calendar .= "</tr>\n<tr class=\"calendarbody\">";
	}

	if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'" class="sidetablebackground">&nbsp;</td>'; #initial 'empty' days
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
		if($weekday == 7){
			$weekday   = 0; #start a new week
			$calendar .= "</tr>\n<tr class=\"calendarbody\">";
		}
		if(isset($days[$day]) and is_array($days[$day])){
			@list($link, $classes, $content) = $days[$day];
			if(is_null($content))  $content  = $day;
			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
				($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
		}
		else $calendar .= "<td>$day</td>";
	}
	if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'" class="sidetablebackground">&nbsp;</td>'; #remaining "empty" days

	return $calendar."</tr>\n</table>\n";
}
}