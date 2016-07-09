<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model{
    public $all;
    public $one;
    public $table     = "messages";
    public $tablekey  = "msg_id";
    public $errors    = array();

    /**
     * get messages count based on search criteria, helps in pagination
     * @param array $wheredata 
     * @return int count
     */
    public function get_count( $wheredata=array() ){
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
            	if($field === "FREE"){
            		$this->db->where($value,null,false);
            	}else{
            		$this->db->where($field,$value);
            	}
            }
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * get all messages based on search criteria
     * @param array $wheredata 
     * @param int $limit 
     * @param int $start 
     * @param array $order 
     * @param string $dir 
     * @return boolean
     */
    function get_all($wheredata=array(),$limit=0,$start=0,$order=array(),$dir="DESC"){
        $this->all = NULL;
        
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
                if($field === "FREE"){
                    $this->db->where($value,null,false);
                }else{
                    $this->db->where($field,$value);
                }
            }
        }
        
        if(!empty($limit)){
            $this->db->limit($limit,$start);
        }

        if(!empty($order)){
            foreach($order as $key=>$value){
                $this->db->order_by($key,$value);
            }
        }else{
            $this->db->order_by($this->tablekey,$dir);
        }
        
        $query = $this->db->get($this->table);
        
        if($query->num_rows()){
            $this->all = $query->result();
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get chat list between two users
     * @param int $firstUserID 
     * @param int $secondUserID 
     * @return boolean (TRUE: if messages found. FALSE: no messages yet)
     */
    function getChat($firstUserID,$secondUserID){
    	if(!empty($firstUserID) && !empty($secondUserID)){
    		$where = array(
    			"FREE" => "(msg_from = ".$firstUserID." AND msg_to = ".$secondUserID.") OR (msg_to = ".$firstUserID." AND msg_from = ".$secondUserID.")"
    		);

    		$order = array(
    			"msg_created" => "ASC"
    		);

    		return $this->get_all($where,0,0,$order);
    	}else{
    		return false;
    	}
    }

    /**
     * Get One message details
     * @param int $id 
     * @param array $fields fields to be selected from messages table
     * @return boolean
     */
    function get_one($id,$fields=array()){
        $this->one = null;
        $wheredata = array($this->tablekey=>$id);

        if(!empty($fields)){
            $this->db->select(implode(",",$fields));
        }
        
        $status = $this->get_all($wheredata,1);
        if($status){
            $this->one = $this->all[0];
        }
        return $status;
    }

    /**
     * Save message info (Insert or Update) based on msg_id key
     * @param array $insertdata 
     * @return new message id
     */
    function savedata($insertdata=array()){
        //check if tablekey exists in $insertdata array keys if it's found update else insert new row
        if( array_key_exists($this->tablekey, $insertdata) && !empty( $insertdata[$this->tablekey] ) ){
            //update
            $id = $insertdata[$this->tablekey];
            unset($insertdata[$this->tablekey]);

            $this->db->where($this->tablekey,$id);
            $this->db->update($this->table,$insertdata);
            $return = $id;
        }else{
            //insert
            $this->db->insert($this->table,$insertdata);
            $return = $this->db->insert_id();
        }

        if($this->db->affected_rows()){
            return $return;
        }else{
            return false;
        }

    }

    /**
     * Delete Message
     * @param int $id 
     * @return boolean
     */
    function delete($id){
        if(!empty($id)){
            $this->db->where($this->tablekey,$id);
            $this->db->delete($this->table);
            
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }

    /**
     * Get count of new messages between two users
     * @param int $from 
     * @param int $to 
     * @return int
     */
    public function getNewMsgCount($from,$to){
    	if(!empty($from) && !empty($to)){
    		$where = array(
    			"FREE" => "(msg_from = ".$from." AND msg_to = ".$to.") AND (msg_readtime IS NULL)"
    		);
    		return $this->get_count($where);
    	}else{
    		return 0;
    	}
    }

    /**
     * Make all messages between two users read
     * @param type $from 
     * @param type $to 
     * @return type
     */
    public function readChat($from,$to){
    	if($this->getNewMsgCount($from,$to) > 0){
    		$this->db->where("(msg_from = ".$from." AND msg_to = ".$to.") AND (msg_readtime IS NULL) ",null,false);
    		$this->db->set("msg_readtime","NOW()",false);
    		$this->db->update($this->table);
    		return ($this->db->affected_rows() > 0);
    	}else{
    		return false;
    	}
    }

}