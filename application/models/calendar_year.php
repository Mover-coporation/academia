<?php

/*

 * THis MOdel is to Manage Calendar Years of a given schol at a gien point.

 * rmuyinda@newwavetech.co.ug

 */



class Calendar_year  extends CI_Model
{



    #Constructor

    function __construct()

    {

        parent::__construct();

       // $this->load->model('Query_reader', 'Query_reader', TRUE);

        $this->load->database();

    }

   #adding new calendar year ::

    function new_calendar_year($year,$schoolid)

    {

        $data  = array(

            'school' => $year,

            'year' => $schoolid,



        );

        $query  =  $this->db->insert('calendar_year',$data);

        $result = $this->db->query($query);

        return  $result;

        return  $result;



    }

    function fetch_calendar_year($schoolid)

    {

        $query =  $this ->db->select()->from('terms')->where('school',$schoolid)->group_by('year')->order_by('year','DESC')->get();

        return $query->result_array();



    }



}