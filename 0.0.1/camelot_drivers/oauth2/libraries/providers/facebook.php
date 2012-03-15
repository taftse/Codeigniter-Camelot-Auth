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
		//return ''# code...
	}

	public function get_user($access_token)
	{
		
	}
}