<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//this class will be inherited from all controllers for logged in users
class User extends Main {
    
	public function __construct()
	{
		parent::__construct();
        //check if not logged in
        if(!$this->login_model->loggedin){
        	//then redirect to login controller
            redirect(base_url("login"));
        }

	}
}