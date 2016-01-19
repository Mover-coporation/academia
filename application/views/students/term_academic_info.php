
<?php

#print_r($termdetails['id']);



/*
 * Term Academic Information .. Student Performance in A term. combination of the number of exams in term and there
 * contribution in terms of % provides the positioning. helper mover_helper.php
 */

?>
<div id="printreport" class="printreport">
<table border="0" cellspacing="0" cellpadding="10" width="100%"  style="clear:both;">

<tr>
<td colspan="2" class="clear" style="padding:0px; vertical-align:top">
<?php
if(!empty($subjects))
{

    $termnm = '';
    $yeer = '';
    $termid = '';
    if(isset($termdetails['term']))
    {
        $termnm = $termdetails['term'];
        $yeer = $termdetails['year'];
        $termid = $termdetails['id'];
    }
    ?>
 <div style="padding:0.5em 0.5em 0.5em; border-bottom:1px solid #000000; margin-bottom:10px">



  <?php  echo '<b>Class:</b> '.$classdetails['class'].' <b>Term:</b>'. $termnm.', '.$yeer; ?>

   </div>

      <table cellpadding="8" border="0" class="mark_sheet" cellspacing="0">

          <tr class="marksheet_exam_headers">
    <?php
    $exam_counts = 0;
    if(count($exams))
    {
        $counter = 0;
        $exam_summary_column_headers = '';

        #echo '<td class="right_border">Exam</td>';

//creating my xml


    //output marks for each subject
    //$counter =0;
    //output marks for each subject
    $counter =0;
    $mark_counter   =0;
    $mark_counter2   =0;
    $mark   ='0';
    $subject_count  = count($subjects);
    $exam_count = count($exams);
    $rt = "";

    //   $subtotals


    $arranged  = arrange_student_marks($this,$exams,$studentdetails['id']);


/*
 *  Students Academic view Home Interface :
 */
#exit();
// create function to create xml files using machine level development

$session_id = $this->session->userdata('session_id');
#print_r($session_id);


# creat xml document and then access it and combine it wht the desired xslt ::
$xml = new DOMDocument("1.0");


#root element ::
$root = $xml -> createElement("reportmodule");
$xml -> appendChild($root);
# creat report
$report = $xml -> createElement("report");
$root -> appendChild($report);
# retport id
$reportid = $xml -> createElement("reportid");
$report -> appendChild($reportid);
#create head element
        $head = $xml -> createElement("head");
        $report -> appendChild($head);
        # head element children::
        $logo1 = $xml -> createElement("logo1");
        //logourl
        $thim = explode('.',$schoolid['logourl']);
        $thumm = $thim[0].'_thumb.'.$thim[1];
        $titleText = $xml->createTextNode('../downloads/schools/'.$thumm);
        $logo1->appendChild($titleText);
        $head -> appendChild($logo1);
        #logo 2
        $logo2 = $xml -> createElement("logo2");
        $head -> appendChild($logo2);
        #title

        $title = $xml -> createElement("title");
        //$schoolid
        $titleText = $xml->createTextNode($schoolid['schoolname']);
        $title->appendChild($titleText);
        $head -> appendChild($title);
        #email
        $email = $xml -> createElement("email");
        $titleText = $xml->createTextNode($schoolid['emailaddress']);
        $email->appendChild($titleText);
        $head -> appendChild($email);
        #pobox
        $pobox = $xml -> createElement("pobox");
        $head -> appendChild($pobox);
        #address
        $address = $xml -> createElement("address");
        $head -> appendChild($address);
        #tel
        $tel = $xml -> createElement("tel");
        $head -> appendChild($tel);
        #motto
        $motto = $xml -> createElement("motto");
        $head -> appendChild($motto);
        #term
        $term = $xml -> createElement("term");
        $titleText = $xml->createTextNode($termdetails['term']);
        $term->appendChild($titleText);
        $head -> appendChild($term);
        #class
        $class = $xml -> createElement("class");

        $titleText = $xml->createTextNode( $classdetails['class']);
        $class->appendChild($titleText);
        $head -> appendChild($class);
        #year
        $year = $xml -> createElement("year");
        $head -> appendChild($year);
        #names
        $names = $xml -> createElement("names");
        $titleText = $xml->createTextNode($studentdetails['firstname']." ".$studentdetails['lastname']);
        $names->appendChild($titleText);
        $head -> appendChild($names);



        /*
        #create head element
        $head = $xml -> createElement("head");
        $report -> appendChild($head);

        # head element children::
        $logo1 = $xml -> createElement("logo1");
        $head -> appendChild($logo1);
        #logo 2
        $logo2 = $xml -> createElement("logo2");
        $head -> appendChild($logo2);
        #title
        $title = $xml -> createElement("title");
        $head -> appendChild($title);
        #address
        $address = $xml -> createElement("address");
        $head -> appendChild($address);
        #email
        $email = $xml -> createElement("email");
        $head -> appendChild($email);
        #tel
        $tel = $xml -> createElement("tel");
        $head -> appendChild($tel);
        #motto
        $motto = $xml -> createElement("motto");
        $head -> appendChild($motto);
        #term
        $term = $xml -> createElement("term");
        $head -> appendChild($term);
        #class
        $class = $xml -> createElement("class");
        $head -> appendChild($class);
        #year
        $year = $xml -> createElement("year");
        $head -> appendChild($year);
        #names
        $names = $xml -> createElement("names");
        $head -> appendChild($names); */
#ending of the head department ::::####
#touching the body : part::
/*$body = $xml -> createElement("body");
$report -> appendChild($body);
#adding footer
$footer = $xml -> createElement("footer");
$report -> appendChild($footer);
#note
$note = $xml -> createElement("note");
$report -> appendChild($note);
#nextterm
$nextterm = $xml -> createElement("nextterm");
$report -> appendChild($nextterm);
#begins
$begins = $xml -> createElement("begins");
$nextterm -> appendChild($begins);
#ends
$ends = $xml -> createElement("ends");
$nextterm -> appendChild($ends);
#signature
$signature = $xml -> createElement("signature");
$nextterm -> appendChild($signature);
#fees
$fees = $xml -> createElement("fees");
$nextterm -> appendChild($fees);
#feestype
$feestype = $xml -> createElement("feestype");
$fees -> appendChild($feestype);
#fees
$feess = $xml -> createElement("fees");
$fees -> appendChild($feess); */
#subjects

#subjects
$subjecta = $xml -> createElement("subjects");
$report -> appendChild($subjecta);


    foreach($subjects as $subject1)
    {
        //here goes the loop for the subject::
#subject
$subject = $xml -> createElement("subject");
$subjecta -> appendChild($subject);
      #  foreach($exams as $exam_details)

// here you manipulate the subject in a do loop::

#subjectid

$subjectid = $xml -> createElement("subjectid");
        $titleText = $xml->createTextNode($subject1['id']);
        $subjectid->appendChild($titleText);
$subject -> appendChild($subjectid);
#subjectname
$subjectname = $xml -> createElement("subjectname");
        $titleText = $xml->createTextNode($subject1['subject']);
        $subjectname->appendChild($titleText);
$subject -> appendChild($subjectname);



    }
#subjectid
$subjectid = $xml -> createElement("subjectid");
$subject -> appendChild($subjectid);
#subjectname
$subjectname = $xml -> createElement("subjectname");
$subject -> appendChild($subjectname);



#adding exams to the game::
#exams
$exams1 = $xml -> createElement("exams");
$report -> appendChild($exams1);
    foreach($exams as $exam_details)

        {
            $exam_counts ++;

            $exam = $xml -> createElement("exam");
            $exams1 -> appendChild($exam);
            $examname = $xml -> createElement("examname");
            $exam -> appendChild($examname);
            $titleText = $xml->createTextNode($exam_details['exam']);
            $examname->appendChild($titleText);
           # $exams1->appendChild($titleText);
            $counter++;
        }

        /*
#exam
$exam = $xml -> createElement("exam");
$exams1 -> appendChild($exam);

#examname
$examname = $xml -> createElement("examname");
$exam -> appendChild($examname);
#examid
$examid = $xml -> createElement("examid");
$exam -> appendChild($examid); */

#adding marksheet to exams and subjects in a given
/*
 * THE MATHEMATIC BEHIND IS THAT:: <<>><<>><<>>
 *  marksheet
 * THE MARKS SHOULD BE ARRANGED IN THE SAME FLOW AS THE EXAMS ARE ARRANGED :: IN THE DATABASE ::
 */

        $counter =0;
#marksheet
$marksheet = $xml -> createElement("marksheet");
$report -> appendChild($marksheet);
        foreach($subjects as $subject)
        {
            #echo '<tr '.(($counter%2 == 0)? 'style="background-color: #F0F0E1;"' : '').' class="mark_sheet_row">
            #       				<td class="right_border">'.$subject['subject'].'</td>';

            //Get marks for each exam
#examid
            $examid = $xml -> createElement("examid");

            $examd = $xml -> createElement("examd");
            $titleText = $xml->createTextNode($subject['id']);
            $examd->appendChild($titleText);
            $examid -> appendChild($examd);
            $marksheet -> appendChild($examid);

            #exams
            #pass the exam id the student id,  and clas id, or even
            /*
             * ogic is that the student who did a given exam, u will get the different sutednts that did the same exam
             * and subject id.. get the marks and then find the  position of the student..
             */

            #$schoolid[id];
            foreach($exams as $exam_info)
            {
                //performance summary
                $exam_performance_summary = get_subject_performance_summary($this, $registration_data['class'], $exam_info['id'], $subject['id']);
                //get the student's marks for the current exam
              #  $student_marks = $this->Query_reader->get_row_as_array('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' student='.$registration_data['student'].' AND subject='.$subject['id'].' AND exam='.$exam_info['id']));

                $examx = $xml -> createElement("exams");
                $examid -> appendChild($examx);
                $student_marks = $this->Query_reader->get_row_as_array('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' student='.$registration_data['student'].' AND subject='.$subject['id'].' AND exam='.$exam_info['id']));
                if(empty($student_marks))
                {

                    $student_marks['mark'] = '';
                    $student_marks['comments'] = '';
                }
                $mark  = ($student_marks['mark'] =='')?0:$student_marks['mark'];
                $mark_counter = $mark_counter +$mark;
                $mark_counter2 = $mark ;
                $exm_info = $exam_info['id'];
                $exam_sumary = get_all_student_performance_exams($this,$exam_info['id'],$studentdetails['id']);
                $rt .=  $mark_counter2 ."**";
                if($mark >0){
                    //($obj,$exam,$class,$subject,$marks,$scholid)
                    //get_all_student_performance_subject
                    $performance  =  get_all_student_performance_subject($this,$student_marks['subject'],$student_marks['school'],$student_marks['exam']);
                    // Get Student Performance
                    $position  = position_finder($mark,0,$performance);

               // $postion  = students_position_subject($this,$student_marks['exam'],$student_marks['class'],$student_marks['subject'],$student_marks['mark'],$student_marks['school']);
            }else{$position = "Not Graded";}

                #subjectid
                $subjectid = $xml -> createElement("subjectid");
                $titleText = $xml->createTextNode($subject['id']);
                $subjectid->appendChild($titleText);
                $examx -> appendChild($subjectid);
                $marks = $xml -> createElement("marks");
                $titleText = $xml->createTextNode($mark);
                $marks->appendChild($titleText);
                $examx -> appendChild($marks);
                #$examid -> appendChild($exams);


                #marks
                #$marks = $xml -> createElement("marks");
                #$titleText = $xml->createTextNode($mark);
                #$marks->appendChild($titleText);
                #$exams -> appendChild($marks);
                #$examid -> appendChild($exams);

$aver = $exam_performance_summary['average'];
            }
            $mark_counter2 = 0;
            $rt .="##";


            $avmark = $xml -> createElement("avmark");
            $titleText = $xml->createTextNode($aver);
            $avmark->appendChild($titleText);
            $examid->appendChild($avmark);
            $postin = $xml -> createElement("examposition");
            $titleText = $xml->createTextNode($position);
            $postin->appendChild($titleText);
            $examid->appendChild($postin);

            $counter++;
            if($counter == $subject_count )
            {
            ##### moemoema
             $subtotal_array =explode('##',$rt);

             $subtotals = $xml -> createElement("subtotal");
             $total_mark = subtotals_xml($subtotal_array,$exams,$xml,$marksheet);
            // $titleText = $xml->createTextNode( $total_mark);
            // $subtotals->appendChild($titleText);
             $examid->appendChild($subtotals);






            }




            //avmark

        }

        #class performance ::
        #POSITION ELEMENT XML
        $position = $xml -> createElement("position");
        #find class performance per exam ::
        #CLASS PERFORMANCE
        $clas_performance  = get_all_student_performance_termly($this,$termid);

        #POSITION FINDER
        $posiion =  position_finder($total_mark,$exam_counts,$clas_performance);
        $titleText = $xml->createTextNode($posiion);
        $position->appendChild($titleText);
        $marksheet->appendChild($position);
       # $classdetails

        #numb os students who sat in the clas
        $t = 0;
        $rs = get_all_student_registered($this,$termid,$classdetails['id']);
       # print_r('::::'.$rs);
       # print_r($rs);
        foreach($rs as $result){
            $numstudents = $result['cn'];
        }
        $e = $numstudents;
       # print_r($numstudents);
        $numstudents = $xml -> createElement("numstudents");
        $titleText = $xml->createTextNode(' '.$e);
        $numstudents->appendChild($titleText);
        $marksheet->appendChild($numstudents);
        /*
#examid
$examid = $xml -> createElement("examid");
$marksheet -> appendChild($examid);
#examd
$examd = $xml -> createElement("examd");
$examid -> appendChild($examd);

#jkl;

        /*

#exams
        $exams = $xml -> createElement("exams");
        $examid -> appendChild($exams);
#subjectid
$subjectid = $xml -> createElement("subjectid");
$exams -> appendChild($subjectid);

#marks
$marks = $xml -> createElement("marks");
$exams -> appendChild($marks);

#avmark average mark
$avmark = $xml -> createElement("avmark");
$examid -> appendChild($avmark);
#examposition
$examposition = $xml -> createElement("examposition");
$examid -> appendChild($examposition);
#examremarks
$examremarks = $xml -> createElement("examremarks");
$examid -> appendChild($examremarks);
#examinitial
$examinitial = $xml -> createElement("examinitial");
$examid -> appendChild($examinitial);


*/



/*

$id = $xml -> createElement("id");
$idText = $xml ->  createTextNode("1");
$id -> appendChild($idText);
$title   = $xml->createElement("title");
$titleText = $xml->createTextNode('"PHP TRUST"');
$title->appendChild($titleText);
$book = $xml->createElement("book");
$book->appendChild($id);
$book->appendChild($title);
$root->appendChild($book); */
$xml->formatOutput = true;
#echo "<xmp>". $xml->saveXML() ."</xmp>";
$xml->save("xml_files/".$session_id.".xml") or die("Error");


$xslDoc = new DOMDocument();
$xslDoc->load("xsl_files/collection.xsl");

$xmlDoc = new DOMDocument();
$xmlDoc->load("xml_files/".$session_id.".xml");

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);


#print 'Reached Home Safely';


        #foreach($subjects as $subject)

exit();

  // xml end

        //echo exam headers
       /* foreach($exams as $exam_details)
        {
            $exam_counts ++;
            echo '<td colspan="4" class="marksheet_exam_headers_cell">'.$exam_details['exam'].'mover</td>';

            $exam_summary_column_headers .= '<td class="vertical_text_col" valign="baseline">
              <div class="vertical_text_wrapper">
              <div class="vertical_text">'.$studentdetails['firstname'].'</div>
              </div>
              </td>
           	  <td class="vertical_text_col"  valign="baseline">
              <div class="vertical_text_wrapper">
              <div class="vertical_text">Class Average</div>
              </div>
              </td>
           	  <td class="vertical_text_col"  valign="baseline">
              <div class="vertical_text_wrapper">
              <div class="vertical_text">Best Mark</div>
              </div>
              </td>
           	  <td class="vertical_text_col right_border"  valign="baseline">
              <div class="vertical_text_wrapper">
              <div class="vertical_text">Lowest Mark</div>
              </div>
              </td>';

            $counter++;
        } */

        //echo marks headers
        echo '</tr><tr><td class="right_border">Subjects</td>'.$exam_summary_column_headers.'</tr>';

    }
    else
    {
        echo "<td>No exams have been specified for this term</td>";
    }
    ?>




   <?php

   /* foreach($subjects as $subject)
    {
        echo '<tr '.(($counter%2 == 0)? 'style="background-color: #F0F0E1;"' : '').' class="mark_sheet_row">
            				<td class="right_border">'.$subject['subject'].'</td>';

        //Get marks for each exam


        foreach($exams as $exam_info)
        {
            //performance summary

            $exam_performance_summary = get_subject_performance_summary($this, $registration_data['class'], $exam_info['id'], $subject['id']);
            // fetching each array in total
            //   $examm
            //get the student's marks for the current exam
            $student_marks = $this->Query_reader->get_row_as_array('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' student='.$registration_data['student'].' AND subject='.$subject['id'].' AND exam='.$exam_info['id']));
            if(empty($student_marks))
            {

                $student_marks['mark'] = '';
                $student_marks['comments'] = '';
            }
            $mark  = ($student_marks['mark'] =='')?0:$student_marks['mark'];
            //$mark  = percentage_finder($mark,$exam_info['contribution']);
            $mark_counter = $mark_counter +$mark;
            $mark_counter2 = $mark ;
            $exam_sumary = get_all_student_performance_exams($this,$exam_info['id'],$studentdetails['id']);
            $rt .=  $mark_counter2 ."**";
            echo '<td><div class="marks_cell">'.$student_marks['mark'].' </div></td>
                			 <td><div class="marks_cell">'.$exam_performance_summary['average'].'</div></td>
                			 <td><div class="marks_cell">'.$exam_performance_summary['highest'].'</div></td>
                			 <td class="right_border"><div class="marks_cell">'.$exam_performance_summary['lowest'].'</div></td>';
        }*/

        // Level 2
        $mark_counter2 = 0;
        $rt .="##";

        # echo '</tr>';



        $counter++;
        if($counter == $subject_count )
        {
            ?>
       <tr>

                 <td> Sub Totals </td>
                 <td>
            <?php
            /*********************************************************
             * Declaring a subtotal array to explode all the records @mover
             */
            $subtotal_array =explode('##',$rt);

            // echo $subtotal_array[0];
            // Subtotals for a student
            $total_mark = subtotals($subtotal_array,$exams);



            ?>
            <td colspan="12">


               </td>

           </tr>
        <?php

        }


    }


    ?>
  <tr>
        <td>
    <?php
    // Get Student Subject Info ::
    $weask =  @get_student_subject_info($this,$registration_data['class'],$exam_info['id'],$subject['id'], $mark );
    //   echo $weask; ?>
        </td>
     </tr>
     <tr><td>Average Total</td>
         <td colspan="4">

    <?php
    echo  round_up($total_mark,2) ;
    ?>
  </td>
            <td colspan="4"> Class Position


    <?php
    // Class Performace this term
   # $clas_performance  = get_all_student_performance_termly($this,$termid);
    #var_dump($exam_counts);
    #echo "<br/>";
    #           ($arranged);
    # echo "<br/>";print_r
    $position =  position_finder2($total_mark,$exam_counts,$arranged);

   # echo $position;


    ?>

    </td>
    </tr>
    </tr>

