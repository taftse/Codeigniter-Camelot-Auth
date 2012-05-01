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

/**
 * Inspiration Taken from Phil Sturgeons codeigniter-oauth2 spark (https://github.com/philsturgeon/codeigniter-oauth2); 
 *	
 *
 * @subpackage camelot_auth
 */
class Oauth2_Provider_Google extends Oauth2_provider
{
	public function __Construct($driver)
	{
		$this->provider_name = 'Google';
		parent::__Construct($driver);
		$this->method = 'POST';
	}

	public function get_scope()
	{
		$scope = array();
		foreach ($this->CI->config->item('Google_Permissions') as $premission => $value) {
			if($value === TRUE){
				$premission = 'https://www.googleapis.com/auth/userinfo.'.$premission;
				array_push($scope,$premission);
			}
		}
		if(!empty($scope) && is_array($scope)){
			$scope = implode(' ', $scope);
		}
		
		return $scope;
	}

	public function get_user($access_token)
	{
		$api_url = $this->api_endpoint.'?alt=json&'.http_build_query(array('access_token' => $access_token));

		$userdata = json_decode(file_get_contents($api_url));

		//var_dump($userdata);
		//return FALSE;
		$user_data['user_ID'] = $userdata->id;
		$user_data['user_first_name'] = $userdata->given_name;
		$user_data['user_last_name'] = $userdata->family_name;
		$user_data['user_username'] = $userdata->name;
		$user_data['user_email'] = $userdata->email;
		$user_data['user_email_verified'] = $userdata->verified_email;
		/*$user_data[] = $userdata->;
		$user_data[] = $userdata->;
		$user_data[] = $userdata->;
		$user_data[] = $userdata->;*/
		return $user_data;
	}

}

