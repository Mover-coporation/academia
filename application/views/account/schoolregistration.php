<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Academia School Registration </title>    
    <!-- Load CSS Academia Beta --> 
     <link rel="stylesheet" href="<?=base_url()?>assets/css/academia_beta.css">    
    <!-- Javascript -->
    <?php echo minify_js('account-registration', array('jquery-2.1.1.min.js', 'jquery-ui.js', 'jquery.form.js','registration.js'));?>
  </head>

  <body>

    <hgroup>
  <h1><img src="<?=base_url()?>assets/images/sims_login.png" /></h1>
</hgroup>
<div class="container">


<form action="<?=base_url()?>registration/register_school_account" method="post" class="formmod col-md-9 ">

<?php
if(!empty($SUCCESS))
{
	print_r($SUCCESS);
}
else if(!empty($ERROR))
{
	print_r($ERROR);
}
else{}


?>

<h3 style="margin-bottom:32px;">School Registration</h3>


<div class="row">
  
  <div class="group col-md-6">
    <input type="text" name="school_name" id="school_name" class="school_name"><span class="highlight"></span><span class="bar"></span>
    <label>School Name </label>
  </div>
  
  <div class="group col-md-6">
   <input type="text" name="school_licence" id="school_licence"  class="school_licence" ><span class="highlight"></span><span class="bar"></span>
    <label>Liscence</label>
    
  </div>
  <div class="group col-md-6">
    <input type="text" name="phone_number" id="phone_number" class="phone_number" ><span class="highlight"></span><span class="bar"></span>
    <label>Phone Number</label>
  </div>
  <div class="group col-md-6">
    <input type="email" name="school_email" id="school_email" class="school_email" ><span class="highlight"></span><span class="bar"></span>
    <label>Email Address </label>
  </div>
  <div class="group col-md-6">
    <select class="selectspace form-control type_of_school " id="type_of_school"  name="type_of_school">
    <option value="" disabled selected>Choose School Type</option>
    <option value="1">secondary</option>
    <option value="2">primary</option>
    </select>
    <span class="highlight"></span><span class="bar"></span>
    <label class="labelspace">Type of School</label>
    <p></p>
  </div>

  <div class="group  col-md-6">
    <textarea id="physical_address" placeholder=""></textarea><span class="highlight"></span><span class="bar"></span>
    <label>Physical Address</label>
  </div>
    
 
  
  <div class="group col-md-6 file-field">
      <div class="btn">
        <span>Logo</span>
        <input type="file">
      </div>
      <div class="file-path-wrapper">
    <input  type="text" placeholder="Choose Logo"><span class="highlight"></span><span class="bar"></span>

    </div>
  </div>
  <div class="col-md-9">
  <div class="group col-md-7">
      <button   class="button buttonBlue" name="register_school_account" type="submit">Register
   
  </button>
  </div>
  </div>
</form>
</div>
   
    
    
    
  </body>
</html>
