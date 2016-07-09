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
        $this->data['url'] = base_url("");
        $this->load->view($this->foldername . '/message',$this->data);
        
    }
}