<?php

/**

 * Created by PhpStorm.

 * User: mover

 * Date: 6/30/14

 * Time: 5:15 PM

 APPLICATION TO SAMMARIZE DATA OFF ACADEMIA IN THE START INFO

 */ 

 ?>

 <div id="rapper">

     <br/> <br/>



 <div class="summarywrapper students" id="students-summary">



     <div id="info" CLASS="long">





         <div id="info-small">

             <span id="figures" class="color-green"><?php





                     $active =$activestudents['num'];

                // $active = number_filter($active);



                 echo $active;

                 ?> <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>students/load_student_form" title="Click to add a student"><img src="<?php echo base_url(); ?>images/add_item_big.png"> </a></span>

             <h1 id="hed">ACTIVE STUDENTS</h1>

         </div>





         <div id="info-small">

             <span id="figures" class="">

                 <?php

                 $total_students  =$activestudents['num'] + $inactivestudents['num'];

                // $total_students  = number_filter($total_students);

                echo $total_students;  ?>  </span>

             <h1 id="hed">TOTAL STUDENTS</h1>

         </div>



     </div>





 </div>

<div id="students_summary" class="icon icondown students_summary" dit="students" >

<div class="dashboardlabel">STUDENTS</div><div id="imag" class="down"> <img   src="<?php echo base_url(); ?>images/red_up.png"></div>

</div>

     <br/> <br/>

  <div   class="summarywrapper finances_summary finances" id="" >

      <div id="info" CLASS="long">



          <div id="info-small">

              <span id="figures" class="color-green">

                  <?php

                  $total_credits=  $total_credit['total'];

                  echo $total_credits ?> UGX



                  <h1 id="hed">EARNED</h1>

          </div>

          <div id="info-small">

              <span id="figures" class="color-red">

                  <?php

                  $outstanding= $total_debit['total'] -$total_credit['total'];

                  $outstanding= ($outstanding > 0 )  ? $outstanding : 0;

                //  $outstanding=  number_filter($outstanding);

                  ?>

                 <?php  echo   $outstanding;  ?>  UGX

                               <h1 id="hed">OUT STANDING</h1>

          </div>







      </div>





 </div>

<div id="students_summary" class="icon icondown" dit="finances">

    <div class="dashboardlabel">FINANCES</div><div id="imag" class="down"> <img   src="<?php echo base_url(); ?>images/red_up.png"></div>

</div>

     <br/> <br/>

 <div  class="summarywrapper school_summary setup" id="" >



     <div id="info" class="long">



         <div id="info-small">

             <span id="figures" class=""> <?php echo  number_format($teachers['schoolusers'],0,'.',','); ?>

                 <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>user/load_staff_form" )'="" title="Click to add a Teacher">

                 <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

             </span>

             <h1 id="hed">TEACHERS</h1>

         </div>

         <div id="info-small">

             <span id="figures" class="">

                 <?php

                 $classes= $classes['class_count'];

                 echo  $classes;  ?>

                 <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>classes/load_class_form" )'="" title="Click to add a class">

                 <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

             </span>

             <h1 id="hed">CLASSES</h1>

         </div>

         <div id="info-small">



             <span id="figures" class="">  <?php

                 $terms= $terms['terms'];

                 echo  $terms;

                 ?>



                 <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>terms/load_term_form" )'="" title="Click to add a term">

                 <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

             </span>

             <h1 id="hed">TERMS</h1>

         </div>

         <div id="info-small">



             <span id="figures" class="">

                 <?php

                 $users= $users['schoolusers'];

                 echo  $users;

                ?>

                 <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>user/load_staff_form" )'="" title="Click to add a user">

                 <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

             </span>

             <h1 id="hed">USERS</h1>

         </div>

     </div>





 </div>

<div id="students_summary" class="icon icondown" dit="setup">

    <div class="dashboardlabel">SCHOOL SET UP</div> <div id="imag" class="down"> <img   src="<?php echo base_url(); ?>images/red_up.png"></div>



</div>

     <br/>  <br/>

<div  class="summarywrapper library_summary library"  >

    <div id="info" class="long">

       

        <div id="info-small">

            <span id="figures" class="">



                <?php

                $lent= $lent['books'];

                echo  $lent;

               ?>

                <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>library/borrow_books" title="Click to issue multiple books">

                 <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

            </span>

            <h1 id="hed">BOOKS LENT</h1>

        </div>

        <div id="info-small">

            <span id="figures" class="color-red">

                  <?php

                  $defaulters= $defaulters['defaulters'];

                  echo  $defaulters;

                  ?>





            </span>

            <h1 id="hed">DEFAULTERS</h1>

        </div>

        <div id="info-small">

            <span id="figures" class="">

                 <?php

                 $available= $available['books'];

                 echo  $available;

                 ?>

                <a class="fancybox fancybox.ajax" href="<?php echo base_url(); ?>library/load_title_form" title="Click to add a Book">

                    <img src="<?php echo base_url(); ?>images/add_item_big.png"></a>

            </span>

            <h1 id="hed">AVAILABLE BOOKS</h1>

        </div>



    </div>

</div>

<div id="students_summary" class="icon icondown" dit="library">

    <div class="dashboardlabel">LIBRARY</div><div id="imag" class="down"> <img   src="<?php echo base_url(); ?>images/red_up.png"></div>



</div>

 </div>