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
include_once('./Endpoint_type.php');
class Indexed_endpoint_type extends Endpoint_type{
	
	public int $index;
	public bool $default= FALSE;

	public function __construct($binding,$location,$index,$default = FALSE,$response_location = NULL)
	{
		parent::__construct($binding,$location,$response_location);
		$this->index = $index;
		$this->default = $default;
	}
}