<?php
// Config Settings
#  ===============
	define('SECURE_MODE', FALSE);
	
	define('BASE_URL', 'http://localhost/academia_new');
	#Set to HTTPS:// if SECURE_MODE = TRUE
	
	define('SITE_TITLE', "ACADEMIA");
		
	define('SITE_SLOGAN', "School Management Solutions");
	        	        
	define('SITE_ADMIN_MAIL', "sirotim@gmail.com");
	
	define('SITE_ADMIN_NAME', "ACADEMIA Admin");
	
	define('SYS_TIMEZONE', "America/Los_Angeles");
	
	define('NUM_OF_ROWS_PER_PAGE', "10");
	
	define('IMAGE_URL', BASE_URL."images/");
	
	define('HOME_URL', getcwd()."/");
	
	define('UPLOAD_DIRECTORY',  HOME_URL."downloads/");
	
	define('MAX_FILE_SIZE', 40000000);
	
	define('ALLOWED_EXTENSIONS', ".doc,.docx,.txt,.pdf,.xls,.xlsx");
	
	define('MAXIMUM_FILE_NAME_LENGTH', 100);
	
	define("MINIFY_JS", true);
	
	define("NOREPLY_EMAIL", "votim@newwavetech.co.ug");
	
	define("APPEALS_EMAIL", "info@newwavetech.co.ug");
	
	define("SECURITY_EMAIL", "info@newwavetech.co.ug");
	define("MINIFY", FALSE);
	
	
	
	/*
	|--------------------------------------------------------------------------
	| URI PROTOCOL
	|--------------------------------------------------------------------------
	|
	| The default setting of "AUTO" works for most servers.
	| If your links do not seem to work, try one of the other delicious flavors:
	|
	| 'AUTO'	
	| 'REQUEST_URI'
	| 'PATH_INFO'	
	| 'QUERY_STRING'
	| 'ORIG_PATH_INFO'
	|
	*/
	
	define('URI_PROTOCOL', 'AUTO'); // Set "AUTO" For WINDOWS
									       // Set "REQUEST_URI" For LINUX

// Database Settings
#  =================

	define('HOSTNAME', "localhost");	        
	
	define('USERNAME', "root");
	
	define('PASSWORD', "");
	
	define('DATABASE', "academia");
	
	define('DBDRIVER', "mysqli");
	
	define('DBPORT', "3306");


// Email Settings
#  ==============

	define('SMTP_HOST', "smtp.1and1.com");
	
	define('SMTP_PORT', "25");
	
	define('SMTP_USER', "votim@newwavetech.co.ug"); 
	
	define('SMTP_PASS', "newwave");
	
	define('FLAG_TO_REDIRECT', "1");// 1 => Redirect emails to a specific mail id, 
									 // 0 => No need to redirect emails.
	/*
	| If "FLAG_TO_REDIRECT" is set to 1, it will redirect all the mails from this site
	| to the email address  defined in "MAILID_TO_REDIRECT".
	*/
		
	define('MAILID_TO_REDIRECT', "sirotim@gmail.com");
?>