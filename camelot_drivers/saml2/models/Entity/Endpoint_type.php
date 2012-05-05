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

class Endpoint_type {
	
	public string $binding;
	public string $location;
	public string $response_location = NULL;

	public function __construct($binding,$location,$response_location = NULL)
	{
		$this->binding = $binding;
		$this->location $location;
		$this->response_location = $response_location;
	}
}