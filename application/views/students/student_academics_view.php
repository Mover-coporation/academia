<?php
?>
<style>
    select
    {
        background:url( '../images/select_slice.png') repeat-x #ddd;;
        background-image:url(' ../images/select_slice.png'),url('../images/select_slice.png'),url('../images/select_slice.png'),url(' ../images/select_slice.png');
        background-position:0 -136px, right -204px, 0% -68px, 10 0;
        background-repeat: no-repeat, no-repeat, no-repeat, repeat-x;

        cursor:pointer;

        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;
    }
    #select-academic-period{
        padding-bottom:10px;
    }
    #select-academic-period h1{
        padding:5px;
    }

    #print_button
    {
        padding: 5px; background: #999999; width: 40px; text-align: center; color:#ffffff;
    }
    #print_button:hover
    {
        color:#ffffff;background: #000;
    }
    input[type='checkbox']
    {

        -webkit-transform: scale(1.0,1.0);
        -moz-transform: scale(1.0,1.0);
        -o-transform: scale(1.0,1.0);
        cursor: pointer; z-index: 99999999;
    }

    #wrp
    {
        display: none;
    }
    .header
    {
        clear: both; display:none;
    }
    .header span
    {
        height: 100px; background:#000;
    }
    .header span img
    {
        height: 100px; float: left;
    }
    .header h1
    {
        float: left; margin-top: 30px; min-width: 300px; max-width: 450px; text-align: center; font-size: 30px;
    }
    .footer
    {
        padding-top:5px; clear: both; margin-top: 2px; text-align: left;
    }
  /* select
    {
        padding:20px; border:0px solid #fff;
    } */
</style>


<table border="0" cellspacing="0" cellpadding="10" width="100%" id='contenttable'>
          <tr>
            <td colspan="2" class="clear" style="padding:0px; vertical-align:top">

                <input type="hidden" value=" <?php echo encryptValue($std); ?>"  id="std"/>
            <div id="academics-menu" style=" width:100%; color:#000;">
            <?php

				echo '<div id="select-academic-period"  style="color:#000;">

				<h1 >Academic periods</h1></div>';

				if(!empty($academic_periods))
				{
					$academic_period_year = $academic_periods[0]['year'];

                    ?>
                    <section class="demo plugin">
                        <div class="sandbox">


                        </div>
                    </section>

                    <!-- onchange="javascript:fetchTerms(this.value);
                    "javascript:fetchTerms(this.value);-->
               <select style="padding: 5px; width: 200px; float: left;" id="select-car" onchange="javascript:fetchTerms(this.value)" onmouseover="javascript:fancy();" >

                        <option value="0">ACADEMIC PERIODS</option>
                        <?php
                        foreach($year_calendar as $year)
                        {
                        ?>
                            <option value="<?php echo  $year['year']; ?>"><?php echo  $year['year']; ?></option>
                        <?php

                        }
                        ?>
                    </select>

                    <select style="padding: 5px;width: 150px; max-width: 180px; float: left; display: none;" id="xterms" onchange="javascript:fetchinfo(this.value);" class="makeMeFancy">


                    </select>
                    <select style="padding: 5px; width: 150px; max-width: 180px; float: left; display:none;"  id="term" onchange="javascript:fetchexam(this.value);">


                    </select>
                    <select style="padding: 5px;width: 150px; max-width: 150px; float: left; display:none;"  id="subject" onchange="javascript:fetchsubjects(this.value);">


                    </select>




               <?php
				}
				else
				{
                    ?>Click
                    <a href="javascript:   updateFieldLayer('<?php echo base_url();  ?>students/load_registration_form/i/<?php echo encryptValue($std) ; ?>', '', '', 'contentdiv', '');" title="Click to edit Agatha's details.">

                        here </a> <?php  echo " to register " . (($studentdetails['gender'] == 'Female')? ' her ' : ' him ') . " for a subject(s)" ?>
                <?php

					echo $studentdetails['firstname']." has not been registered for any academic periods.";
				}

			?>

           </div>

                <div id="add-image" class="button     hover" style="width:50px; margin: 5px; text-align:center; float:left; margin-top:10px;" onclick="javascript:mailed();">
                    PRINT
                </div>

                <span style="padding-top: 10px; float: left; margin-top: 5px; display: block;" id="wrp">
<label for="chek">Show  Header </label>
                  <input type="checkbox" name="chek" onclick="javascript:header();" checked="checked"/>
<labe for="chek">Show  Footer </labe>
                <input type="checkbox" value="header" name="chek1"  onclick="javascript:footer();$('.fter').toggle();" checked="checked" />
</span>
                <div style="display:none;" id="printreport" >
                    <?php
                   $logourl  = $schoolid['logourl'];
                  # print_r($schoolid);
                    $school_name = $schoolid['schoolname'];
                    ?>
               <!--     <span>
                        <?php

                        function imgsplitter($imga)
                        {
                            $img = explode('.', $imga);
                            $imgurl = $img[0].'_thumb.'.$img[1];
                            return  $imgurl;
                        }

                        ?>
                       <?php
                       if($logourl == "")
                       {

                       }
                       else
                       {
                       ?>
                       <img src="<?php echo base_url(); ?>downloads/schools/<?php echo imgsplitter($logourl); ?>"  style="float: left;height:100px; margin-left: 5px;">
                       <?php } ?>)
                   </span>
                    <span>
                    <h1 style="clear:right;   margin-top: 30px; min-width: 300px; max-width: 450px; text-align: center; font-size: 30px;" > <?php echo $school_name;  ?> </h1>
                        </span>
                    <div id="student_info" style="clear: both; width: 100%;text-align: left; display: block;">
                        <h4 style="float: left;">Student Names : <?php echo $studentdetails['firstname'].' &nbsp; ',$studentdetails['middlename'].'&nbsp;'.$studentdetails['lastname']; ?></h4>
                    </div>
                    </div> -->
                </div>
          <?php
         # echo $str;
?>

                <div id="academic-content">


<?php

#write_xml();
#include("term_academic_info.php");
#exit(); ?>
           </div>
              <!--  <div style=" text-align: left; display: none;" id="printreport"  class="footer">
                    <br style="clear: both" />

                  <label>General Comments : </label> <input type="text" style="width:350px; border:1px solid #fff; border-bottom: 1px solid #000;"  placeholder=" " />
                    <br style="clear: both;" />
                    <br style="clear: both;" />
                    <label style="float: right;">: Class Teacher </label> <input type="text" style="width:350px; float: right; border:1px solid #fff; border-bottom: 1px dashed #000;"  placeholder=" " />
                    <br style="clear: both;" />
                    <br style="clear: both;" />
                    <label style="float: right;">: Head Teacher</label> <input type="text" style="width:350px; float: right; border:1px solid #fff; border-bottom: 1px dashed #000;"  placeholder=" " />

                </div> -->

			</td>
          </tr>
        </table>
