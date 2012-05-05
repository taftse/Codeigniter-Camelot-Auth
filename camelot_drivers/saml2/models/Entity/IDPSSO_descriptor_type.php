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

class IDPSSO_descriptor_type extends SSO_descriptor_type{
	// attributes
	public bool $want_auth_request_signed = FALSE;
	//elements
	public array $single_sign_on_service = NULL;
	public array $name_ID_mapping_service = NULL;
	public array $assertion_ID_request_service = NULL;
	public array $attribute_profile = NULL;
	public array $attribute = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	public function add_single_sign_on_service($single_sign_on_service){
		$this->single_sign_on_service[]= $single_sign_on_service;
	}

	public function add_name_ID_mapping_service($name_ID_mapping_service){
		$this->name_ID_mapping_service[]= $name_ID_mapping_service;
	}

	public function add_assertion_ID_request_service($assertion_ID_request_service){
		$this->assertion_ID_request_service[]= $assertion_ID_request_service;
	}
	
	public function add_attribute_profile($attribute_profile){
		$this->attribute_profile[]= $attribute_profile;
	}
	
	public function add_attribute($attribute){
		$this->attribute[]= $attribute;
	}
}