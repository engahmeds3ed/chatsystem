<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Main {
	
	function index(){
		$postdata = $this->input->post();
        
        if(isset($postdata) && !empty($postdata)){
        	$this->load->model("user_model");
        	$this->load->helper('email');

        	$errors = array();
        	//validate user full name
        	if(empty($postdata['user_fullname']) || !isset($postdata['user_fullname'])){
        		$errors[] = "Please Fill your full name!";
        	}

        	//validate user email
        	if(empty($postdata['user_email'])){
        		$errors[] = "Please Fill your email!";
        	}else{
        		//check if valid email
        		 if ( !valid_email( $postdata['user_email'] )){
        		 	$errors[] = "Not Valid email!";
        		 }
        	}

        	//if username is empty, put user email as username
        	if(empty($postdata['user_username']) || !isset($postdata['user_username'])){
        		$postdata['user_username'] = $postdata['user_email'];
        	}

        	//validate user password
        	if(empty($postdata['user_password']) || !isset($postdata['user_password'])){
        		$errors[] = "Please Fill password!";
        	}

        	$check_fields = array(
                "user_username" => $postdata['user_username'],
                "user_email"    => $postdata['user_email']
            );
            if( $this->user_model->checkUserfound( $check_fields ) ){
            	$errors[] = "You are already a member try login!";
            }

        	if(empty($errors)){
				
				//get user data from posted info
	        	$userdata = array(
	        		"user_fullname" => $postdata['user_fullname'],
	        		"user_email"    => $postdata['user_email'],
	        		"user_username" => $postdata['user_username'],
	        		"user_password" => md5($postdata['user_password']),
	        		"user_groupid"  => 2, //users group id
	        		"user_status"   => 1
	        	);

	        	//use user model to register new user
	        	if( $this->user_model->savedata($userdata) ){
	        		//user saved successfully
	        		//login this user and redirect him to chat page
	        		$logindata = array(
                                "user_username" => $postdata['user_username'],
                                "user_password" => md5($postdata['user_password'])
                    );
	        		$logging = $this->login_model->login($logindata);
	        		if( $logging ){
	        			//logged in successfully
	        			$this->data['msg'] = "Registered Successfully.<br />You will be redirected to chat page!";
        				$this->data['url'] = base_url("chat");
	        		}else{
	        			//problem in logging in
	        			$this->data['msg'] = "Registered Successfully.<br />You will be redirected to login page!";
        				$this->data['url'] = $this->data['login_url'];
	        		}
	        	}else{
	        		//problem in saving new user
	        		$this->data['msg'] = "You are already a member try login!";
        			$this->data['url'] = $this->data['login_url'];
	        	}

        	}else{
        		//some validation errors found!
        		$this->data['msg'] = implode("<br />",$errors);
        		$this->data['url'] = $this->data['login_url'];
        	}
        	
        	$this->load->view($this->foldername . '/message',$this->data);

        }

	}

}