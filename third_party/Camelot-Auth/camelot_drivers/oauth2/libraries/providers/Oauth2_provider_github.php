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
class Oauth2_Provider_Github extends Oauth2_provider
{
	public function __Construct()
	{
		$this->provider_name = 'Github';
		parent::__Construct();
	}

	public function get_scope()
	{
		/*$scope = array();
		foreach ($this->CI->config->item('Facebook_Permissions') as $premission => $value) {
			if($value == TRUE){
				array_push($scope,$premission);
			}
		}
		if(!empty($scope) && is_array($scope)){
			$scope = implode(',', $scope);
		}*/
		return 'user';//$scope;
		
	}

	public function get_user($access_token)
	{
		$api_url = $this->api_endpoint.'?'.http_build_query(array('access_token' => $access_token));

		$userdata = json_decode(file_get_contents($api_url));
		
		$user_data['user_ID'] = $userdata->id;
		$user_data['user_first_name'] = $userdata->name;
		$user_data['user_last_name'] = '';//$userdata->last_name;
		$user_data['user_username'] = $userdata->login;
		$user_data['user_email'] = $userdata->email;
		/*$user_data[] = $userdata->;
		$user_data[] = $userdata->;
		$user_data[] = $userdata->;
		$user_data[] = $userdata->;*/
		return $user_data;
	}

}