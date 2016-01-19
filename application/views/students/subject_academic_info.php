<?php
/**
 * Created by PhpStorm.
 * User: ntsc
 * Date: 6/19/14
 * Time: 5:42 PM Identify the Persons performance in a given subject
 * @mover newwavetech.co.ug
 */
?>




    <style>
        .wrapper
        {
            width:500px;  height:400px; display:block; clear: both; margin-top: 20px;;
        }
        .wrapper ul
        {
            width:100%; min-height:400px;
        }
        .wrapper ul li
        {
            list-style:none; height:40px; margin:0px; margin-bottom:5px; width:100%; margin-left:-30px;

        }
    </style>
<br/>
<br/>

    <div id="printreport" class="wrapper" >


        <?php


        ?>
        <label>

         <?php
        // var_dump($mark_per_subject);
// Gettng Information about the Subject Performance
if(!empty($mark_per_subject))
{
         foreach($mark_per_subject as $utb)
         {
          $clas = $utb['class'];
             $exam = $utb['exm'];
             $subject = $utb['sbj'];
             $mark = $utb['mark'];
             $sbject = $utb['subjt'];
             $school = $utb['school'];
             $exms = $utb['exms'];
         }
    //get_all_student_performance_subject
    $performance  =  get_all_student_performance_subject($this,$sbject,$school,$exms);
    // Get Student Performance
    $position  = position_finder($mark,0,$performance)
            ?>
<br style="clear: both;" />
    <table>
        <tr>
            <td>
                <label>Class : <?php echo $clas; ?></label>
            </td>
        </tr>
        <tr>
            <td>
                Exams :<?php echo $exam; ?>
            </td>
            <td>
                &nbsp; Subject  :   <?php echo $subject;  ?>
            </td>
        </tr>
        <tr>
            <td>
                Marks : <?php echo $mark; ?>
            </td>
        </tr>
        <tr>
            <td>
                Position : <?php echo $position; ?>
            </td>
        </tr>
    </table>





<?php
}
else
{



    echo $studentdetails['firstname'].'&nbsp; &nbsp; Is not Graded .';
}
?>