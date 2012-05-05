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

class Organization{

	public array $name = array();
	public array $display_name = array();
	public array $URL = array();
	public $extentions = NULL;

	public function __construct(array $name,array $display_name,array $URL,array $extention = NULL){
		$this->add_name($name['value'],$name['lang']);
		$this->add_display_name($display_name['value'],$display_name['lang']);
		$this->add_URL($URL['value'],$URL['lang']);
		if($extention != NULL){
			$this->add_extention($extention);
		}
	}
	public function add_name($name , $language){
		$this->name[][$language] = $name;
	}

	public function add_display_name($display_name,$language){
		$this->display_name[][$language] =$display_name;
	}

	public function add_URL($URL,$language){
		$this->URL[][$language]= $URL;
	}
	public function set_extentions($extentions){
		$this->extentions = $extentions;
	}

}





