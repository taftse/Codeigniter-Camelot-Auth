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

class SSO_descriptor_type extends Role_descriptor{

	public array $artifact_resolution_service = NULL;
	public array $single_logout_service = NULL;
	public array $manage_name_ID_service = NULL;
	public array $name_ID_format = NULL;

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	public function add_artifact_resolution_service($artifact_resolution_service)
	{
		$this->artifact_resolution_service[] = $artifact_resolution_service;
	}

	public function add_single_logout_service($single_logout_service)
	{
		$this->single_logout_service[] = $single_logout_service;
	}

	public function add_manage_name_ID_service($manage_name_ID_service)
	{
		$this->manage_name_ID_service[] = $manage_name_ID_service;
	}

	public function add_name_ID_format($name_ID_format)
	{
		$this->name_ID_format[] = $name_ID_format;
	}

}