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

 class Entity {

 	/**
 	*
 	*/
 	public $entity_ID;

 	public $ID = NULL;

 	public $valid_until = NULL;

 	public $cache_duration = NULL;

 	public $signature = NULL;

 	public $extentions =array();

 	public $desctiptors = array();

 	public $organization = array();

 	public $contact_persons = array();

 	public $additional_metadata_locations = NULL;

 	
 	public function __construct($entity_ID, $ID = NULL,$valid_until = NULL,$cache_duration = NULL)
 	{
 		$this->entity_ID = $entity_ID;
 		$this->ID = $ID;
 		$this->valid_until = $valid_until;
 		$this->cache_duration = $cache_duration;
 	}

 	public function set_signature($signature){
 		$this->signature = $signature;
 	}

 	public function set_extensions($extensions){
 		$this->extensions = $extensions;
 	}

 	public function add_descriptor($desctiptor){
 		$this->desctiptors[] = $desctiptor;
 	}

 	public function add_organisation(Organization $organization){
 		$this->organization =$organization; 
 	}

 	public function add_contact_person(ContactPerson $contact_person){
 		$this->contact_persons[] = $contact_person;
 	}

 	public function add_additional_metadata_locations($URL,$namespace){
 		$this->additional_metadata_locations[][$namespace] = $URL;
 	}
 }