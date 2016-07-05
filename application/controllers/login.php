<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Main {

    public $errors = array();
	
    public function index(){
		$postdata = $this->input->post();
        
        if(isset($postdata) && !empty($postdata)){
            $user_username = $postdata['user_username'];
            $user_password = $this->input->post('user_password');
            
            if(empty($user_username) || empty($user_password)){
                $this->ci_message->set('You should fill all fields.', 'login', FALSE);
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
                    $this->ci_message->set('Invalid Username OR Password!', 'login', FALSE);
                }
            }
            
        }else{
            
        }
        
        if(!$this->login_model->loggedin){
            $client_id = $this->config_model->config->cfg_clientid;
            $client_secret = $this->config_model->config->cfg_clientsecret;
            
            $this->load->library("moves");
            $this->moves->load_construct($client_id,$client_secret,base_url("home/login_api"));
            $this->data['request_url'] = $this->moves->requestURL();
            
            $this->data['title'] = "Login" . " | " . $this->config_model->config->cfg_sitename;
            $this->load->view($this->foldername . '/login/form',$this->data);
        }else{
            
        }
        
	}
    
    function logout(){
        $this->login_model->logout();
        
        $this->data['msg'] = "LoggedOut Successfully.";
        $this->data['title'] = $this->data['msg'];
        $this->data['url'] = base_url("login");
        //$this->load->view($this->foldername . '/message',$this->data);
        
    }
}