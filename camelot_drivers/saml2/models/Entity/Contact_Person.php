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

class Contact_Person{

	public string $contact_type;
	public $extension = NULL;
	public string $company = NULL;
	public string $given_name = NULL;
	public string $sur_name = NULL;
	public string $email_address = NULL;
	public string $telephone_number = NULL;

	public function __construct($contact_type)
	{
		$this->$contact_type = $contact_type;
	}

	public function set_extension($extension){
		$this->extension = $extension;
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