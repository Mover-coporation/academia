<?php
#Define all the left page menus

$menu_array = array();
#Show a different menu item list based on whether it is an admin or not
if($this->session->userdata('isadmin') && $this->session->userdata('isadmin') == 'Y')
{
	$menu_array['schools']['section'] = array('title'=>'Manage Schools', 'url'=>base_url().'admin/dashboard');
	$menu_array['schools']['Add School'] = base_url().'admin/load_school_form';
	$menu_array['schools']['Manage School Users'] = base_url().'admin/load_school_form';
	#$menu_array['schools']['Manage Schools'] = base_url().'admin/dashboard';	
	
	
	$menu_array['users']['section'] = array('title'=>'Users', 'url'=>base_url().'admin/manage_users');
	$menu_array['users']['Add a New User'] = base_url().'admin/load_user_form';
	$menu_array['users']['Manage Users'] = base_url().'admin/manage_users';
		
}

#Non-admin users
else
{
	$menu_array['news']['section'] = array('title'=>'News', 'url'=>base_url().'news/user_news_list');
	if(check_user_access($this,'view_news_feed')) $menu_array['news']['News Feed'] = base_url().'news/user_news_list';
	if(check_user_access($this,'view_news_archive')) $menu_array['news']['News Archive'] = base_url().'news/user_news_list/t/'.encryptValue('archive');
	
	
	$menu_array['invitations']['section'] = array('title'=>'Invitations', 'url'=>'javascript:void(0)');
	if(check_user_access($this,'view_invitations')) $menu_array['invitations']['Your Invitations'] = base_url().'deal/user_invitations_list';
	if(check_user_access($this,'view_invitation_archive')) $menu_array['invitations']['Invitations Archive'] = base_url().'deal/user_invitations_list/t/'.encryptValue('archive');
}

if(!empty($section) && $subsection != 'settings')
	$section_array = $menu_array[$section];
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
#Include only if there are other pages
if((!empty($section_array) && !empty($subsection)) || (!empty($subsection) && $subsection == 'settings'))
{


if(!empty($section_array))
{
    echo "<tr>
          	<td><a href='".$section_array['section']['url']."' class='menutitle'>".$section_array['section']['title']."</a></td>";
						  
	foreach($section_array AS $text=>$link)
	{
		if($text != 'section')
		{	
			echo "<td width='1%' class='listtablerow' style='padding-left:10px;'><img src='".base_url()."images/bullet.png' />		</td>
                  <td width='99%' class='listtablerow' nowrap>";
				  
			if(is_array($link))
			{
				$text_array = explode("<>", $text);
				foreach($text_array AS $count=>$subtext)
				{
					if($count > 0){
						echo " | ";
					}
					#Make text bold if current
					if(strtolower(str_replace(' ', '_', $subtext)) == $subsection)
					{
						$subtext = "<b>".$subtext."</b>";
					}
				
					echo "<a href=\"".$link[$count]."\" class='contentlink'>".$subtext."</a>";
				}
			}
			else
			{
				if(strtolower(str_replace(' ', '_', $text)) == $subsection)
				{
					$text = "<b>".$text."</b>";
				}
				echo "<a href=\"".$link."\" class='contentlink'>".$text."</a>";
			}
		
			echo "</td>";
		}
	}		  
     
    echo "</tr></table>";
}

}?>        
