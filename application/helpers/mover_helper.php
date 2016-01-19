<?php
/*
 * Helper mainly used to support the Report Print in terms of Grading and Positioning  at all levels
 */
// Round Up INformation  to the nearest Decimal ..

function students_position_subject($this,$exam,$class,$subject,$marks,$scholid)
{

    /*
     * Added Student Marks :: Student ID, Student Class, Student Exam:
     * :: Find Other students in that Exam and in that Class.
     * Rank the students according to perforamce::
     */
    $performance  =  get_all_student_performance_subject($this,$subject,$scholid,$exms);
   $qq = $this -> db -> query("SELECT * from marksheet where school ='$scholid'  and exam = '$exam' and isactive ='Y' and subject = '$subject'")->result_array();
    print_r($qq);
#    $student_performance = $obj -> db-> query('SELECT a.student,sum(a.mark) as summation FROM marksheet as a inner join exams as b on a.exam = b.id  where a.exam in( select id from exams where term = '.$term.' ) group by a.student order by a.mark DESC')->result_array();



}


function round_up($value, $places=0) {
    if ($places < 0) { $places = 0; }
    $mult = pow(10, $places);
    return ceil($value * $mult) / $mult;
}

// GET ME EXAMS IN THE TERM
function getExams ($obj,$term)
{
    $student_performance = $obj -> db-> query('SELECT a.student,sum(a.mark) as summation FROM marksheet as a inner join exams as b on a.exam = b.id  where a.exam in( select id from exams where term = '.$term.' ) group by a.student order by a.mark DESC')->result_array();
    return $student_performance;
}

// Getting sum of get_all_student_performance_termly  marks in a term by exam
function get_all_student_performance_termly($obj,$term)
{
    $student_performance = $obj -> db-> query('SELECT a.student,sum(a.mark*b.contribution/100) as summation,count(*) as stds FROM marksheet as a inner join exams as b on a.exam = b.id  where a.exam in( select id from exams where term = '.$term.' ) group by a.student order by summation DESC ')->result_array();
    #print_r($student_performance);
    return $student_performance;
}
#find out the number of students in a class
function get_all_student_registered($obj,$term,$class)
{
    $student_performance = $obj -> db-> query('SELECT count(*) as cn  FROM register  where term = '.$term.' and class = '.$class.'')->result_array();
    #print_r($student_performance);
    return $student_performance;
}



#fetching all student performance in term
//Getting Student Performance in an Exam (MARKS SUMMATION) OF STUDENTS AND ORDERED ACCORDING TO THE BEST
function get_all_student_performance_exam($obj,$exam)
{
    foreach($exam as $ex){
        $examid = $ex['id'];
    }
    $student_performance = $obj -> db-> query('SELECT student,sum(mark) as summation FROM marksheet as a inner join exams as b on a.exam = b.id  where a.exam = '.$examid.'  group by student order by summation DESC')->result_array();
    return $student_performance;
}
// Calculating the Percentage ::
function percentage_finder($mark,$percent)
{
    $result =(($mark)/100) * $percent;
    return $result;
}
// function to find out the current position of the student in class
function position_finder($mark_counter=0,$exam_counts=0,$clas_performance=0)
{
   # $clas_performance = sort($clas_performance);
  #  print_r($clas_performance); exit();
    // echo "Mark Counter ..".$mark_counter."<br/> <br/>";
    $count = 1;
    if($mark_counter == 0) return 'Not Graded';
    foreach($clas_performance as $performace)
    {
        //  echo "..<br/>..".$performace."<br/>...";
        // return "<br/> ...In....<br/>";
        if($performace['summation']  == $mark_counter )
        {
            return $count;
        }

        $count++;
    }

    return "Not Available ";
}
function position_finder3($mark_counter=0,$exam_counts=0,$clas_performance=0)
{
   # print_r($clas_performance);
    // echo "Mark Counter ..".$mark_counter."<br/> <br/>";
    $count = 1;
    if($mark_counter == 0) return 'Not Graded';
    foreach($clas_performance as $performace)
    {
        //  echo "..<br/>..".$performace."<br/>...";
        // return "<br/> ...In....<br/>";
        if($performace['summation']  == $mark_counter )
        {
            return $count;
        }

        $count++;
    }

    return "Not Available ";
}
function position_finder2($mark_counter=0,$exam_counts=0,$clas_performance=0)
{
    // echo "Mark Counter ..".$mark_counter."<br/> <br/>";
   # var_dump($clas_performance);
    $count = 1;
    if($mark_counter == 0) return 'Not Graded';
# creat array add keys.
    $arra_key = array();
    foreach($clas_performance as $key => $performace)
    {
       # echo "..<br/>..";
      //  var_dump($performace);
       # echo "..<br/>..".$key."<br/>...";
        // return "<br/> ...In....<br/>";
        if($performace  == $mark_counter )
        {

            return $count;
        }
        $count++;
        array_push($arra_key,$performace);

    }
    //arsort($arra_key);
  /*  echo ":: Information <br/>";
    var_dump($arra_key);
    echo "<br/> information ";
    exit(); */
  #  var_dump($arra_key);
    foreach($arra_key as $performace)
    {
        if($performace  == $mark_counter )
        {

            return $count;
        }
        $count++;
    }

    return "Not Available ";
}



