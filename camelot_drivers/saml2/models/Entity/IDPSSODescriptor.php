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
include(__DIR__.'/SSODescriptor.php');
class IDPSSODescriptor extends SSODescriptor{
	// attributes
	public $want_auth_request_signed = FALSE;
	//elements
	public $single_sign_on_service = NULL;
	public $name_ID_mapping_service = NULL;
	public $assertion_ID_request_service = NULL;
	public $attribute_profile = NULL;
	public $attribute = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL,$want_auth_request_signed= FALSE){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
		$this->want_auth_request_signed = $want_auth_request_signed;
	}

	public function set_want_auth_request_signed($want_auth_request_signed){
		$this->want_auth_request_signed = $want_auth_request_signed;
	}

	public function add_single_sign_on_service($binding,$location,$response_location = NULL){
			$this->single_sign_on_service[] = new Endpoint_type($binding,$location,$response_location);
	}

	public function add_name_ID_mapping_service($binding,$location,$response_location = NULL){
		$this->name_ID_mapping_service[] = new Endpoint_type($binding,$location,$response_location);
	}

	public function add_assertion_ID_request_service($binding,$location,$response_location = NULL){
		$this->assertion_ID_request_service[] = new Endpoint_type($binding,$location,$response_location);
	}
	
	public function add_attribute_profile($attribute_profile){
		$this->attribute_profile[]= $attribute_profile;
	}
	
	public function add_attribute($attribute){
		$this->attribute[]= $attribute;
	}
}