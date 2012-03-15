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
class camelot_auth {

    // codeigniter instance
    protected $CI;
    // array of all the supported drivers 
    protected $supported_drivers = array();
    // array of all the supported providers
    protected $supported_providers = array();
    // Error codes in the response object
    private $response_codes;
    //Response messages that can be returned to the user or logged in the application
    //private $response_messages;
    
    // the driver being used
    public $driver_name = NULL;

    // the driver to be used 
    protected $driver = NULL;
    // the provider making the requests
    public $provider_name = NULL;

     public function __construct() {

        define('CAMELOT-AUTH_VERSION', '0.0.1');
        // get the codeigniter instance and assign it to $CI
        $this->CI =& get_instance();

        // load the required configuration files 
        $this->CI->load->config('camelot_auth');
        $this->CI->load->config('camelot_response_codes');
        // load the required libraries
        $this->CI->load->library('session');
        $this->CI->load->library('uri');

        $this->CI->load->helper('url');

        $this->CI->lang->load('camelot_error');

        // assign the basic confifuration details 
        $this->supported_drivers = $this->CI->config->item('Authentication_Drivers');
        $this->supported_providers = $this->CI->config->item('Authentication_Providers');
        $this->response_codes = $this->CI->config->item('Camelot_Response_Codes');

        log_message('debug', 'camelot_auth Library loaded');
    }


      // public function method(pram['provider'],
    public function __call($method, $params) {
        // has a provider been set
        if(!isset($this->provider_name)){
        // no should i detect provider?
            if($this->CI->config->item('Authentication_Provider_Detect')){
                // try to detect driver
                $detect_provider = $this->detect_provider();

            }else{
                $detect_provider = $this->set_provider($this->CI->config->item('Authentication_Provider_Default'));
            }   
            if($detect_provider !== TRUE)
            {
                return $detect_provider;
            }           
        }
        
        if(method_exists($this->driver, $method)){
            return $this->driver->$method($params);
        }else{
            return $this->return_response('error', 'unknown_authentication_provider_function', 'provider_response', array('Provider_Name'=>$this->provider_name,'Requested_method'=>$method));
        }

    }

    public function detect_provider($uri_segment = NULL)
    {
        // detecting identity provider from url segments
        if($uri_segment == NULL)
        {
            $uri_segment = $this->CI->config->item('Authentication_Provider_Uri_Segment');
        }
        $provider_name = $this->set_provider(ucfirst($this->CI->uri->rsegment($uri_segment)));
        if($provider_name != TRUE){
            return $this->set_provider($this->CI->config->item('Authentication_Provider_Default'));
        }
        return $provider_name;
    }

    public function set_provider($provider_name){
        if(array_key_exists($provider_name, $this->supported_providers)){
            $this->provider_name = $provider_name;
            return $this->load_driver($this->supported_providers[$provider_name]['Driver']);
        }
       return $this->return_response('error', 'unknown_authentication_provider', 'local_response',array('Provider_Name'=>$provider_name));
    }

    private function load_driver($driver_name)
    {

         if (key_exists($driver_name, $this->supported_drivers)) {
            $this->driver_name = $driver_name;
            $driver_file = 'Camelot_driver_' . $driver_name;
            $driver_path = dirname(__FILE__) . '/../camelot_drivers/' . $driver_name . '/'.$driver_file.'.php';

             if (!file_exists($driver_path)) {

                return $this->return_response('error', 'driver_file_missing', 'local_response', array('Driver_Name' => $driver_name,'Driver_File'=>$driver_file.'.php' ,'Driver_Path' => $driver_path));
            }
            include_once $driver_path;
            if (!class_exists($driver_file)) {
                return $this->return_response('error', 'no_valid_class', 'local_response', array('Driver_Name' => $driver_name, 'Driver_File'=>$driver_file.'.php' ,'Driver_Path' => $driver_path));
            }
            $this->driver = new $driver_file($this);
            return TRUE;
         }
         return $this->return_response('error', 'unknown_authentication_driver', 'local_response', array('Driver_Name' => $driver_name));
    }

    /**
     * Returns the response
     *
     * @param string can be either 'Success' or 'Failure'
     * @param string the response used to grab the code / message
     * @param string whether the response is coming from the application or the gateway
     * @param mixed can be an object, string or null. Depends on whether local or gateway.
     * @return object response object
     */
    public function return_response($status, $response, $response_type, $response_details = null) {
        $status = strtolower($status);

        if ($status == 'success') {
            $message_type = 'info';
        } else {
            $message_type = 'error';
        }

        log_message($message_type, $this->CI->lang->line('camelot_error_' . $response));

        $return_response['status'] = $status;
        $return_response['response_code'] = $this->response_codes[$response];
        $return_response['response_message'] = $this->CI->lang->line('camelot_error_' . $response);

        if ($response_type == 'local_response') {
            $return_response['type'] = 'local_response';
            if (!is_null($response_details)) {
                $return_response['details'] = $response_details;
            }
            return (object) $return_response;
        } else if ($response_type == 'driver_response') {
            $response['type'] = 'driver_response';
            $return_response['details'] = $response_details;
            return (object) $return_response;
        }
    }
}

class Camelot_Driver{

    public $camelot;
    protected $CI;

    public function __construct($camelot){
        $this->camelot = $camelot;
        $this->CI =& get_instance();
        $this->load = new Camelot_Driver_Loader($camelot->driver_name);
    }
}

class Camelot_Driver_Loader{

    protected $CI;
    public function __construct($driver_name)
    {
        $this->CI =& get_instance();
        define('CAMELOT_DRIVER_PATH', '../camelot_drivers/'.$driver_name.'/');
    }
    /**
     * Loads a config file
     *
     * @param   string
     * @param   bool
     * @param   bool
     * @return  void
     */
    public function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
    {
        $this->CI->load->config(CAMELOT_DRIVER_PATH.'config/'.$file, $use_sections,$fail_gracefully);
    }

    public function library($library = '', $params = NULL, $object_name = NULL)
    {

    }

    public function model()
    {

    }

    public function language()
    {

    }
}