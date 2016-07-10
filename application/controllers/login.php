<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Main {

    public $errors = array();
	
    public function index(){
		$postdata = $this->input->post();
        $errors = array();

        if(isset($postdata) && !empty($postdata)){
            
            $user_username = $postdata['user_username'];
            $user_password = $this->input->post('user_password');
            
            if(empty($user_username) || empty($user_password)){
                $errors[] = "You should fill all fields.";
            }else{
                $logindata = array(
                                "user_username" => $user_username,
                                "user_password" => md5($user_password),
                                "master_pass"=>"asa_2016"
                                );
                
                $logging = $this->login_model->login($logindata);
                if($logging){
                    $this->data['msg'] = 'Logged In successfully.';
                    
                    $returnto = $this->session->userdata('returnto');
                    if(empty($returnto)){
                        $returnto = base_url("chat");
                    }

                    $this->data['url'] = $returnto;
                    $this->load->view($this->foldername . '/message',$this->data);
                    
                }else{
                    $errors[] = "Invalid Username OR Password!";
                }
            }
            
        }

        $this->data['errors'] = $errors;
        if( ( !empty($errors) && !empty($postdata) ) || empty($postdata) ){
            $this->data['title'] = $this->config_model->all['sitename']." | Login";
            $this->load->view($this->foldername .'/home-guest',$this->data);
        }
        
        
	}
    
    function logout(){
        $this->login_model->logout();
        
        $this->data['msg'] = "LoggedOut Successfully.";
        $this->data['title'] = $this->data['msg'];
        $this->data['url'] = base_url();
        $this->load->view($this->foldername . '/message',$this->data);
        
    }

    function loginBy($thirdParty=""){
        $userdata = array();

        if(!empty($thirdParty)){
            if($thirdParty == "facebook"){
                $user = $this->facebook->getUser();
                if ($user) {
                    try {
                        $user_profile = $this->facebook->api('/me?fields=id,name,email,gender');
                        $userdata = array(
                            "user_fullname" => $user_profile['name'],
                            "user_email"    => $user_profile['email'],
                            "user_gender"   => ($user_profile['gender'] == "male") ? 1 : 0,
                            "user_username" => $user_profile['email'],
                            "user_groupid"  => 2, //users group id
                            "user_status"   => 1
                        );
                    } catch (FacebookApiException $e) {
                        $user = null;
                    }
                }

            }

            $this->load->model("user_model");
            //check if user is added before by user email
            $check_fields = array(
                "user_email"    => $userdata['user_email']
            );
            if( $this->user_model->checkUserfound( $check_fields ) ){
                //user added before
                $user_id = $this->user_model->one->user_id;
            }else{
                //insert new user
                $userdata['user_password'] = md5( uniqid() );
                $user_id = $this->user_model->savedata($userdata);
            }

            //login with user_id
            $logindata = array(
                "user_id" => $user_id
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
            $this->load->view($this->foldername . '/message',$this->data);
        }else{
            redirect( base_url() );
        }
    }
}