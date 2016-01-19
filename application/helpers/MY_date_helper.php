<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 11/16/2014
 * Time: 2:23 AM
 */
function get_age($date)
{
    //do nothing if if nothing is passed
    if($date)
    {
        $c= date('Y');
        $y= date('Y',strtotime($date));
        return$c-$y;
    }

}

function seconds2days($mysec) {
    $mysec = (int)$mysec;
    if ( $mysec === 0 ) {
        return '0 second';
    }

    $mins  = 0;
    $hours = 0;
    $days  = 0;


    if ( $mysec >= 60 ) {
        $mins = (int)($mysec / 60);
        $mysec = $mysec % 60;
    }
    if ( $mins >= 60 ) {
        $hours = (int)($mins / 60);
        $mins = $mins % 60;
    }
    if ( $hours >= 24 ) {
        $days = (int)($hours / 24);
        $hours = $hours % 60;
    }

    $output = '';

    if ($days){
        $output .= $days." days ";
    }
    if ($hours) {
        $output .= $hours." hours ";
    }
    if ( $mins ) {
        $output .= $mins." minutes ";
    }
    if ( $mysec ) {
        $output .= $mysec." seconds ";
    }
    $output = rtrim($output);
    return $output;
}

function time_ago( $date )
{


    $time_ago=strtotime($date);
    $cur_time 	= time();
    $time_elapsed 	= $cur_time - $time_ago;
    $seconds 	= $time_elapsed ;
    $minutes 	= round($time_elapsed / 60 );
    $hours 		= round($time_elapsed / 3600);
    $days 		= round($time_elapsed / 86400 );
    $weeks 		= round($time_elapsed / 604800);
    $months 	= round($time_elapsed / 2600640 );
    $years 		= round($time_elapsed / 31207680 );
// Seconds
    if($seconds <= 60){
        echo "$seconds seconds ago";
    }
//Minutes
    else if($minutes <=60){
        if($minutes==1){
            echo "one minute ago";
        }
        else{
            echo "$minutes minutes ago";
        }
    }
//Hours
    else if($hours <=24){
        if($hours==1){
            echo "an hour ago";
        }else{
            echo "$hours hours ago";
        }
    }
//Days
    else if($days <= 7){
        if($days==1){
            echo "yesterday";
        }else{
            echo "$days days ago";
        }
    }
//Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            echo "a week ago";
        }else{
            echo "$weeks weeks ago";
        }
    }
//Months
    else if($months <=12){
        if($months==1){
            echo "a month ago";
        }else{
            echo "$months months ago";
        }
    }
//Years
    else{
        if($years==1){
            echo "one year ago";
        }else{
            echo "$years years ago";
        }
    }

}



function custom_date_format($format = 'd M Y', $date = '')
{
   $db_date = trim($date); 
    
 
   if(empty($db_date)) 
    return '';


  $display = '';
  switch ($db_date) {
    case '0000-00-00':
    break;
    case '0000-00-00 00:00:00':
    break;
    case '00:00:00':
    break;
    case '1970-01-01':
    break;
     case ' 1970-01-01 ':
    break;
    case '1970-01-01 00:00:00':
    break;
    case '1970-01-01 00-00-00':
    break;

    
    case '':
      break;
      case ' ':
      break;
    default:
     $db_date = trim($db_date);
     $display = date($format,strtotime($db_date));
      break;
  }
  return $display;
}


