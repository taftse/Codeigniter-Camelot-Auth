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

class Affiliation_descriptor{

	// attributes
	public $affiliation_owner_ID;
	public $ID = NULL;
	public $valid_until = NULL;
	public $cache_duration = NULL;
	
	//elements
	public $signature = NULL;
	public $extensions = NULL;
	public array $affiliate_member;
	public array $key_descriptor = NULL;


	public function __construct($affiliation_owner_ID,$ID = NULL,$valid_until = NULL,$cache_duration = NULL,$error_URL = NULL){
		$this->affiliation_owner_ID = $affiliation_owner_ID;
		$this->ID = $ID;
		$this->valid_until = $valid_until;
		$this->cache_duration = $cache_duration;
		
	}

	public function set_signature($signature){
		$this->signature = $signature;
	}

	public function set_extension($extensions){
		$this->extensions = $extensions;
	}

	public function add_affiliate_member($affiliate_member)
	{
		$this->affiliate_member[] = $affiliate_member; 
	}
	public function add_key_descriptor(Key_descriptor $key_descriptor)
	{
		$this->key_descriptor[] = $key_descriptor;
	}

	
}