<?php

function get_bid_invitation_info($passed_id, $param)
{
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');


    return $ci->bid_invitation_m->get_bid_invitation_info($passed_id, $param);

}

function get_bids_due_to_expire_next_week()
{
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');
    $from=mysqldate();
    $to=date('d-M-Y',strtotime(mysqldate())+604800) ;


    return $ci->bid_invitation_m->get_bid_submission_deadlines_by_month($from,$to);

}


function get_bid_invitation_by_procurement($procurement_id){
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');

    return $ci->bid_invitation_m->get_bid_invitation_by_procurement_id($procurement_id);


}


function get_bid_responses_per_procurement($procurement_id){
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');

    $bid_invitation_id=$ci->bid_invitation_m->get_bid_invitation_by_procurement_id($procurement_id);

    return get_bid_receipts_by_bid($bid_invitation_id);
}

function get_bid_invitation_info_by_procurement($procurement_id, $param)
{
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');


    return $ci->bid_invitation_m->get_bid_invitation_info($procurement_id, $param);

}

//get best evaluated bidder by procurement
function get_beb_by_procurement_ref_num($procurement_ref_no){
    //print_array($procurement_ref_no);
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');
    return $ci->bid_invitation_m->get_beb_by_procurement_ref_num($procurement_ref_no);
}

//get best evaluated bidder by bid
function get_beb_by_bid($bid_id,$param=''){
    $ci =& get_instance();

    $ci->load->model('bid_invitation_m');
    $result=$ci->bid_invitation_m->get_beb_by_bid($bid_id);
    foreach($result as $row){
        switch($param){
            case 'title':
                $result=$row['providernames'];
                break;
            case 'id';
                $result=$row['id'];
                break;
            case 'nationality':
                $result=$row['nationality'];
                break;
            default:
                $result;
        }
    }
    return $result;
}


function get_bid_responsiveness_by_bid($bid_id){
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');
    return $ci->bid_invitation_m->get_bid_responsiveness_by_bid($bid_id);
}

function get_extra_bed_info($bid_id){
    $ci =& get_instance();
    $ci->load->model('bid_invitation_m');
    return $ci->bid_invitation_m->get_beb_extra_details($bid_id);
}