</table>


<?php
//}
if($x == 7890){}
else
{
?>
<div id="content-dv">>Click
    <a href="javascript:   updateFieldLayer('<?php echo base_url();  ?>students/load_registration_form/i/<?php echo encryptValue($std); ?>', '', '', 'contentdiv', '');" title="Click to edit  details.">

        here </a> <?php  echo " to register " . (($studentdetails['gender'] == 'Female')? ' her ' : ' him ') . " for a subject(s)" ?>

</div <?php
    }
    ?>

</td>
</tr>
</table>
</div>
<?php
/*
 *  Students Academic view Home Interface :
 */
#exit();
// create function to create xml files using machine level development
/*
$session_id = $this->session->userdata('session_id');
print_r($session_id);


# creat xml document and then access it and combine it wht the desired xslt ::
$xml = new DOMDocument("1.0");
#root element ::
$root = $xml -> createElement("reportmodule");
$xml -> appendChild($root);
# creat report
$report = $xml -> createElement("report");
$root -> appendChild($report);
# retport id
$reportid = $xml -> createElement("reportid");
$report -> appendChild($reportid);

/*
#create head element
$head = $xml -> createElement("head");
$report -> appendChild($head);
# head element children::
$logo1 = $xml -> createElement("logo1");
$head -> appendChild($logo1);
#logo 2
$logo2 = $xml -> createElement("logo2");
$head -> appendChild($logo2);
#title
$title = $xml -> createElement("title");
$head -> appendChild($title);
#address
$address = $xml -> createElement("address");
$head -> appendChild($address);
#email
$email = $xml -> createElement("email");
$head -> appendChild($email);
#tel
$tel = $xml -> createElement("tel");
$head -> appendChild($tel);
#motto
$motto = $xml -> createElement("motto");
$head -> appendChild($motto);
#term
$term = $xml -> createElement("term");
$head -> appendChild($term);
#class
$class = $xml -> createElement("class");
$head -> appendChild($class);
#year
$year = $xml -> createElement("year");
$head -> appendChild($year);
#names
$names = $xml -> createElement("names");
$head -> appendChild($names); */
#ending of the head department ::::####
#touching the body : part::
/*$body = $xml -> createElement("body");
$report -> appendChild($body);
#adding footer
$footer = $xml -> createElement("footer");
$report -> appendChild($footer);
#note
$note = $xml -> createElement("note");
$report -> appendChild($note);
#nextterm
$nextterm = $xml -> createElement("nextterm");
$report -> appendChild($nextterm);
#begins
$begins = $xml -> createElement("begins");
$nextterm -> appendChild($begins);
#ends
$ends = $xml -> createElement("ends");
$nextterm -> appendChild($ends);
#signature
$signature = $xml -> createElement("signature");
$nextterm -> appendChild($signature);
#fees
$fees = $xml -> createElement("fees");
$nextterm -> appendChild($fees);
#feestype
$feestype = $xml -> createElement("feestype");
$fees -> appendChild($feestype);
#fees
$feess = $xml -> createElement("fees");
$fees -> appendChild($feess); */
/*
#subjects
$subjects = $xml -> createElement("subjects");
$report -> appendChild($subjects);
#subjects
$subjects = $xml -> createElement("subjects");
$report -> appendChild($subjects);

#subject
$subject = $xml -> createElement("subject");
$subjects -> appendChild($subject);

// here you manipulate the subject in a do loop::

#subjectid
$subjectid = $xml -> createElement("subjectid");
$subject -> appendChild($subjectid);
#subjectname
$subjectname = $xml -> createElement("subjectname");
$subject -> appendChild($subjectname);

#subjectid
$subjectid = $xml -> createElement("subjectid");
$subject -> appendChild($subjectid);
#subjectname
$subjectname = $xml -> createElement("subjectname");
$subject -> appendChild($subjectname);



#adding exams to the game::
#exams
$exams = $xml -> createElement("exams");
$report -> appendChild($exams);

#exam
$exam = $xml -> createElement("exam");
$exams -> appendChild($exam);

#examname
$examname = $xml -> createElement("examname");
$exam -> appendChild($examname);
#examid
$examid = $xml -> createElement("examid");
$exam -> appendChild($examid);

#adding marksheet to exams and subjects in a given
/*
 * THE MATHEMATIC BEHIND IS THAT:: <<>><<>><<>>
 *  marksheet
 * THE MARKS SHOULD BE ARRANGED IN THE SAME FLOW AS THE EXAMS ARE ARRANGED :: IN THE DATABASE ::
 */
