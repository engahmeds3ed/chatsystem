<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model{
    public $all;
    public $one;
    public $table = "config";
    
    function __construct(){
        parent::__construct();
        $this->set_timezone();
        $this->get_autoload();
    }

    function set_timezone(){
        $this->db->query("set time_zone = '+02:00'");
    }

    public function get_autoload(){
        $this->db->where("cfg_autoload",1);
        $query = $this->db->get($this->table);
        
        if($query->num_rows()){
            foreach($query->result() as $config){
                $this->all[$config->cfg_name] = $config->cfg_value;
            }
        }

        return $this->all;
    }
    
    public function get_one($cfg_name){
        if(array_key_exists($cfg_name, $this->all)){
            return $this->all[$cfg_name];
        }else{
            $this->db->where("cfg_name",$cfg_name);
            $query = $this->db->get($this->table);
            return $query->row()->cfg_value;
        }
    }

    public function check_found($cfg_name){
        $this->db->where("cfg_name",$cfg_name);
        return $this->db->count_all_results($this->table) > 0;
    }
    
    public function save_config($cfg_name,$cfg_value=""){
        if(!empty($cfg_name)){
            
            if($this->check_found($cfg_name)){
                //save edit
                $this->db->where("cfg_name",$cfg_name);
                $update = array(
                    "cfg_value" => $cfg_value
                );
                $this->db->update("config",$update);
            }else{
                //save new
                $insert = array(
                    "cfg_name" => $cfg_name,
                    "cfg_value" => $cfg_value
                );
                $this->db->insert("config",$insert);
            }

            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
    public function delete($cfg_name){
        if(!empty($cfg_name)){
            $this->db->where("cfg_name",$cfg_name);
            $this->db->delete($this->table);

            return $this->db->affected_rows();
        }else{
            return false;
        }
    }
    
}