<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Academia Login Form</title>    
    <!-- Load CSS Academia Beta --> 
     <link rel="stylesheet" href="<?=base_url()?>assets/css/academia_beta.css">    
    <!-- Javascript -->
    <?php echo minify_js('account-registration', array('jquery-2.1.1.min.js', 'jquery-ui.js', 'jquery.form.js','registration.js'));?>
  </head>

  <body>

  <hgroup>
  <h1><img src="<?=base_url()?>assets/images/sims_login.png"></h1>
</hgroup>
<div class="container">
<div class="kayitback">

<form action="schoolreg.php" method="post" >
<h4 style="margin-bottom:32px;">Sign in if you are registered</h4>
  
  <div class="group">
    <input type="email"><span class="highlight"></span><span class="bar"></span>
    <label>Username</label>
  </div>
  <div class="group">
   <input type="email"><span class="highlight"></span><span class="bar"></span>
    <label>Password</label>
  </div>
  
  <button   class="button buttonBlue"type="submit">Login
  </button>
</form>
</div>
<div class="girisback">

<form 
method="post"
		action="<?=base_url();?>registration/register_user_account" 
		class="simple_form" 
		id="register" 
		name="evaluatebeb"  data-type="newrecord"  data-cheks="pdename<>pdecode" 
		data-check-action="<?=base_url();?>bids/savebeb/" 
		data-action="<?=base_url();?>accpount/savebeb" 
		data-elements="*account_name<>*account_email<>*account_username<>*account_password" 
 >
 

<h4 style="margin-bottom:32px;">If you are new Sign Up</h4>

  <div class="group">
    <input type="text" id="account_name" class="account_name"  name="account_name"><span class="highlight"></span><span class="bar"></span>
    <label>Name</label>
  </div>
  <div class="group">
    <input type="text" datatype="email" name="account_email" id="account_email" class="account_email"><span class="highlight"></span><span class="bar"></span>
    <label>Email</label>
  </div>
  <div class="group">
    <input type="text" id="account_username" name="account_username" class="account_username" ><span class="highlight"></span><span class="bar"></span>
    <label>Username</label>
  </div>
  <div class="group">
    <input type="password" id="account_password" class="account_password" name="account_password" ><span class="highlight"></span><span class="bar"></span>
    <label>Password</label>
  </div>
  <button type="submit"  name="register_account" class="button buttonBlue">Register  </button>
</form>
</div>

</div>   
    
    
    
  </body>
</html>
