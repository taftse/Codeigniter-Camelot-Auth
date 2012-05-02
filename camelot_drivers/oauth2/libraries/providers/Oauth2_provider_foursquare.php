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
class Oauth2_Provider_Foursquare extends Oauth2_provider
{
	public function __Construct()
	{
		$this->provider_name = 'Foursquare';
		parent::__Construct();
		$this->method ='POST';
	}

	public function get_scope()
	{
		return '';
	}

	public function get_user($access_token)
	{
		$api_url = $this->api_endpoint.'?'.http_build_query(array('oauth_token' => $access_token,
			'v'=>'20120426'));
		 
		$userdata = json_decode(file_get_contents($api_url));

		$user_data['user_ID'] = $userdata->response->user->id;
		$user_data['user_first_name'] = $userdata->response->user->firstName;
		$user_data['user_last_name'] = $userdata->response->user->lastName;
		$user_data['user_username'] = '';
		$user_data['user_email'] = $userdata->response->user->contact->email;
		return $user_data;
	}
}