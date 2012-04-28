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
 *  @copyright       2011, Timothy Seebus
 *  @link            http://labs.Twsweb-int.com/network
 *  @filesource
 */
include 'Camelot_loader.php';
class Camelot_Driver{

	protected $CI;

	protected $load;

	public function __construct($driver_name){
		$this->CI =& get_instance();
		$this->load= new Camelot_loader($driver_name);
	}

	protected function _login($account_ID){
		//$this->CI->camelot_auth->log('login',array('Account_ID' => $account_ID ));
		$user_details = $this->CI->camelot_model->get_account_by_id($account_ID);
		return $this->create_session($user_details);
		
	}


	private function create_session($user_details)
	{
		print_r($user_details);
		
		//$this->CI->session->set_userdata($session_details);
		return false;
	}
}