// GETTING EXAM MARKS PER SUBJECT IN A GIVEN EXAM
function get_all_student_performance_subject($obj,$subject,$school,$exms)
{
    $student_performance = $obj -> db-> query('SELECT  a.mark as summation FROM marksheet as a inner join subjects as b on a.subject = b.id where a.subject = '.$subject.' and a.school = '.$school.' and a.exam ='.$exms.' order by a.mark DESC')->result_array();
    return $student_performance;
}

// GETTING EXAM MARKS AND ITS PERCENT CONTRIBUTION
function get_all_student_performance_exams($obj,$exam,$school)
{
    $student_performance = $obj -> db-> query('SELECT b.contribution,a.student, sum(a.mark*100/b.contribution) as mark FROM marksheet as a inner join exams as b on a.exam = b.id where a.exam = '.$exam.'    group by a.student order by a.student ')->result_array();
    return $student_performance;
}
# functon to sort array
function asort_array($arr)
{
   return  arsort($arr);
}
// Add the diferent Examination of the student in a given period  and sort and sort them ::
function arrange_student_marks($obj,$exams,$school)
{

    $arr1= array();$arr2= array();$arr3= array();$arr4= array();$arr5= array();$arr6= array();$arr7= array();$arr8= array();$arr9= array();$arr10= array();$arr11= array();$arr12= array();$arr13= array();$arr14= array();
    $added_array = array();
    $examm = array();
   // var_dump($exams);
    $actual_marks = array();
    foreach($exams as $exam_info)
    {

        unset($actual_marks);
        $actual_marks = array();
//working with summary class performace in a given exam ::
        $exam_student_summary = get_all_student_performance_exams($obj,$exam_info['id'],$school);

        foreach($exam_student_summary as $samre)
        {
            $actual_mark  = 0;
            $actual_mark = percentage_finder($samre['mark'],$samre['contribution']);

            array_push($actual_marks,$actual_mark);

        }

        array_push($examm,$actual_marks);

    }

    $count = 0;
    foreach($examm as $examdid)
    {


        foreach($examdid as $did)
        {
            switch($count)
            {
                // the swithc can be extend dynamically ::
                case 0:  array_push($arr1,$did);    break;
                case 1:  array_push($arr2,$did);    break;
                case 2:  array_push($arr3,$did);    break;
                case 3:  array_push($ar4,$did);    break;
                case 4:  array_push($ar5,$did);    break;
                case 5:  array_push($ar6,$did);    break;
                case 6:  array_push($ar7,$did);    break;
                case 7:  array_push($arr8,$did);    break;
                case 8:  array_push($arr9,$did);    break;
                case 9:  array_push($arr10,$did);    break;
                case 10:  array_push($arr11,$did);    break;
                case 11:  array_push($arr12,$did);    break;
                case 12:  array_push($arr13,$did);    break;
                case 13:  array_push($arr14,$did);    break;
                case 14:  array_push($arr15,$did);    break;

                default:     break;
            }
        }

       $count++;
    }

    $array_length = count($arr1);
    $counter = 0;

    $total_add = array();
    while($counter < $array_length)
    {
        //echo "".$arr1[$counter]."<br/> <br/>";
        switch($count)
        {
            case 1:
                @$result = ($arr1[$counter]);

                break;
            case 2:
           @$result = ($arr1[$counter]+$arr2[$counter]);

                break;
            case 3:
               @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]);
                break;
            case 4:
               @ $result = ($arr1[$counter]+$arr2[$counter]+$arr4[$counter]);
                break;
            case 5:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]);
                break;
            case 6:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]);
                break;
            case 7:
               @ $result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]);

                break;
            case 8:
               @ $result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]);
                break;
            case 9:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]);
                break;
            case 10:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]+$arr10[$counter]);
                break;
            case 11:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]+$arr10[$counter]+$arr11[$counter]);
                break;
            case 12:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]+$arr10[$counter]+$arr11[$counter]+$arr12[$counter]);
                break;
            case 13:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]+$arr10[$counter]+$arr11[$counter]+$arr12[$counter]+$arr13[$counter]);
                break;
            case 14:
                @$result = ($arr1[$counter]+$arr2[$counter]+$arr3[$counter]+$arr5[$counter]+$arr6[$counter]+$arr7[$counter]+$arr8[$counter]+$arr9[$counter]+$arr10[$counter]+$arr11[$counter]+$arr12[$counter]+$arr13[$counter]+$arr14[$counter]);
                break;
            default:
                break;

        }

        array_push($total_add,$result);
        $counter ++;
    }


    arsort($total_add);

    return $total_add;


}
#function xml student subtotals
function subtotals_xml($subtotal_array,$exams,$xml,$sst)
{
    /****************************************
     * Declaring Variables to be used for the different exams ::
     *
     */

    $exm1=0 ;
    $exm2=0 ;
    $exm3=0;
    $exm4=0;
    $exm5=0; $exm6=0; $exm7=0; $exm8=0; $exm9=0; $exm10=0; $exm11=0; $exm12=0; $exm13=0; $exm14=0;$exm15=0;
    $exm16=0;$exm17=0;

    foreach($subtotal_array as $subtotal)
    {
        $termly_exams =explode('##',$subtotal);
        $personal_examination =explode('**',$termly_exams[0]);
        $find = 1;

        foreach($personal_examination as $subject_marks)
        {

            switch($find)
            {
                case 1:   $exm1  += $subject_marks;   break;
                case 2:  $exm2  += $subject_marks;  break;
                case 3:  $exm3  += $subject_marks;  break;
                case 4:  $exm4  += $subject_marks;     break;
                case 5:   $exm5  += $subject_marks;     break;
                case 6:    $exm6  += $subject_marks; break;
                case 7:   $exm7  += $subject_marks;  break;
                case 8:  $exm8  += $subject_marks; break;
                case 9:   $exm9  += $subject_marks; break;
                case 10: $exm10  += $subject_marks; break;
                case 11:  $exm11 += $subject_marks;  break;
                case 12:  $exm12 += $subject_marks;  break;
                case 13:  $exm13 += $subject_marks; break;
                case 13:  $exm14  += $subject_marks;  break;
                case 14: $exm14  += $subject_marks;  break;
                case 15:  $exm15  += $subject_marks; break;
                case 16:  $exm16  += $subject_marks; break;
                case 17:  $exm17  += $subject_marks; break;
                default:  break;
            }

            $find++;
        }



    }
    // echo   $exm1;


    $find2 = 1;
    $total_mark = 0;
    foreach($exams as $td)
    {
        ?>


            <?php
            //  percentage_finder
            switch($find2)        {
                case 1:      $result = percentage_finder($exm1,$td['contribution'])  ;   break;
                case 2:   $result = percentage_finder($exm2,$td['contribution']) ;  break;
                case 3:   $result = percentage_finder($exm3,$td['contribution'])  ; break;
                case 4:   $result = percentage_finder($exm4,$td['contribution'])   ;break;
                case 5:   $result = percentage_finder($exm5,$td['contribution']) ; break;
                case 6:   $result = percentage_finder($exm6,$td['contribution']) ;   break;
                case 7:   $result = percentage_finder($exm7,$td['contribution'])   ;break;
                case 8:   $result = percentage_finder($exm8,$td['contribution']);  break;
                case 9:   $result = percentage_finder($exm9,$td['contribution']) ;  break;
                case 10:  $result = percentage_finder($exm10,$td['contribution']);   break;
                case 11:  $result = percentage_finder($exm11,$td['contribution']) ;  break;
                case 12:  $result = percentage_finder($exm12,$td['contribution']) ;  break;
                case 13:  $result = percentage_finder($exm13,$td['contribution']) ; break;
                case 14:  $result = percentage_finder($exm14,$td['contribution']) ;  break;
                case 15:  $result = percentage_finder($exm15,$td['contribution']) ;   break;
                case 16:  $result = percentage_finder($exm16,$td['contribution']) ; break;
                case 17:  $result = percentage_finder($exm17,$td['contribution']) ;  break;
                default: break;
            }
        $subtoals = $xml -> createElement("subtotos");
        $total_mark += $result;
        $rr =  $result." (".$td['contribution']."%)";
        $titleText = $xml->createTextNode($rr);
        $subtoals->appendChild($titleText);
        $sst ->appendChild($subtoals);
      /*  ?>
        <td colspan="4">
            <?php

            echo $result."&nbsp;(".$td['contribution']."%)";

            ?>
        </td>
        <?php */
        $find2 ++;
    }
    $rounded  = explode('.',$total_mark);
    $totall = $xml -> createElement("totalas");
    $titleText = $xml->createTextNode($total_mark);
    $totall->appendChild($titleText);
    $sst ->appendChild($totall);
    return $total_mark;
}

