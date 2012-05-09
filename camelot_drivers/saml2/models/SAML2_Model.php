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

class SAML2_Model extends CI_Model {

	protected $table;
	protected $table_preflix = 'Auth_SAML2_';
	protected $primary_key;

	public function __construct()
	{
		parent::__construct();
	}

	public function get($primary_key)
	{
		
	}

	public function insert($insert_data)
	{
		$this->db->insert($this->table_preflix.$this->table,$insert_data);
		return $this->db->insert_id();
	}

	public function update($primary_key,$new_values)
	{
		$this->set_where($this->primary_key,$primary_key);
		$this->db->update($this->table_preflix.$this->table,$new_values);
	}
	protected function set_where($key,$value = NULL)
	{
		if($value != NULL)
		{
			$this->db->where($key,$value);
		}else{
			$this->db->where($key);
		}
	}
}
