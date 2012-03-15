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
abstract class OAuth_Provider{

	protected $provider_name = '';
	
	private $client_ID;

    private $client_Secret;

	/**
	 * @var  string  scope separator, most use "," but some like Google are spaces
	 */

	public $scope_seperator  = ',';

	/**
	 * @var  string  additional request parameters to be used for remote requests
	 */
	public $callback = null;

	/**
	 * @var  array  additional request parameters to be used for remote requests
	 */
	protected $params = array();

	/**
	 * @var  string  the method to use when requesting tokens
	 */
	protected $method = 'GET';

	public function __Construct($camelot_driver)
	{
		$this->driver = $camelot_driver;
		
		$this->driver->load->config($this->provider_name);

		$this->client_ID = $this->CI->config->item('Oauth_Client_ID');
		$this->client_Secret = $this->CI->config->item('Oauth_Client_Secret');
		$this->callback_url = site_url(get_instance()->uri->uri_string().'/callback');
		if($this->CI->config->item('Oauth_Callback_URL_Override') != ""){
			$this->callback_url = $this->CI->config->item('Oauth_Callback_URL_Override');
		}
		$this->authorize_URL = $this->CI->config->item('Oauth_Authorize_URL');
		$this->access_Token_URL = $this->CI->config->item('Oauth_Access_Token_URL');
		
	}

	

	public function authorize($options = array())
	{
		$params['client_id'] = $this->client_ID;
		$params['redirect_uri'] = $this->callback_url;
		if ($this->CI->config->item('csrf_protection') == TRUE)
		{
			$params['state'] = $this->CI->security->get_csrf_hash();
		}
		$params['scope'] = $this->get_scope();
		$params['response_type'] = 'code';
		if($this->config)	'approval_prompt' => 'force' 
	}
}