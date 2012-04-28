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
class Oauth2_Provider_Facebook extends Oauth2_provider
{
	public function __Construct($driver)
	{
		$this->provider_name = 'Facebook';
		parent::__Construct($driver);
	}

	public function get_scope()
	{
		$scope = array();
		foreach ($this->CI->config->item('Facebook_Permissions') as $premission => $value) {
			if($value == TRUE){
				array_push($scope,$premission);
			}
		}
		if(!empty($scope) && is_array($scope)){
			$scope = implode(',', $scope);
		}
		return $scope;
	}

	public function get_user($access_token)
	{
		$api_url = $this->api_endpoint.'?'.http_build_query(array('access_token' => $access_token));

		$userdata = json_decode(file_get_contents($api_url));

		return $this->create_user_session($userdata);
		//return $userdata;
	}

	
}