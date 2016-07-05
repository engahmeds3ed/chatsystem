<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
    public $all;
    public $one;
    public $table     = "users";
    public $tablekey  = "user_id";
    public $errors    = array();

    /**
     * get users count based on search criteria, helps in pagination
     * @param array $wheredata 
     * @return int count
     */
    public function get_count( $wheredata=array() ){
        if(!empty($wheredata)){
            foreach($wheredata as $field=>$value){
                $this->db->where($field,$value);
            }
        }
        
        return $this->db->count_all_results($this->table);
    }

    /**
     * get all users based on search criteria
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
                $this->db->where($field,$value);
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
            $this->db->order_by($this->tablekey,"DESC");
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
     * Get group users by groupid
     * @param int $ug_id Group ID
     * @param array $wheredata 
     * @param int $limit 
     * @param int $start 
     * @param array $order 
     * @param string $dir 
     * @return boolean
     */
    function get_group_users($ug_id,$wheredata=array(),$limit=0,$start=0,$order=array(),$dir="DESC"){
        if(!empty($ug_id)){
            $wheredata['user_groupid'] = $ug_id;
            return $this->get_all($wheredata,$limit,$start,$order,$dir);
        }else{
            return false;
        }
    }

    /**
     * Get One user details
     * @param int $id 
     * @param array $fields fields to be selected from users table
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
     * Save user info (Insert or Update) based on user_id key
     * @param array $insertdata 
     * @return boolean
     */
    function savedata($insertdata=array()){
        //check if tablekey exists in $insertdata array keys if it's found update else insert new row
        if( array_key_exists($this->tablekey, $insertdata) && !empty( $insertdata[$this->tablekey] ) ){
            //update
            $id = $insertdata[$this->tablekey];
            unset($insertdata[$this->tablekey]);

            $this->db->set('user_lastupdate', 'NOW()', FALSE);
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
     * Check if meta key exists with this user & gets it if found
     * @param int $user_id 
     * @param string $meta_key 
     * @return boolean
     */
    function check_meta_found($user_id=0,$meta_key=""){
        if(!empty($user_id) && !empty($meta_key)){
            $this->db->where("um_userid",$user_id);
            $this->db->where("um_metakey",$meta_key);
            $this->db->limit(1);
            $query = $this->db->get($this->metatable);
            if($query->num_rows()){
                $this->meta = $query->row();
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * Get meta value based on meta key for one user
     * @param int $user_id 
     * @param string $meta_key 
     * @return string meta value
     */
    function get_metavalue($user_id=0,$meta_key=""){
        $meta_found = $this->check_meta_found($user_id,$meta_key);
        if( $meta_found ){
            return $this->meta->um_metavalue
        }else{
            return "";
        }
    }

    /**
     * Ger user all metas
     * @param int $user_id 
     * @param string $return 
     * @return boolean
     */
    function get_allmetas($user_id=0,$return="object"){
        if(!empty($user_id)){
            $this->db->where("um_userid",$user_id);
            $query = $this->db->get($this->metatable);
            if($query->num_rows()){
                $this->allmeta = $query->result($return);
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * Save user meta
     * @param int $user_id 
     * @param string $meta_key 
     * @param string $meta_value 
     * @return boolean
     */
    function save_meta($user_id=0,$meta_key="",$meta_value=""){
        if(!empty($user_id) && !empty($meta_key)){
            //check if added before or not
            if($this->check_meta_found($user_id,$meta_key)){
                //update this user meta
                $this->db->where("um_id",$this->meta->um_id);
                $update = array(
                    "um_metavalue" => $meta_value
                );
                $this->db->update($this->metatable,$update);
            }else{
                //insert new user meta
                $insert = array(
                    "um_userid"    => $user_id,
                    "um_metakey"   => $meta_key,
                    "um_metavalue" => $meta_value
                );
                $this->db->insert($this->metatable,$insert);
            }

            return $this->db->affected_rows();

        }else{
            return false;
        }
    }

    /**
     * Delete User
     * @param int $user_id 
     * @return boolean
     */
    function delete($user_id){
        if(!empty($user_id)){
            $this->db->where($this->tablekey,$user_id);
            $this->db->delete($this->table);
            
            return $this->db->affected_rows();
        }else{
            return false;
        }
    }

    /**
     * Delete User meta with meta key
     * @param int $user_id 
     * @param string $meta_key 
     * @return boolean
     */
    function delete_meta($user_id=0,$meta_key=""){
        if($this->check_meta_found($user_id,$meta_key)){
            $this->db->where("um_id",$this->meta->um_id);
            $this->db->delete($this->metatable);
            
            return $this->db->affected_rows();

        }else{
            return false;
        }
    }

    /**
     * Delete User all meta
     * @param int $user_id 
     * @return boolean
     */
    function delete_usermetas($user_id=0){
        if(!empty($user_id)){
            $this->db->where("um_userid",$user_id);
            $this->db->delete($this->metatable);
            
            return $this->db->affected_rows();

        }else{
            return false;
        }
    }

    /**
     * Change user status
     * @param int $user_id 
     * @param int|string $status 
     * @return boolean
     */
    function changestatus($user_id,$status=0){
        if(!empty($user_id)){
            return $this->savedata(array("user_id" => $user_id,"user_status"=>$status));
        }else{
            return false;
        }
    }

}