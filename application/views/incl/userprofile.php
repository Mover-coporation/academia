<div class="userprofile">
          	<table cellpadding="5" width="100%" style="border-bottom:1px solid #F0F0E1; border-right:1px solid #F0F0E1;">
            	<tr>
                	<td colspan="2">
                    <?php
					if($this->session->userdata('usertype') == 'SCHOOL')
					{
						$schoolinfo = $this->session->userdata('schoolinfo');
						echo '<span class="school">'.$schoolinfo['schoolname'].'</span>';
					}
					elseif($this->session->userdata('usertype') == 'MSR')
					{
						echo '<span>ACADEMIA</span><br />
                			<span class="school">CONTROL PANEL</span>';
					
					}
					?>
                    </td>
                </tr>
                <tr>
                  <td colspan="2" valign="top">
                  <a class="grey_buttons" href="<?php echo base_url().(($this->session->userdata('usertype') == 'MSR')? 'admin/dashboard' : 'user/dashboard')?>">START HERE
                  </a>
                  
                  <a class="grey_buttons" href="<?php echo base_url().(($this->session->userdata('usertype') == 'MSR')? 'admin/dashboard' : 'user/dashboard')?>">HELP
                  </a>
                  
                  <a class="grey_buttons" id="school-info" href="javascript:void(0);">
                  	SCHOOL INFO
                  </a>
                  </td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
          	</table>
          </div>
