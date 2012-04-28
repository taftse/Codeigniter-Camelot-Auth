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
	// the name of the identity provider 
	public $provider_name;

	// the client id provided by the provider
	private $client_ID;
	// the client secret provided by the provider 
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

	// this sites callback url 
	public $callback_url = NULL;

	// the providers api endpoint 
	protected $api_endpoint = NULL;

	// codeigniter instance 
	protected $CI;
 	
 	public function __construct()
 	{
 		$this->CI =& get_instance();
 		$this->client_ID = $this->CI->config->item('Oauth2_Client_ID');
		$this->client_Secret = $this->CI->config->item('Oauth2_Client_Secret');
		$this->callback_url = site_url(get_instance()->uri->uri_string());
		if($this->CI->config->item('Oauth2_Callback_URL_Override') != ""){
			$this->callback_url = $this->CI->config->item('Oauth2_Callback_URL_Override');
		}
		$this->authorize_URL = $this->CI->config->item('Oauth2_Authorize_URL');
		$this->access_Token_URL = $this->CI->config->item('Oauth2_Access_Token_URL');
		$this->api_endpoint = $this->CI->config->item('Oauth2_Endpoint');
 	}
 	public function authorize($options = array())
	{
		$params['client_id'] = $this->client_ID;
		$params['redirect_uri'] = $this->callback_url.'/callback';
		if ($this->CI->config->item('Oauth2_CSRF_Supported') == TRUE)
		{
			$params['state'] = $this->CI->security->get_csrf_hash();
		}
		$params['scope'] =  $this->get_scope();	

		$params['response_type'] = 'code';
		if($this->CI->config->item('Oauth2_Force_Approval') == TRUE){
			$params['approval_prompt']= 'force';
		}	
		
		redirect($this->authorize_URL . '?' . http_build_query($params));
	}

	public function callback(){
		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get);

		if ($this->CI->config->item('Oauth2_CSRF_Supported') == TRUE)
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
		if($this->CI->config->item('Oauth2_Grant_Type') != ""){
			$token_url['grant_type'] = $this->CI->config->item('Oauth2_Grant_Type');
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
				$return = json_decode($response , true);
				if($return == NULL){			
					parse_str($response, $return); 
				}

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

	protected function throw_oauth2_exception($response, $response_type, $response_details = null){
    	
    		throw new CamelotAuthException($this->response_codes[$response], $this->CI->lang->line('camelot_error_' . $response),TRUE, $response_details);
    	
    	return FALSE;
    }
}