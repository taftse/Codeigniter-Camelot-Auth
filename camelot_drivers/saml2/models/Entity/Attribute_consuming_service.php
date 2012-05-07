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
include('./Requested_attribute.php');
class Attribute_consuming_service{

	public int $index;
	public bool $default = FALSE;
	public array $service_name = array();
	public array $service_descriptor = NULL;
	public array $requested_attribute = array();

	public function __construct($index,$default = FALSE){
		$this->index = $index;
		$this->default = $default;
	}

	public function add_service_name($name,$lang){
		$this->service_name[] = array('value'=>$name,'lang'=>$lang);
	}

	public function add_service_descriptor($descriptor,$lang)
	{
		$this->service_descriptor[] = array('value'=>$descriptor,'lang'=>$lang);
	}

	public function add_requested_attribute($requested_attribute)
	{
		$this->requested_attribute[] = $requested_attribute;
	}
}