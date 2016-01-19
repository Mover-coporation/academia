<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
  <tr>
    <td colspan="2" style="padding-top:0px;" class="pageheader">
        <table>
          <tr>
              <td valign="middle" colspan="3"></td>
          </tr>
  		</table>
    </td>
  </tr>
  <tr>
    <td colspan="2" style="padding-top:0px;" class="pageheader">
    </td>
  </tr>
    
<?php   
if(isset($msg)){
echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
    
  <tr>
    <td valign="top">
    
    
    <?php  
    #$page_list = array();
    if(!empty($page_list))
    {
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='5'>
    <tr>
    <td class='listheader'>&nbsp;</td>
    <td class='listheader' nowrap>School&nbsp;<a class='fancybox fancybox.ajax' href='".base_url()."admin/load_school_form' title='Click to add a school'><img src='".base_url()."images/add_item.png' border='0'/></a></td>
    <td class='listheader' nowrap>Location</td>
    <td class='listheader' nowrap>Contact Phone</td>
    <td class='listheader' nowrap>Expiry Date</td>
    <td class='listheader' nowrap>Days Left</td>
    <td class='listheader' nowrap>Date Added</td>
    </tr>";	
$counter = 0;	
foreach($page_list AS $row)
{
#Show one row at a time
echo "<tr style='".get_row_color($counter, 2)."'>
<td valign='top' nowrap>";
if(!empty($adduser) && $adduser == 'true')
{
    echo " &nbsp;&nbsp; <a href='".base_url().'admin/add_school_user/s/'.encryptValue($row['id'])."' title=\"Click to add users to ".$row['schoolname']."\"><img src='".base_url()."images/add_user.png' border='0'/></a>";
}
else
{
    echo "<a href='javascript:void(0)' onclick=\"confirmDeleteEntity('".base_url()."admin/delete_school/i/".encryptValue($row['id'])."', 'Are you sure you want to remove this school? \\nThis operation can not be undone. \\nClick OK to confirm, \\nCancel to cancel this operation and stay on this page.');\" title=\"Click to remove this deal.\"><img src='".base_url()."images/delete.png' border='0'/></a>";

    echo "&nbsp;&nbsp; <a class='fancybox fancybox.ajax' href='".base_url()."admin/load_school_form/i/".encryptValue($row['id'])."' title=\"Click to edit this school details.\"><img src='".base_url()."images/edit.png' border='0'/></a>";

    echo " &nbsp;&nbsp; <a  onclick=\"updateFieldLayer('".base_url()."admin/school_users/s/".encryptValue($row['id'])."','','','contentdiv','');\" href='javascript:void(0)' title=\"Click to view users in this school.\"><img src='".base_url()."images/users_icon.png' border='0'/></a>";
}

$days_left = get_date_diff(date('m/d/Y h:i:s a', time()),  $row['todate'], 'days');

 echo "</td>

<td valign='top'>".$row['schoolname']."</td>

<td valign='top'>".$row['district']."</td>
        
<td valign='top' nowrap>".$row['telephone']."</td>

<td valign='top'>".date("j M, Y", GetTimeStamp($row['todate']))."</td>
<td valign='top'>". (($days_left<0)? '<i>Expired</i>' : $days_left ) ."</td>
<td valign='top'>".date("j M, Y", GetTimeStamp($row['dateadded']))."</td>		
</tr>";

$counter++;
}


echo "<tr>
<td colspan='5' align='right'  class='layer_table_pagination'>".
pagination($this->session->userdata('search_total_results'), $rows_per_page, $current_list_page, base_url()."deal/manage_deals/p/%d")
."</td>
</tr>
</table>";	
    }
    else
    {
        echo "<div>No schools have been registered.</div";
    }

?>
    
    
    </td>
    </tr>
  
</table>