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
include('./Indexed_endpoint_type.php');

class SSO_descriptor_type extends Role_descriptor{

	public array $artifact_resolution_service = NULL;
	public array $single_logout_service = NULL;
	public array $manage_name_ID_service = NULL;
	public array $name_ID_format = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	public function add_artifact_resolution_service($binding,$location,$index,$default = FALSE,$response_location = NULL)
	{

		$this->artifact_resolution_service[] = new Indexed_endpoint_type($binding,$location,$index,$default,$response_location);
	}

	public function add_single_logout_service($binding,$location,$response_location = NULL)
	{
		$this->single_logout_service[] = new Endpoint_type($binding,$location,$response_location);
	}

	public function add_manage_name_ID_service($binding,$location,$response_location = NULL)
	{
		$this->manage_name_ID_service[] = new Endpoint_type($binding,$location,$response_location);
	}

	public function add_name_ID_format($name_ID_format)
	{
		$this->name_ID_format[] = $name_ID_format;
	}

}