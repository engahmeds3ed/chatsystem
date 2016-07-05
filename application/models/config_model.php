<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model{
    
    public $config;
    
    function set_timezone(){
        $this->db->query("set time_zone = '+02:00'");
    }
    
    public function get_config(){
        $this->db->where("cfg_id",1);
        $query = $this->db->get("config");
        if($query->num_rows()){
            $this->config = $query->row();
        }
    }
    
    public function save_config($configdata){
        if(!empty($configdata)){
            $this->db->where("cfg_id",1);
            $this->db->update("config",$configdata);
            
            if($this->db->affected_rows()){
                $this->get_config();
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
}