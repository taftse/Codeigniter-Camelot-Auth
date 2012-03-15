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

/**
 * Provides functionality to get/insert/update/delete
 * user rows from the database.
 *
 * @subpackage camelot_auth
 */
class Camelot_driver_oauth2 extends Camelot_Driver {

	private $provider_name;

	private $provider = null;
/*	private $client_ID;
    private $client_Secret;
    private $callback_URL_Override;
    private $authorize_URL;
    private $access_Token_URL;
    private $CSRF_Supported;
    private $authentication_protocol;*/

	public function __construct($camelot)
	{
		parent::__construct($camelot);
		/*$this->provider_name = $this->camelot->provider_name;

		$this->load->config($this->provider_name);

		$this->client_ID = $this->CI->config->item('Oauth_Client_ID');
		$this->client_Secret = $this->CI->config->item('Oauth_Client_Secret');
		$this->callback_URL_Override = $this->CI->config->item('Oauth_Callback_URL_Override');
		$this->authorize_URL = $this->CI->config->item('Oauth_Authorize_URL');
		$this->access_Token_URL = $this->CI->config->item('Oauth_Access_Token_URL');
		$this->CSRF_Supported = $this->CI->config->item('Oauth_CSRF_Supported');
		$this->authentication_protocol =  $this->CI->config->item('Oauth_Authentication_Protocol');*/
		
	}

	public function load_provider($provider_name)
	{
		$provider_file = dirname(__FILE__) . '/libraries/providers/'.strtolower($provider_name).'.php';
		$provider_class = 'Oauth2_Provider_'.$provider_name;
		
		if(!file_exists($provider_file)){

			return $this->camelot->return_response('error', 'oauth2_provider_file_missing', 'driver_response', array('Provider_Name' => $provider_name,'Provider_File'=>$provider_file));
		}

		include_once $provider_file;
		if(!class_exists($provider_class))
		{
				return $this->camelot->return_response('error', 'no_valid_provider_class', 'driver_response', array('Provider_Name' => $provider_name,'Provider_File'=>$provider_file,'Provider_Class'=>$provider_class));
		}
		$this->provider = new $provider_class($this);
		return TRUE;
		
	}

	public function login()
	{

		$provider_loaded = $this->load_provider($this->camelot->provider_name);
		if($provider_loaded !== TRUE){
			return $provider_loaded;
		}
		
		if ($this->CI->uri->rsegment(4) != 'callback'){
			$this->provider->authorize();
		}else{
			$callback = $this->provider->callback();

		}
	}

}

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
		if($this->CI->config->item('force_approval') == TRUE){
			$params['approval_prompt']= 'force';
		}	
	}
}