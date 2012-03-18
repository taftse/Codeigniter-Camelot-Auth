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

/*
 * Inspiration Taken from Phil Sturgeons codeigniter-oauth2 spark (https://github.com/philsturgeon/codeigniter-oauth2); 
 *	
 *
 * @subpackage camelot_auth
 */
abstract class Oauth2_provider{

	protected $provider_name = '';
	
	private $client_ID;

    private $client_Secret;

	/**
	 * @var  string  scope separator, most use "," but some like Google are spaces
	 */

	public $scope_seperator  = ',';

	/**
	 * @var  array  additional request parameters to be used for remote requests
	 */
	protected $params = array();

	/**
	 * @var  string  the method to use when requesting tokens
	 */
	protected $method = 'GET';

	public $callback_url = NULL;

	protected $api_endpoint = NULL;

	protected $CI;
 
	public function __Construct($camelot_driver)
	{
		$this->driver = $camelot_driver;
		$this->CI = get_instance();
		$this->driver->load->config($this->provider_name);

		$this->client_ID = $this->CI->config->item('Oauth_Client_ID');
		$this->client_Secret = $this->CI->config->item('Oauth_Client_Secret');
		$this->callback_url = site_url(get_instance()->uri->uri_string());
		if($this->CI->config->item('Oauth_Callback_URL_Override') != ""){
			$this->callback_url = $this->CI->config->item('Oauth_Callback_URL_Override');
		}
		$this->authorize_URL = $this->CI->config->item('Oauth_Authorize_URL');
		$this->access_Token_URL = $this->CI->config->item('Oauth_Access_Token_URL');
		$this->api_endpoint = $this->CI->config->item('Oauth_Endpoint');
	}

	

	public function authorize($options = array())
	{
		$params['client_id'] = $this->client_ID;
		$params['redirect_uri'] = $this->callback_url.'/callback';
		if ($this->CI->config->item('csrf_protection') == TRUE)
		{
			$params['state'] = $this->CI->security->get_csrf_hash();
		}
		$params['scope'] =  $this->get_scope();		
		$params['response_type'] = 'code';
		if($this->CI->config->item('force_approval') == TRUE){
			$params['approval_prompt']= 'force';
		}	
		
		redirect($this->authorize_URL . '?' . http_build_query($params));
	}

	public function callback(){
		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get);

		if ($this->CI->config->item('csrf_protection') == TRUE)
		{
			$_POST[$this->CI->security->get_csrf_token_name()] = $get['state'];
			$this->CI->security->csrf_verify();
		}
		
		if (isset($get['code'])) {
			return $this->authenticate($get['code']);
		}
	}

	public function authenticate($code){
		$token_url['client_id'] = $this->client_ID;
		$token_url['client_secret'] = $this->client_Secret;
		$token_url['grant_type'] = 'authorization_code';
		if($this->CI->config->item('Oauth_Grant_Type') != ""){
			$token_url['grant_type'] = $this->CI->config->item('Oauth_Grant_Type');
		}
		switch ($token_url['grant_type'])
		{
			case 'authorization_code':
				$token_url['code'] = $code;
				$token_url['redirect_uri'] = $this->callback_url;
			break;

			case 'refresh_token':
				$token_url['refresh_token'] = $code;
			break;
		}

		$response = null;
		$url = $this->access_Token_URL;

		switch ($this->method)
		{
			case 'GET':

				// Need to switch to Request library, but need to test it on one that works
				
				$url .= '?'.http_build_query($token_url);
				$response = file_get_contents($url);
				parse_str($response, $return); 

			break;

			case 'POST':

				$postdata = http_build_query($token_url);
				$opts = array(
					'http' => array(
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata
					)
				);

				$_default_opts = stream_context_get_params(stream_context_get_default());
				$context = stream_context_create(array_merge_recursive($_default_opts['options'], $opts));
				$response = file_get_contents($url, false, $context);
				$return = json_decode($response, true);
				
			break;

		}	

		if(isset($return['error'])){
			//return $this->
			throw new Exception("Error Processing Request", 1);
			
		}
		return $return;
	}

	abstract function get_scope();

	abstract function get_user($access_token);

	

}