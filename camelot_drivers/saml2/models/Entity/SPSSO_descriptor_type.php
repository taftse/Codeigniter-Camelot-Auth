<?php 

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
include('./SSO_descriptor_type.php');
include('./Attribute_consuming_service.php');
class SPSSO_descriptor_type extends SSO_descriptor_type{
	// attributes
	public bool $auth_requests_signed = FALSE;
	public bool $want_auth_request_signed = FALSE;
	//elements
	public array $assertion_consumer_services = array();
	public array $attribute_consumer_services = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	public function set_auth_requests_signed($auth_requests_signed){
		$this->auth_requests_signed = $auth_requests_signed;
	}
	
	public function set_want_auth_request_signed($want_auth_request_signed){
		$this->want_auth_request_signed = $want_auth_request_signed;
	}
		
	public function add_assertion_consumer_service($binding,$location,$index,$default = FALSE,$response_location = NULL){
		$this->assertion_consumer_service[] = new Indexed_endpoint_type($binding,$location,$index,$default,$response_location);
	}

	public function add_attribute_consumer_service($attribute_consumer_service){
		$this->attribute_consumer_service[] = $attribute_consumer_service;
	}
}