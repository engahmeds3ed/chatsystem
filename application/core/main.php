<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
    var $foldername = "site"; //theme folder name inside views folder
    var $cur_userdata;//current user data
    var $assets = "";//assets path folder
    var $data = array();//shared data that will be passed to the view
    
	public function __construct()
	{
		parent::__construct();

        //set assets folder
        $this->assets = base_url().'assets/'.$this->foldername."/";
        
        //make some startup configurations
        $this->load->model("config_model");
        //load site configurations to be available for view usage
        $this->data['config'] = $this->config_model->all;
        //load object from config model to be available for view usage
        $this->data['obj_config'] = $this->config_model;
        
        //login
        //load login model, this will check if user is logged in or not based on session saved values and set or unset the attribute loggedin in login_model
        $this->load->model("login_model");
        
        //check if loggedin or not
        if($this->login_model->loggedin){
            //get current user info
            $this->login_model->get_cur_userdata();
            //save current user info into attribute to be used on the child controllers from this controller
            $this->cur_userdata = $this->login_model->cur_userdata;
            //save current user info into data attribute to be available for view
            $this->data['cur_userdata'] = $this->login_model->cur_userdata;
            
            //set the initial path of page redirected after login
            $this->data['cp'] = base_url("dashboard");
        }
        //save loggedin status for views
        $this->data['loggedin'] = $this->login_model->loggedin;
        
        //save initial value for website title used in html title tag
        $this->data['title'] = $this->config_model->all['sitename'];

        //some view parameters
        $this->data['login_url'] = base_url();
        $this->data['logout_url'] = base_url("login/logout");

        $this->data['fullwidth'] = false;
        

	}
}