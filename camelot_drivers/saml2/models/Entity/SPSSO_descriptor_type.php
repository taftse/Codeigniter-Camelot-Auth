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

class SPSSO_descriptor_type extends SSO_descriptor_type{
	// attributes
	public bool $want_auth_request_signed = FALSE;
	//elements
	

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		parent::__construct($protocol_support_enumeration,$ID,$valid_until,$cache_duration,$error_URL);
	}

	
}