<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *  Twsweb Network
 * 
 *  The codebase for the Twsweb Network sites
 * 
 *  @package         Twsweb Network
 *  @author          Timothy Seebus <Timothyseebus@twsweb-int.com>
 *  @copyright       2012, Timothy Seebus
 *  @link            http://labs.Twsweb-int.com/network
 *  @filesource
 */

class Camelot_model extends CI_Model{
		 /**
	* The database table to use, only
	* set if you want to bypass the magic
	*
	* @var string
	*/

    protected $_table;
        
    /**
	* The primary key, by default set to
	* `id`, for use in some functions.
	*
	* @var string
	*/
    protected $primary_key = 'id';

    /**
	* The class constructer, tries to guess
	* the table name.
	*/
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'Auth_Account';

    }


     /**
     * Fetch a single record based on the primary key. Returns an object.
     */
    public function get($primary_value)
    {
        

        $this->db->where($this->primary_key, $primary_value);
        $query = $this->db->get($this->_table);
       return $query->row();
    }

    public function get_account_by_ID($account_ID){
        
        $this->_set_where('Account_ID',$account_ID);
        $query = $this->db->get($this->_table);
        if($query->num_rows() ==1){
            return $query->row();
        }
        return FALSE;
    }

    public function register_account($user_data)
    {
        $account_data['Account_First_Name'] = $user_data['user_first_name'];
        $account_data['Account_Last_Name'] = $user_data['user_last_name'];
        $account_data['Account_Email'] = $user_data['user_email'];
        $this->db->insert('auth_account',$account_data);
        return $this->db->insert_id();
    }

    protected function _set_where($key,$value = NULL){
    		if(is_array($key)){
    			$this->db->where($key);
    		}else if($value != NULL){
    			$this->db->where($key, $value);
    		}
    }
}