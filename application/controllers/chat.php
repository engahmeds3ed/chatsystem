<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends User {
    
    public function index(){
    	$this->data['scripts'][] = "app.js";
    	$this->data['scripts'][] = "controller.chat.js";

        $this->data['fullwidth'] = true;
        $this->data['title'] = $this->config_model->all['sitename']." | Chat";
        $this->load->view($this->foldername .'/chat',$this->data);
    }

}