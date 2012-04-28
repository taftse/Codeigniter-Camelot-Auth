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

class Oauth2_model extends Camelot_model {

	public function __construct()
	{
		parent::__construct();

		$this->_table = 'Auth_OAuth_Users';
		$this->primary_key = 'OAuth_User_ID';
	}

	public function user_account_exist($provider,$user_ID){
		$this->_set_where('OAuth_User_Provider',$provider);
		$this->_set_where('OAuth_User_Auth_ID',$user_ID);
		$result = $this->db->get($this->_table);

		if($result->num_rows() == 1){
			return $result->row();
		}else{
			return FALSE;
		}
	}
}
