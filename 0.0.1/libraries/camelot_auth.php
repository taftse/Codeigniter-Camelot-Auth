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


class Camelot_auth{

	 // codeigniter instance
    protected $CI;
    // array of all the supported drivers 
    protected $supported_drivers = array();
    // array of all the supported providers
    protected $supported_providers = array();
     // Error codes in the response object
    private $response_codes;

     // the driver being used
    protected $driver_name = NULL;

    // the provider making the requests
    //public $provider_name = NULL;

    // the driver to be used 
    protected $driver = NULL;

    public function __construct() {

        define('CAMELOT-AUTH_VERSION', '0.0.1');
        $this->CI =& get_instance();
		
		// load the required configuration files 
        $this->CI->load->config('camelot_auth');
        $this->CI->load->config('camelot_response_codes');

         // load the required libraries
        $this->CI->load->library('session');
        $this->CI->load->library('uri');

         // load the required helpers
        $this->CI->load->helper('url');

        // load the required models
        $this->CI->load->model('Camelot_model');

        // load the required language files
        $this->CI->lang->load('camelot_error');

		$this->supported_drivers = $this->CI->config->item('Authentication_Drivers');
        $this->supported_providers = $this->CI->config->item('Authentication_Providers');
        $this->response_codes = $this->CI->config->item('Camelot_Response_Codes');

        log_message('debug', 'camelot_auth Library loaded');




	}

    public function __call($method,$params){
      	// is a driver loaded ?
       	if($this->driver == NULL){
       		// lets load a driver
       		$this->detect_provider();
       	}
       	// lets see if the driver contains the following method 
       	if(method_exists($this->driver, $method)){
       		// lets call the method 
           	return $this->driver->$method($params);
        }else{
           	// the method is not found throw an exception
           	return $this->throw_exception('unknown_authentication_provider_function', 'provider_response', array('Provider_Name'=>$this->provider_name,'Requested_method'=>$method));            	
        }
    }

    public function detect_provider($uri_segment = NULL){
       	// if no segment number has been provided 
       	if($uri_segment == NULL)
       	{
           	$uri_segment = $this->CI->config->item('Authentication_Provider_Uri_Segment');
       	}
       	try{
       	// lets get the provider name from the uri and load the driver
       	$provider_name = $this->set_provider(ucfirst($this->CI->uri->rsegment($uri_segment)));
       	}catch(CamelotAuthException $e){
       		try{
       		
    	       	$provider_name = $this->set_provider($this->CI->config->item('Authentication_Provider_Default'));
        	}catch(CamelotAuthException $e2){
        		return $e2;
        	}
        }
        	return $provider_name;
    }
    
    public function set_provider($provider_name){
       	// does the provider exist 
       	if(array_key_exists($provider_name, $this->supported_providers)){

      		$driver_name = $this->supported_providers[$provider_name]['Driver'];
       		// does the driver exist
       		if (key_exists($driver_name, $this->supported_drivers)) {
       			$driver_file = 'Camelot_driver_' . $driver_name;
       			$driver_path = dirname(__FILE__) . '/../camelot_drivers/' . $driver_name . '/libraries/'.$driver_file.'.php';
       			// does the driver file exist 
       			if (!file_exists($driver_path)) {
       				return $this->throw_exception('driver_file_missing', 'local_response', array('Driver_Name' => $driver_name,'Driver_File'=>$driver_file.'.php' ,'Driver_Path' => $driver_path));
       			}
       			// include the basic driver 
       			include_once 'Camelot_driver.php';
       			// include the driver 
       			include_once $driver_path;
       			// does the class exist ?
       			if (!class_exists($driver_file)) {
       			 	return $this->throw_exception( 'no_valid_class', 'local_response', array('Driver_Name' => $driver_name, 'Driver_File'=>$driver_file.'.php' ,'Driver_Path' => $driver_path));
           		}
           		$this->driver = new $driver_file($provider_name);
           		// loaded the class successful so return true
           		return TRUE;
       		}
       	}
       	// provider is unknown throw an exception
       	return $this->throw_exception('unknown_authentication_provider','local_response',array('Provider_Name'=>$provider_name));
       	
    }        

    public function throw_exception($response, $response_type, $response_details = null){
    	if($response_type== 'local_response'){
    		throw new CamelotAuthException($this->response_codes[$response], $this->CI->lang->line('camelot_error_' . $response),TRUE, $response_details);
    	}elseif($response_type == 'driver_response'){

    	}
    	return FALSE;
    }
}