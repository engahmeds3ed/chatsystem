<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends User{
    
    public function index(){
        die("<h1>Not Found!</h1>");
    }

    public function getUsers(){
    	$output = array();

    	$this->load->model("user_model");
    	$this->load->model("chat_model");
    	$where = array(
    		"user_status"  => 1,
    		"FREE" => "user_id != '".$this->cur_userdata->user_id."'"
    	);
    	$found_users = $this->user_model->get_group_users(2,$where);
    	if( $found_users ){
    		$users = $this->user_model->all;
    		foreach($users as $user){
    			$output[] = array(
    				"user_id" => $user->user_id,
    				"user_fullname" => $user->user_fullname,
    				"status" => ($this->login_model->get_online_status($user->user_id)) ? "online" : "offline",
    				"newMsgCount" => $this->chat_model->getNewMsgCount($user->user_id,$this->cur_userdata->user_id)
    			);
    		}
    	}

    	die( json_encode($output) );

    }

    public function getMessages($user_id){
    	$output = array();

    	if(!empty($user_id)){
    		$this->load->model("chat_model");
    		
			//update read time
			$this->chat_model->readChat($user_id,$this->cur_userdata->user_id);
    		
    		if( $this->chat_model->getChat($this->cur_userdata->user_id,$user_id) ){
    			foreach ($this->chat_model->all as $msg) {
    				$output[] = array(
    					"from" => $msg->msg_from,
    					"to" => $msg->msg_to,
    					"msg_id" => $msg->msg_id,
    					"msg" => $msg->msg_content,
    					"msg_date" => $msg->msg_created
    				);
    			}
    		}else{

    		}
    	}

    	die( json_encode($output) );
    }

    public function saveMsg(){
    	$output = array();
    	//small hack to apply input sanitization
    	$_POST = json_decode(file_get_contents('php://input'),true);
    	$postdata = $this->input->post();

    	if( !empty($postdata['toUserid']) && !empty($postdata['msgContent']) ){
    		$this->load->model("chat_model");
    		$insert = array(
    			"msg_from"    => $this->cur_userdata->user_id,
    			"msg_to"      => $postdata['toUserid'],
    			"msg_content" => $postdata['msgContent']
    		);
    		if( $this->chat_model->savedata($insert) ){
    			$output = array(
	    			"status" => "success",
	    			"msg" => "Added Successfully"
	    		);
    		}else{
    			$output = array(
	    			"status" => "error",
	    			"msg" => "Problem while saving into DB!"
	    		);
    		}
    	}else{
    		$output = array(
    			"status" => "error",
    			"msg" => "Not valid Inputs!"
    		);
    	}

    	die( json_encode($output) );
    }

}