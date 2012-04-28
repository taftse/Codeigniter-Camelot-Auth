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

class Camelot_driver_oauth2 extends Camelot_Driver {

	protected $provider_name;
	protected $provider;


	public function __construct($provider_name){
		parent::__construct('oauth2');
		$this->load->model('oauth2_model');
		$this->load->config(ucfirst($provider_name));
		$this->provider_name = $provider_name;
	}

	public function load_provider($provider_name){
		$provider_file = dirname(__FILE__) . '/providers/Oauth2_provider_'.strtolower($provider_name).'.php';
		$provider_class = 'Oauth2_Provider_'.$provider_name;
		// if the file does not exist 
		if(!file_exists($provider_file)){
			return $this->throw_oauth2_exception('oauth2_provider_file_missing', 'driver_response', array('Provider_Name' => $provider_name,'Provider_File'=>$provider_file));
		}
		include_once('Oauth2_provider.php');
		include_once($provider_file);
		if(!class_exists($provider_class)){
			return $this->throw_oauth2_exception('oauth2_provider_class_missing', 'driver_response', array('Provider_Name' => $provider_name,'Provider_File'=>$provider_file,'Provider_Class'=>$provider_class));
		}
		$this->provider = new $provider_class($this);
		return TRUE;
	}

	public function login()
	{
		$provider_loaded =$this->load_provider($this->provider_name);
		if($provider_loaded == FALSE){
			return $provider_loaded;
		}
		if($this->CI->uri->rsegment(4) != 'callback'){
			$this->provider->authorize();
		}else{
			$callback = $this->provider->callback();
			$user_data = $this->provider->get_user($callback['access_token']);
			return $this->user_exist($this->provider->provider_name,$user_data,$callback['access_token']);
		}
	}

	protected function user_exist($provider_name,$user_data,$auth_token){

		if($user_data != FALSE){
			$oauth2_account = $this->CI->oauth2_model->user_account_exist($provider_name,$user_data['user_ID']);
			// user is found 
			if($oauth2_account !== FALSE){
				return $this->_login($oauth2_account->OAuth_User_Account_ID);
			}else{
				$account_ID = $this->CI->oauth2_model->register_account($user_data);
				return $this->CI->oauth2_model->create_oauth2_user($account_ID,$provider_name,$user_data['user_ID'],$auth_token);
			}
		}
	}

}