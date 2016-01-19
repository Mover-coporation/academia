
<div id="printreport" class="printreport">
<?php
/*
 * Student Academic Performace in a Given Year Calendar
 */
echo "<br/>";


$session_id = $this->session->userdata('session_id');
#print_r($session_id);

#$xml begins here
$xml = new DOMDocument("1.0");

#root element ::
$root = $xml -> createElement("reportmodule");
$xml -> appendChild($root);



foreach($termdetails as $terms)
{



    $termid  = $terms['id'];

  //  echo $termid."...".$studentid."<br/>";
    $term  = $terms['term'];
    # hear is where every thing happens right 0n ##



# creat report
    $report = $xml -> createElement("report");
    $root -> appendChild($report);



# retport id
    $reportid = $xml -> createElement("reportid");
    $report -> appendChild($reportid);

$data['registration_data'] =  $registration_data = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'searchstring'=> 'student='.$studentid.' AND term ="'.$termid.'"'));
 $termdetails = $this->Query_reader->get_row_as_array('search_terms_list', array('isactive' => 'Y', 'limittext' =>'','searchstring'=> ' AND id = '.$termid ));

// Registration
 $registration_data =  $registration_data = $this->Query_reader->get_row_as_array('search_register', array('limittext'=>'', 'searchstring'=> 'student='.$studentid.' AND term ="'.$termid.'"'));

if(!empty($registration_data))
{
    $exams = $this->db->query($this->Query_reader->get_query_by_code('search_exams', array('limittext'=>'', 'searchstring'=> ' AND classes like "%'.$registration_data['class'].'%" AND term ="'.$termid.'" AND isactive="Y"')))
        ->result_array();
    //get the subject details
    $subject_arr = remove_empty_indices(explode('|', $registration_data['subjects']));
    #print_r($registration_data);
    #exit();
    if(!empty($subject_arr))
    {
        $subjects = $this->db->query($this->Query_reader->get_query_by_code('search_subjects', array('limittext'=>'', 'searchstring'=>' AND id IN ('.implode(',', $subject_arr).')', 'isactive'=>'Y')))
            ->result_array();
// Class Details
        $classdetails = get_db_object_details($this, 'classes', $registration_data['class']);

    }

}

    #head information ::

    #create head element
    $head = $xml -> createElement("head");
    $report -> appendChild($head);
    # head element children::
    $logo1 = $xml -> createElement("logo1");
    //logourl
    $thim = explode('.',$schoolid['logourl']);
        #explode('.',$schoolid['logourl']);
    $thumm = $thim[0].'_thumb.'.$thim[1];
        #$thim[0].'_thumb.'.$thim[1];
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
    $pobox   = $xml -> createElement("pobox");
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

    ##end


    #subjects
    $subjecta = $xml -> createElement("subjects");
    $report -> appendChild($subjecta);

    $exam_counts = 0;



    $counter =0;
    $mark_counter   =0;
    $mark_counter2   =0;
    $mark   ='0';
    $subject_count  = count($subjects);
    $exam_count = count($exams);
    $rt = "";

    $arranged  = arrange_student_marks($this,$exams,$studentdetails['id']);

    if(count($exams))
    {
        $counter = 0;
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




        $counter =0;
#marksheet
        $marksheet = $xml -> createElement("marksheet");
        $report -> appendChild($marksheet);

        foreach($subjects as $subject)
        {
            $examid = $xml -> createElement("examid");

            $examd = $xml -> createElement("examd");
            $titleText = $xml->createTextNode($subject['id']);
            $examd->appendChild($titleText);
            $examid -> appendChild($examd);
            $marksheet -> appendChild($examid);
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
                }else{$position = "Not Graded"; }
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

        }

        #class performance ::
        #adding the position ::
        $position = $xml -> createElement("position");
        #find class performance per exam ::
        #  print_r($exam);
        $clas_performance  = get_all_student_performance_termly($this,$termid);
       # print_r($clas_performance);
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


    }

    ?>


