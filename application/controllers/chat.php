<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends User {
    
    public function index(){
        $this->data['title'] = $this->config_model->all['sitename']." | Chat";
        $this->load->view($this->foldername .'/chat',$this->data);
    }

}