//seconds to time
function Sec2Time($time){
    if(is_numeric($time)){
        $value = array(
            "years" => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        if($time >= 31556926){
            $value["years"] = floor($time/31556926);
            $time = ($time%31556926);
        }
        if($time >= 86400){
            $value["days"] = floor($time/86400);
            $time = ($time%86400);
        }
        if($time >= 3600){
            $value["hours"] = floor($time/3600);
            $time = ($time%3600);
        }
        if($time >= 60){
            $value["minutes"] = floor($time/60);
            $time = ($time%60);
        }
        $value["seconds"] = floor($time);
        return (array) $value;
    }else{
        return (bool) FALSE;
    }
}

//hu,am friendly date now
function human_date_today()
{
    /*
     * other options
     *
$today = date("F j, Y, g:i a");                   // March 10, 2001, 5:16 pm
$today = date("m.d.y");                           // 03.10.01
$today = date("j, n, Y");                         // 10, 3, 2001
$today = date("Ymd");                             // 20010310
$today = date('h-i-s, j-m-y, it is w Day');       // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
$today = date('\i\t \i\s \t\h\e jS \d\a\y.');     // It is the 10th day (10ème jour du mois).
$today = date("D M j G:i:s T Y");                 // Sat Mar 10 17:16:18 MST 2001
$today = date('H:m:s \m \e\s\t\ \l\e\ \m\o\i\s'); // 17:03:18 m est le mois
$today = date("H:i:s");                           // 17:16:18
$today = date("Y-m-d H:i:s");                     // 2001-03-
     */

    return date('l jS F Y');
}

//to formate date for mysql
function mysqldate()
{
    $mysqldate = date("m/d/y g:i A", now());
    $phpdate = strtotime( $mysqldate );
    return date( 'Y-m-d H:i:s', $phpdate );
}

//date to seconds
function date_to_seconds($date)
{
    return strtotime($date);
}

function database_ready_format($date)
{
    $mysqldate = date("m/d/y g:i A", strtotime($date));
    $phpdate = strtotime($mysqldate);
    return date('Y-m-d H:i:s', $phpdate);
}


function to_date_picker_format($date){
    return custom_date_format('m/d/Y',$date);
}

function yearDropdownMenu($start_year, $end_year = null, $id='year_select',$class='select', $selected=null) {

    // curret year as end year
    $end_year = is_null($end_year) ? date('Y') : $end_year;
// the current year
    $selected = is_null($selected) ? date('Y') : $selected;

    // range of years
    $r = range($start_year, $end_year);

    //create the HTML select
    $select = '<select name="'.$id.'" id="'.$id.' class="'.$class.'">';
    foreach( $r as $year )
    {
        $select .= "<option value=\"$year\"";
        $select .= ($year==$selected) ? ' selected="selected"' : '';
        $select .= ">$year</option>\n";
    }
    $select .= '</select>';
    return $select;
}


function financial_year_dropdown($start_year='2010', $end_year = null, $id='year_select',$class='select', $selected=null) {

    // curret year as end year
    $end_year = is_null($end_year) ? date('Y') : $end_year;
// the current year
    $selected = is_null($selected) ? date('Y') : $selected;

    // range of years
    $r = range($start_year, $end_year);

    //create the HTML select
    $select = '<select name="'.$id.'" id="'.$id.' class="'.$class.' populate">';
    foreach( $r as $year )
    {
        $val=$year.'-'.($year+1);
        $select .= "<option value=\"$val\"";
        $select .= ($year==$selected) ? ' selected="selected"' : '';
        $select .= '>'.$val.'</option>\n';
    }
    $select .= '</select>';
    return $select;
}


function seconds_to_days($mysec) {
    $mysec = (int)$mysec;
    if ( $mysec === 0 ) {
        return '0 second';
    }

    $mins  = 0;
    $hours = 0;
    $days  = 0;


    if ( $mysec >= 60 ) {
        $mins = (int)($mysec / 60);
        $mysec = $mysec % 60;
    }
    if ( $mins >= 60 ) {
        $hours = (int)($mins / 60);
        $mins = $mins % 60;
    }
    if ( $hours >= 24 ) {
        $days = (int)($hours / 24);
        $hours = $hours % 60;
    }

    $output = '';

    if ($days){
        $output .= $days."  ";
    }

    $output = rtrim($output);
    return $output;
}

function my_date_diff($date1, $date2) {
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval->format('%R%a days');
}

function check_in_range($start_date, $end_date, $date_from_user)
{
    // Convert to timestamp
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_user);

    // Check that user date is between start & end
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}