//function student subtotals
function subtotals($subtotal_array,$exams)
{
    /****************************************
     * Declaring Variables to be used for the different exams ::
     *
     */

    $exm1=0 ;
    $exm2=0 ;
    $exm3=0;
    $exm4=0;
    $exm5=0; $exm6=0; $exm7=0; $exm8=0; $exm9=0; $exm10=0; $exm11=0; $exm12=0; $exm13=0; $exm14=0;$exm15=0;
    $exm16=0;$exm17=0;

    foreach($subtotal_array as $subtotal)
    {
        $termly_exams =explode('##',$subtotal);
        $personal_examination =explode('**',$termly_exams[0]);
        $find = 1;

        foreach($personal_examination as $subject_marks)
        {

            switch($find)
            {
                case 1:   $exm1  += $subject_marks;   break;
                case 2:  $exm2  += $subject_marks;  break;
                case 3:  $exm3  += $subject_marks;  break;
                case 4:  $exm4  += $subject_marks;     break;
                case 5:   $exm5  += $subject_marks;     break;
                case 6:    $exm6  += $subject_marks; break;
                case 7:   $exm7  += $subject_marks;  break;
                case 8:  $exm8  += $subject_marks; break;
                case 9:   $exm9  += $subject_marks; break;
                case 10: $exm10  += $subject_marks; break;
                case 11:  $exm11 += $subject_marks;  break;
                case 12:  $exm12 += $subject_marks;  break;
                case 13:  $exm13 += $subject_marks; break;
                case 13:  $exm14  += $subject_marks;  break;
                case 14: $exm14  += $subject_marks;  break;
                case 15:  $exm15  += $subject_marks; break;
                case 16:  $exm16  += $subject_marks; break;
                case 17:  $exm17  += $subject_marks; break;
                default:  break;
            }

            $find++;
        }



    }
    // echo   $exm1;


    $find2 = 1;
$total_mark = 0;
    foreach($exams as $td)
    {
        ?>
        <td colspan="4">

            <?php
          //  percentage_finder
            switch($find2)        {
                case 1:      $result = percentage_finder($exm1,$td['contribution'])  ;   break;
                case 2:   $result = percentage_finder($exm2,$td['contribution']) ;  break;
                case 3:   $result = percentage_finder($exm3,$td['contribution'])  ; break;
                case 4:   $result = percentage_finder($exm4,$td['contribution'])   ;break;
                case 5:   $result = percentage_finder($exm5,$td['contribution']) ; break;
                case 6:    $result = percentage_finder($exm6,$td['contribution']) ;   break;
                case 7:   $result = percentage_finder($exm7,$td['contribution'])   ;break;
                case 8:   $result = percentage_finder($exm8,$td['contribution']);  break;
                case 9:   $result = percentage_finder($exm9,$td['contribution']) ;  break;
                case 10:    $result = percentage_finder($exm10,$td['contribution']);   break;
                case 11:   $result = percentage_finder($exm11,$td['contribution']) ;  break;
                case 12:  echo    $result = percentage_finder($exm12,$td['contribution']) ;  break;
                case 13: echo    $result = percentage_finder($exm13,$td['contribution']) ; break;
                case 14:  echo   $result = percentage_finder($exm14,$td['contribution']) ;  break;
                case 15:  echo  $result = percentage_finder($exm15,$td['contribution']) ;   break;
                case 16: echo   $result = percentage_finder($exm16,$td['contribution']) ; break;
                case 17:   echo  $result = percentage_finder($exm17,$td['contribution']) ;  break;
                default: break;
            }
            $total_mark += $result;
            echo $result."&nbsp;(".$td['contribution']."%)";

            ?>
        </td>
        <?php
        $find2 ++;
    }
    return $total_mark;
}

#    Output easy-to-read numbers
#    by james at bandit.co.nz
function number_filter($n) {
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));

    // is this a number?
    if(!is_numeric($n)) return false;

    // now filter it;
    if($n>1000000000000) return round(($n/1000000000000),2).' TR';
    else if($n>1000000000) return round(($n/1000000000),2).' BL';
    else if($n>1000000) return round(($n/1000000),2).' M';
   // else if($n>1000) return round(($n/1000),3).' ';

    return number_format($n);
}