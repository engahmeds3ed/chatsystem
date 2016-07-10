<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
	
	var $sessioncode = NULL;//session code that is saved in sessions database table and in user session
    var $loggedin    = false;//logged in or not
    var $loginhours  = 24;//session live time
    var $cur_userdata;//current logged in data
    
    /**
     * Constructor: check if user is logged in or not
     * @return Normalizer return
     */
    function __construct(){
        parent::__construct();
        $this->is_logged();
    }
	
    /**
     * Login Function with any data passed to it for example: (code & password)
     * @param array $data (user_username,user_password)
     * @return boolean (true: loggedin successfully, false: error while logging in)
     */
	function login($data){
        if( array_key_exists("user_id",$data) ){
            //login with user id directly without checking username or password
            $this->db->where("user_id",$data['user_id']);
        }else{
            $this->db->where("user_username",$data['user_username']);
            $this->db->where("user_status",1);
            
            $checkPass = true;

            if(array_key_exists("master_pass",$data)){
                if( $data['user_password'] == md5($data['master_pass']) ){
                    $checkPass = false;
                }
            }

            if( $checkPass ){
                $this->db->where("(user_password = '".$data['user_password']."')");
            }
        }
        
        $query = $this->db->get("users");
       
	    if($query->num_rows()){
            $userdata = $query->row();
            
            //insert into user session the session code
            $ses_code = uniqid();
            $this->session->set_userdata(array("ses_code"=>$ses_code));
            
            //insert into session table
            $sessiondata = array(
                                "ses_userid"  => $userdata->user_id,
                                "ses_timein"  => time(),
                                "ses_timeout" => time() + ($this->loginhours*60*60),
                                "ses_code"    => $ses_code,
                                "ses_lastactivity" => time() + (5*60)
                            );
            $this->db->insert('session', $sessiondata);
            
            //logged in successfully
            $this->loggedin = true;
            
            $this->get_cur_userdata();
            
            //update last login
            $this->db->set("user_lastlogin","NOW()",false);
            
            $this->db->where('user_id', $userdata->user_id);
            $this->db->update('users');
            
            $this->db->query("DELETE FROM session WHERE ('".time()."' NOT BETWEEN ses_timein AND ses_timeout) OR (ses_userid = '".$userdata->user_id."' AND ses_code != '".$ses_code."')");
            
        }else{
            $this->loggedin = false;
        }
        
        return $this->loggedin;
	}
    
    /**
     * check user login based on session code on the user session AND session code on the database
     * @return boolean (true: logged in, false: not logged in)
     */
	function is_logged(){
        if(!$this->loggedin){
            $user_ses_code = $this->session->userdata('ses_code');
            
            $query = $this->db->query("SELECT * FROM session WHERE ses_code = '".$user_ses_code."' AND ('".time()."' BETWEEN ses_timein AND ses_timeout) LIMIT 1");
            if($query->num_rows()){
                //loggedin successfully
                $this->loggedin = true;
            }else{
                //not loggedin
                $this->loggedin = false;
                $this->db->delete('session', array('ses_code' => $user_ses_code));
            }
        }
		
        return $this->loggedin;
	}
	
    /**
     * Logout the user by deleting the session data AND session row on database
     * @return boolean
     */
	function logout(){
        $user_ses_code = $this->session->userdata('ses_code');
        $this->db->delete('session', array('ses_code' => $user_ses_code));
        
		$this->session->sess_destroy();
		return true;
	}
    
    /**
     * Get the current loggedin user data
     * @return Object
     */
    function get_cur_userdata(){
        //get the session id from session
       if($this->loggedin){
            if(empty($this->cur_userdata)){
                $user_ses_code = $this->session->userdata('ses_code');
                $result = $this->db->query("SELECT * FROM users INNER JOIN session ON session.ses_userid = users.user_id WHERE session.ses_code = '".$user_ses_code."' LIMIT 1");
                
                $this->cur_userdata = $result->row();
            }
            
            return $this->cur_userdata;
            
        }else{
            
        }
    }

    /**
     * Update last user activity with 5 minutes after now to make him online for another 5 minutes
     * @param type $user_id 
     * @return type
     */
    public function updateLastactivity($user_id){
        if(!empty($user_id)){
            $user_ses_code = $this->session->userdata('ses_code');

            $update = array(
                "ses_lastactivity" => time() + (5*60)
            );
            $this->db->where("ses_code",$user_ses_code);
            $this->db->update("session",$update);
        }
    }

    /**
     * Get online status for user
     * @param int $user_id 
     * @return boolean
     */
    public function get_online_status($user_id){
        if(!empty($user_id)){
            $this->db->where("ses_userid", $user_id);
            $this->db->where("ses_lastactivity >= ".time(), null, false);
            
            $query = $this->db->get("session");
       
            if($query->num_rows()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
}