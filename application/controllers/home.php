<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Main {
    
    public function index(){
        
        $this->data['title'] = $this->config_model->all['sitename']." | Home";
        
        if( $this->login_model->loggedin ){
            $this->load->view($this->foldername .'/home-user',$this->data);
        }else{
        	$this->data['fb_login'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => base_url('login/loginBy/facebook'), 
                'scope' => array("email","public_profile") // permissions here
            ));
            $this->load->view($this->foldername .'/home-guest',$this->data);
        }
    }

}