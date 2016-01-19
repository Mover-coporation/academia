<?php
# class that handles Process Post for most pages which just save and edit data
# for special cases, write your own process post page
class Controller extends Generic{
    //constructor
    function __construct ($subclass_attributes = array()){
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
    function validate(){
        # change the class name to lower case
        $classname = $this->getEntityName();
        # include the proper class file, all file names are lower case
        $path = ROOT."/app/class.".$classname.".php";  
        # echo "The path is ".$path."<br><br>";    
        # this seems to prefer a local variable with the data to evaluating an expression 
        include_once $path;     
        # use the lower case name for the class it seems to work
        $new_object = new $classname;        
        # populate the object with data from either the POST or the database load
        # this method also automatically validates whether the data is valid
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
            # continue processing based on the action
            switch ($action)  {
                 case "":                 
                      $new_object->save();   
                      $this->setID($new_object->getID());
                      break;       
                 case "edit":      
                      $new_object->update();
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
        if ($this->hasError()) {
			if (isEmptyString($this->getFailureURL())) {
        		return "../".$this->getModuleName()."/create".$this->getEntityName().".php?id=".$this->getID()."&action=".$this->getAction()."&modifier=".$this->getModifier();
        	} else {
        		return $this->getFailureURL();
        	}
        } else {
        	if (isEmptyString($this->getSuccessURL())) {
        		return "../".$this->getModuleName()."/view".$this->getEntityName().".php?id=".$this->getID()."&modifier=".$this->getModifier();
        	} else {
        		// check if the success url contains a query string
        		$separator = "&"; 
        		if (strpos($this->getSuccessURL(), "?") === false) {
        			// do nothing
        			$separator = "?";
        		} 
        		return $this->getSuccessURL().$separator."id=".$this->getID();
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