/*
#marksheet
$marksheet = $xml -> createElement("marksheet");
$report -> appendChild($marksheet);
#examid
$examid = $xml -> createElement("examid");
$marksheet -> appendChild($examid);
#examd
$examd = $xml -> createElement("examd");
$examid -> appendChild($examd);

#exams
$exams = $xml -> createElement("exams");
$examid -> appendChild($exams);

#subjectid
$subjectid = $xml -> createElement("subjectid");
$exams -> appendChild($subjectid);

#marks
$marks = $xml -> createElement("marks");
$exams -> appendChild($marks);

#avmark average mark
$avmark = $xml -> createElement("avmark");
$examid -> appendChild($avmark);
#examposition
$examposition = $xml -> createElement("examposition");
$examid -> appendChild($examposition);
#examremarks
$examremarks = $xml -> createElement("examremarks");
$examid -> appendChild($examremarks);
#examinitial
$examinitial = $xml -> createElement("examinitial");
$examid -> appendChild($examinitial);






/*

$id = $xml -> createElement("id");
$idText = $xml ->  createTextNode("1");
$id -> appendChild($idText);
$title   = $xml->createElement("title");
$titleText = $xml->createTextNode('"PHP TRUST"');
$title->appendChild($titleText);
$book = $xml->createElement("book");
$book->appendChild($id);
$book->appendChild($title);
$root->appendChild($book); */
/*
$xml->formatOutput = true;
echo "<xmp>". $xml->saveXML() ."</xmp>";
$xml->save("xml_files/".$session_id.".xml") or die("Error");


$xslDoc = new DOMDocument();
$xslDoc->load("xsl_files/collection.xsl");

$xmlDoc = new DOMDocument();
$xmlDoc->load("xml_files/".$session_id.".xml");

$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($xmlDoc);


print 'Reached Home Safely'; */
?>