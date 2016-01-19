<script src="<?php echo base_url();?>js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
<script src="<?php echo base_url();?>js/selectize.js" type="text/JavaScript" language="javascript"></script>


<td colspan="2" style="padding:2em 0 2em 2.5em;" align="left" bordercolor="">
<table cellpadding="10">
	<tr>
    <td valign="middle" width="10%"><img src="<?php echo base_url();?>images/sims_login.png" /></td>
    <td width="1%" valign="middle"><img src="<?php echo base_url();?>images/horizontal_sep.png" /></td>
    <td valign="middle">
    <?php
		$user_photo = $this->session->userdata('photo');
		if(!empty($user_photo)):
	?>
    	<div style="float:left; margin-right:9px">
    		<img style="" src="<?php echo base_url().(($this->session->userdata('usertype') == '')? 'images/small-no-photo.jpg' : 'downloads/users/'.student_photo_thumb($user_photo));?>" />
    	</div>
    <?php endif; ?>

    <div style="float:left">
    <span class="fullname"><?php echo wordwrap($this->session->userdata('names')); ?></span><br />
                  	<span class="usertype"><?php echo ($this->session->userdata('usertype') == 'MSR')? 'ADMINISTRATOR' : check_empty_value($this->session->userdata('usergroupname'), 'STANDARD USER') ; ?></span>
     	<table style="margin-top: 15px">
        	<tr>
            <td><a id="mysettings" onclick="updateFieldLayer('<?php echo base_url().'account/settings'; ?>','','','contentdiv','')" href="javascript:void(0);"><div>MY SETTINGS</div></a></td>
            <td><a id="logout" href="<?php echo base_url(); ?>admin/logout"><div>LOG OUT</div></a></td>
            </tr>
        </table>
     </div>

     <?php
		#$school_badge = $this->session->userdata('photo');
		#if(!empty($user_photo)):
	?>

    </td>
    </tr>
</table>
</td>
<!--<td valign="bottom" align="right" colspan="2"><span><a href="<?php //echo base_url(); ?>admin/logout">LOG OUT</a></span></td> -->