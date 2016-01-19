<?php
/*
 * THis MOdel is to Manage Calendar Years of a given schol at a gien point.
 * rmuyinda@newwavetech.co.ug
 */

class Marks_view  extends CI_Model
{

    #Constructor
    function __construct()
    {
        parent::__construct();
        // $this->load->model('Query_reader', 'Query_reader', TRUE);
        $this->load->database();
    }
    /*
     * Fetches Terms in a Given Year select passed. Fetch all Terms by Yea
     */
    function fetchaterms($year,$school_id)
    {
        $array = array('year' => $year, 'school' => $school_id,'isactive'=>'Y');
        $query =  $this ->db->select()->from('terms')->where($array)->group_by('term')->get();
        return $query->result_array();

    }
    function fetchexams($termid,$school_id)
    {
        $array = array('term' => $termid, 'school' => $school_id);
        $query =  $this ->db->select()->from('exams')->where($array)->get();
        return $query->result_array();
    }
    //fetch  subjects that the student registered for
    function fetchsubject($termid,$school_id)
    {
        $array = array('exams.id' => $termid, 'register.school' => $school_id);
        $query =  $this ->db->select()->from('register')->join('exams','exams.term =register.term','inner')->where($array)->get();
        return $query->result_array();
    }
    // fetch subjects from subjects table
    function fetchsubjects($subjectid)
    {
        $array = array('id' => $subjectid);
        $query =  $this ->db->select()->from('subjects')->where($array)->get();
        return $query->result_array();
    }
    function mark_per_exam($exam,$school,$subject,$studentid)
    {
        $array = array('marksheet.school' => $school,'marksheet.subject' => $subject,'marksheet.exam' => $exam,'marksheet.student' => $studentid);

        $query =  $this ->db->select('marksheet.id,marksheet.school,marksheet.mark,marksheet.exam as exms,marksheet.subject as subjt,marksheet.school,classes.class,students.*,classes.*,exams.exam as exm,exams.contribution,subjects.subject as sbj')->from('marksheet')->join('students','students.id  = marksheet.student ','inner')->join('classes','classes.id  = marksheet.class ','inner')->join('exams','exams.id  = marksheet.exam ','inner')->join('subjects','subjects.id  = marksheet.subject ','inner')->where($array)->get();
        return $query->result_array();
    }
    function mark_per_exam_student($exam,$school,$subject,$student)
    {

    }
}

?>