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

class Role_descriptor{

	// attributes
	public $protocol_support_enumeration;
	public $ID = NULL;
	public $valid_until = NULL;
	public $cache_duration = NULL;
	public $error_URL = NULL;
	//elements
	public $signature = NULL;
	public $extensions = NULL;
	public array $key_descriptor = NULL;
	public array $organization = array();
 	public array $contact_persons = array();

	public function __construct($protocol_support_enumeration,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		$this->protocol_support_enumeration = $protocol_support_enumeration;
		$this->ID = $ID;
		$this->valid_until = $valid_until;
		$this->cache_duration = $cache_duration;
		$this->error_URL = $error_URL;
	}

	public function set_signature($signature){
		$this->signature = $signature;
	}

	public function set_extension($extensions){
		$this->extensions = $extensions;
	}

	public function add_key_descriptor(Key_descriptor $key_descriptor)
	{
		$this->key_descriptor[] = $key_descriptor;
	}

	public function add_organisation(Organization $organization){
 		$this->organization =$organization; 
 	}

 	public function add_contact_person(Contact_persons $contact_persons){
 		$this->contact_persons[] = $contact_persons;
 	}

}