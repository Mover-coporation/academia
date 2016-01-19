<?php
/**
 * Created by PhpStorm.
 * User: cengkuru
 * Date: 1/22/2015
 * Time: 4:59 PM
 */
function get_provider_info_by_id($id,$param)
{
    $ci=& get_instance();
    $ci->load->model('provider_m');

    return $ci->provider_m->get_provider_info($id, $param);
}


function get_provider_by_procurement($procurement_id)
{
    $ci=& get_instance();
    $ci->load->model('provider_m');

    return $ci->provider_m->get_provider_by_procurement($procurement_id);
}




