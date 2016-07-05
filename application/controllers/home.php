<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Main {
	
	public function index(){
        $this->data['title'] = $this->config_model->config->cfg_sitename;
        $this->load->view($this->foldername .'/home',$this->data);
	}
	
}