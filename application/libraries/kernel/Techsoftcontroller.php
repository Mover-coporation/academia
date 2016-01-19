<?php
# class that handles Process Post for most pages which just save and edit data
# for special cases, write your own process post page
class TechsoftController extends Generic{
    //constructor
    function __construct ($subclass_attributes = array()){
		$this->CI = &get_instance();
		$attributes = array (
             "action"     => "",
             "entityname" => "",
             "modulename" => "",
			 "modifier"   => "",
             "id"         => "",
             "successurl" => "",
             "failureurl" => ""
             );
             
         # merge the attibutes of the parent and the subclass
         $newattributes = array_merge($attributes, $subclass_attributes);

        # load the attributes by calling the parent constructor. This is to prevent changing
        # attributes at run time
        parent::__construct($newattributes);
    }


    # function that saves or updates the data based on the action
    # TODO: this can be expanded to cater for approvals, rejects, views e.t.c 
    function validate(){ //echo'palani'; echo'<pre>';print_r($_POST); exit;
        # change the class name to lower case
        $classname = $this->getEntityName(); 
		# include the proper class file, all file names are lower case
		$this->CI->load->library($classname);
        # echo "The path is ".$path."<br><br>";    
        # this seems to prefer a local variable with the data to evaluating an expression 
        # use the lower case name for the class it seems to work
        # populate the object with data from either the POST or the database load
        # this method also automatically validates whether the data is valid
		//echo 'asas'.$classname;exit;
        $new_object = $this->CI->$classname;
		$new_object->processPost($this->getDataArray());         
        # check if the validation was completed sucessfully
        if ($new_object->hasError()) {  
            # there are validation errors
            $this->setError($new_object->getError());
            return;
        } else {      
            $action = $this->getAction();           
            # only process objects that extend GenericEntity
            if (!($new_object instanceof GenericEntity)){     
                $this->setError("The action ".$action." cannot be executed on ".$classname);
                return;
            } 
			//if($classname='employeerelationship')
			 
            # continue processing based on the action
            switch ($action)  {
                 case "":    
                      $new_object->save(); 
                      $this->setID($new_object->getID());
					  if($new_object->getTable()=='rate' || $new_object->getTable()=='employeerelationship')
					  {
					     $new_object->save_audit("Rate-Created"); 
					  }	
					  else if($new_object->getTable()=='customreport')	{
					     // code to add scheduling for custom report
						 $new_object->insert_schedulingdata($_POST,"insert"); 
					  }		  
                      break;       
                 case "edit":      
                      $new_object->update();
					  if($new_object->getTable()=='rate'|| $new_object->getTable()=='employeerelationship')
					  {
					     $new_object->save_audit(); 
					  }else if($new_object->getTable()=='customreport')	{
					     // code to add scheduling for custom report
						 $new_object->insert_schedulingdata($_POST,"edit"); 
					  }
                      break;
                 case ACTION_CREATE_INVOICE:
                 	  $new_object->batchCreateInvoices();
                 	  break;
                 default:         
                      break;
            }           
            # check if there were any errors while processing the action on the object
            if ($new_object->hasError()) {
                # set this error in the controller
                $this->setError($new_object->getError());
            }
        }
    }

   /**
    * Return a URL based on whether there were errors while processing the relevant action.
    * 
    * The url forwarded to can be overridden by specifying the sucessurl and failure url properties
    * 
    * @return String the url to which to forward based on whether or not the action was successful.
    */ 
    function getUrl(){
        if ($this->hasError()) {//echo 'hasError';
			if (isEmptyString($this->getFailureURL())) {
        		return base_url()."tms/".$this->getModuleName()."/create".$this->getEntityName()."/".$this->getID()."/".$this->getAction()."/".$this->getModifier();
        	} else {//echo 'hasnoError';
        		return base_url().$this->getFailureURL();
        	}
        } else {
        	if (isEmptyString($this->getSuccessURL())) {
        		return base_url()."tms/".$this->getModuleName()."/view".$this->getEntityName()."/".$this->getID()."/".$this->getModifier();
        	} else {//echo 'noempty';
        		// check if the success url contains a query string
        		$separator = "/"; 
        		if (strpos($this->getSuccessURL(), "?") === false) {
        			// do nothing
        			$separator = "/";
        		} 
        		return base_url().$this->getSuccessURL().$separator."/".$this->getID();
        	}
        }
    }

    # function that returns the form values
    function getFormValues(){
        if ($this->hasError()) {
            return $this->getDataArray();
        } else {
            return array();
        }
    }
}
?>