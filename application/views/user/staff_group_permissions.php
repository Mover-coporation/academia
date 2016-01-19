<div id="staff-group-permissions">
        <table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<table>
          		<tr>
            		<td valign="middle"><div class="page-title"> <?php echo 'Manage staff group permissions'; ?></div></td>
            		<td valign="middle">&nbsp;</td>
                    <td valign="middle">&nbsp;</td>
            	</tr>
          </table>
			</td>
          </tr>
          <tr>
            <td colspan="2" style="padding-top:0px;" class="pageheader">
            	<div class="grey_ruler"></div>
			</td>
          </tr>
            
 <?php   
if(isset($msg)){
	echo "<tr><td colspan='4'>".format_notice($msg)."</td></tr>";
}
?>           
            
          <tr>
            <td valign="top">
            <form id="staff-group-permissions-form" name="form1" method="post" action="<?php echo base_url() . 'user/manage_staff_group_rights/i/' . $i; ?>">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px;">
                  <?php 
				
				if(!empty($all_permissions)){
				?>
				<tr>
						<td style="padding:0px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="99%" style="padding:5px;
	font-weight:bold;	 
	background-color: #000000;
	text-align:left;
	color: #FFFFFF;padding-left:10px; font-size:13px;">Updating permissions for <?php echo $groupdetails['groupname'];?></td>
                        </tr>
                    </table>						</td>
						</tr>
                <tr>
                    <td style="padding-top: 0px;
	padding-bottom: 5px;
	text-align: left;font-size: 13px;">
					
					  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                      	
					    <tr>
                          <td colspan="2" style="background-color:#E6E6E6;
	font-style:italic;font-size: 13px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
                          <td width="1%" style="padding-right:5px"><input name="selectall" id="selectall"  type="checkbox" onclick="selectCheckBoxList('selectall', '<?php echo implode(",", $all_permissions_list);?>', 'permission_')" value=""/></td>
                          <td style="background-color:#E6E6E6;
	font-style:italic;font-size: 13px;" width="99%"><b>Select All Permissions</b></td>
                        </tr>
						</table>
						</td></tr>
						
						<tr>
                          <td colspan="2" height="10"></td></tr>
						<tr>
                          <td colspan="2">
                <?php /*$peek_counter = 0;
				foreach($all_permissions AS $row){
					if(($userdetails['isadmin'] == 'Y' && $row['accessfor'] == 'admin') || ($userdetails['isadmin'] == 'N' && $row['accessfor'] == ''))
					{
						$peek_counter++;
					}
				}
				*/
				$counter = 0;
				$oldsection = "";
					  
				foreach($all_permissions AS $row){
					  
					  $section = $row['section'];
					  
					  if($section != $oldsection){
					  	if($oldsection != ''){
							echo "</table></div><br>";
						}
						
						 echo "<a href=\"javascript:showHideLayer('".$row['section']."_div')\" class='bluelink'>".ucfirst($row['section'])."</a><hr><div id='".$row['section']."_div' style='display:none'>
						 
						 <table width='100%' border='0' cellspacing='0' cellpadding='3'>";
					  }
					  
					  
					  echo "<tr style='".get_row_color($counter, 2)."'>
                          <td style='font-size: 13px;' width='1%' nowrap><input name='permissions[]' id='permission_".$row['id']."' onClick=\"selectCheckBoxListWithUncheck('permission_".$row['id']."', '".get_related_permissions($this, $row['id'])."', '".get_related_permissions($this, $row['id'],'uncheck')."', 'permission_')\" type='checkbox' value='".$row['id']."'";
						if(in_array($row['id'], $permissions_list)){ 
						echo " checked";
						}
					  echo "/></td>
                          <td style='font-size: 13px;' width='99%' nowrap><label for='permission_" . $row['id'] . "'>".$row['permission']."</label></td>
                        </tr>";
					  
					  	if($counter == (count($all_permissions) - 1)){
					  		echo "</table></div>"; 	
						}
						
						$oldsection = $row['section'];
						$counter++;
				
			} ?>
					  </td></tr>
                      </table>					</td>
                  </tr>
				 <?php
					}
					else 
					{
						echo 'There are no permissions accessed by this user group.';
					}
					?>
				  
                  <tr>
                    <td nowrap="nowrap" style="padding-left:15px; padding-top:10px"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="2" nowrap><input name="editid" type="hidden" value="<?php echo $i;?>" />&nbsp;
                        <input type="hidden" name="updategrouppermissions" id="updategrouppermissions" value="Save Permissions" /></td>
                        <td><input type="submit" name="updatepermissions" id="updatepermissions" value="Save Permissions" class="button"/></td>
                      </tr>
                    </table>                      </td>
                  </tr>
                  <tr>
                    <td nowrap="nowrap">&nbsp;</td>
                  </tr>
                </table>
            </form>
            </td>
          </tr>
          
        </table>
    </div>
	