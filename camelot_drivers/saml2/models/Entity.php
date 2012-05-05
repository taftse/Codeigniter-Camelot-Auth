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
 	public string $entity_ID;

 	public $ID = NULL;

 	public date $valid_until = NULL;

 	public int $cache_duration = NULL;

 	public $signature = NULL;

 	public array $extentions =array();

 	public array $desctiptors = array();

 	public array $organization = array();

 	public array $contact_persons = array();

 	public array $additional_metadata_locations = NULL;

 	
 	public function __construct($entity_ID, $ID = NULL,$valid_until = NULL,$cache_duration = NULL)
 	{
 		$this->$entity_ID = $entity_ID;
 		$this->ID = $ID;
 		$this->valid_until = $valid_until
 		$this->cache_duration = $cache_duration
 	}

 	public function set_signature($signature){
 		$this->signature = $signature;
 	}

 	public function add_extention(){

 	}

 	public function add_descriptor(){

 	}

 	public function add_organisation(Organization $organization){
 		$this->organization =$organization; 
 	}

 	public function add_contact_person(Contact_persons $contact_persons){
 		$this->contact_persons[] = $contact_persons;
 	}

 	public function add_additional_metadata_locations($URL,$namespace){
 		$this->additional_metadata_locations[][$namespace] = $URL;
 	}
 }