<div id="printreport" class="printreport">
<table border="0" cellspacing="0" cellpadding="10" width="100%"  style="clear:both;">

          <tr>
            <td colspan="2" class="clear" style="padding:0px; vertical-align:top">
		   <?php
		   		if(!empty($subjects))
                {
                 #   print_r($subjects);
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
                    <!--
                    <div style="padding:0.5em 0.5em 0.5em; border-bottom:1px solid #000000; margin-bottom:10px"><?php echo '<b>Class:</b> '.$classdetails['class'].' <b>Term:</b>'.$termdetails['term'].', '.$termdetails['year']; ?>

                    </div> -->

                   <!-- <table cellpadding="8" border="0" class="mark_sheet" cellspacing="0">

                        <tr class="marksheet_exam_headers">
                            <?php
                            $exam_counts = 0;
                            if(count($exams))
                            {
                                $counter = 0;
                                $exam_summary_column_headers = '';

                              #  echo '<td class="right_border">Exam</td>';


   $counter =0;
    $mark_counter   =0;
    $mark_counter2   =0;
    $mark   ='0';
    $subject_count  = count($subjects);
    $exam_count = count($exams);
    $rt = "";

    //   $subtotals


    $arranged  = arrange_student_marks($this,$exams,$studentdetails['id']);



                                //echo exam headers
                                foreach($exams as $exam_details)
                                {
                                    $exam_counts ++;
                                    echo '<td colspan="4" class="marksheet_exam_headers_cell">'.$exam_details['exam'].'</td>';

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
                                }

                                //echo marks headers
                                echo '</tr><tr><td class="right_border">Subjects</td>'.$exam_summary_column_headers.'</tr>';

                            }
                            else
                            {
                                echo "<td>No exams have been specified for this term</td>";
                            }
                            ?>

                            <?php

                            //$counter =0;
                            //output marks for each subject
                            $counter =0;
                            $mark_counter   =0;
                            $mark_counter2   =0;
                            $mark   ='0';
                            $subject_count  = count($subjects);
                            $exam_count = count($exams);
                            $rt = "";
                            $exm_info = "";

                            //   $subtotals


                            $arranged  = arrange_student_marks($this,$exams,$studentdetails['id']);

                            foreach($subjects as $subject)
                            {
                                echo '<tr '.(($counter%2 == 0)? 'style="background-color: #F0F0E1;"' : '').' class="mark_sheet_row">
            				<td class="right_border">'.$subject['subject'].'</td>';

                                //Get marks for each exam

                                foreach($exams as $exam_info)
                                {
                                    //performance summary
                                    $exam_performance_summary = get_subject_performance_summary($this, $registration_data['class'], $exam_info['id'], $subject['id']);
                                    //get the student's marks for the current exam
                                    $student_marks = $this->Query_reader->get_row_as_array('search_mark_sheet', array('limittext'=>'', 'searchstring'=>' student='.$registration_data['student'].' AND subject='.$subject['id'].' AND exam='.$exam_info['id']));

                                    if(empty($student_marks))
                                    {
                                        $student_marks['mark'] = '';
                                        $student_marks['comments'] = '';
                                    }
                                    // Grading of Students Starts Here :: --
                                    $mark  = ($student_marks['mark'] =='')?0:$student_marks['mark'];
                                    //$mark  = percentage_finder($mark,$exam_info['contribution']);
                                    $mark_counter = $mark_counter +$mark;
                                    $mark_counter2 = $mark ;
                                    $exm_info = $exam_info['id'];
                                    $exam_sumary = get_all_student_performance_exams($this,$exam_info['id'],$studentdetails['id']);
                                    $rt .=  $mark_counter2 ."**";
                                    echo '<td><div class="marks_cell">mover'.$student_marks['mark'].' </div></td>
                			 <td><div class="marks_cell">'.$exam_performance_summary['average'].'</div></td>
                			 <td><div class="marks_cell">'.$exam_performance_summary['highest'].'</div></td>
                			 <td class="right_border"><div class="marks_cell">'.$exam_performance_summary['lowest'].'</div></td>';
                                }

                                // Level 2
                                $mark_counter2 = 0;
                                $rt .="##";

                                echo '</tr>';


                            $counter++;
                            if($counter == $subject_count )
                            {
                            ?>
                        <tr>

                            <td> Sub Totals  </td>
                            <td>
                                <?php
                                /*********************************************************
                                 * Declaring a subtotal array to explode all the records @mover
                                 */
                                $subtotal_array =explode('##',$rt);

                                //echo $subtotal_array[0];
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
                               $weask =   get_student_subject_info($this,$registration_data['class'],$exm_info,$subject['id'], $mark );
                                //  echo $weask; ?>
                            </td>
                        </tr>

                        </tr>
                        <tr><td>Average Total </td>
                            <td colspan="4">

                                <?php
                                echo  round_up($total_mark,2) ;
                                ?> </td>
                            <td colspan="4"> Class Position :

                                <?php
                                // Class Performace this term
                                // Class Performace this term
                                $clas_performance  = get_all_student_performance_termly($this,$termid);
                                //var_dump($arranged);

                                $position =  position_finder2($total_mark,$exam_counts,$arranged);

                                echo $position;

                                ?>

                            </td>
                        </tr>

                    </table> -->


                <?php
                }
                else
                {echo $studentdetails['firstname']." has not registered for any subjects in ".$termdetails['term'].", ".$termdetails['year'] ."<br />"?>
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
}
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


?>
</div>