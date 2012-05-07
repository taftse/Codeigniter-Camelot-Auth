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

include('./Role_descriptor.php');
include('./Endpoint_type.php');

class PDP_descriptor extends Role_descriptor{

	public array $authz_service;
	public array $assertion_ID_request_service = NULL;
	public array $name_ID_format = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	public function add_authz_service($binding,$location,$response_location = NULL)
	{
		$this->authz_service[] = new Endpoint_type($binding,$location,$response_location);
	}
	
	public function add_assertion_ID_request_service($binding,$location,$response_location = NULL)
	{
		$this->assertion_ID_request_service[] = new Endpoint_type($binding,$location,$response_location);
	}

	public function add_name_ID_format($name_ID_format){
		$this->name_ID_format[] = $name_ID_format;
	}
}
