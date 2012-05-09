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

class ContactPerson{

	public $contact_type;
	public $extensions = NULL;
	public $company = NULL;
	public $given_name = NULL;
	public $sur_name = NULL;
	public $email_address = NULL;
	public $telephone_number = NULL;

	public function __construct($contact_type)
	{
		$this->$contact_type = $contact_type;
	}

	public function set_extensions($extensions){
		$this->extensions = $extensions;
	}

	public function set_company($company){
		$this->company = $company;
	}

	public function set_given_name($given_name){
		$this->given_name = $given_name;
	}

	public function set_sur_name($sur_name){
		$this->sur_name = $sur_name;
	}

	public function set_email_address($email_address){
		$this->email_address = $email_address;
	}
	
	public function set_telephone_number($telephone_number){
		$this->telephone_number = $telephone_number;
	}

}