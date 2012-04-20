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

    }

    public function get($primary_value)
    {
        $this->_run_before_callbacks('get');
        
        $this->db->where($this->primary_key, $primary_value)
        $result = $this->db->get($this->_table);
        return $result->row();
    }

    public function get_where($key,$value = NULL){
    		$this->_set_where($key,$value);
    		$result = $this->get($this->_table);
    		return $result->row();
    }

    public function get_many_where($key,$value= NULL)
    {
    	$this->_set_where($key,$value);
    	$result = $this->get($this->_table);
    	return $result->result();
    }

    public function insert($data)
    {
    	$this->db->insert($this->_table, $data);
    	return $this->db->insert_id();
    }

    public function insert_many($data){
    	$ids = array();
    	foreach ($data as $row) {
    		$ids[] = $this->insert($row);
    	}
    	return $ids;
    }


/**
* add update functions
*
*
*
*
*
*/




    private function _set_where($key,$value = NULL){
    		if(is_array($key)){
    			$this->db->where($key);
    		}else if($value != NULL){
    			$this->db->where($key, $value);
    		}
    }

}