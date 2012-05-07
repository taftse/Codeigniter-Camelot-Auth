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

class KeyDescriptor {

	public $key;
	public $use = NULL;
	public $encryption_method = NULL;

	public function __construct($key, $use = NULL, $encryption_method = NULL)
	{
		$this->key = $key;
		
		if(!is_null($use)) {
			$this->use = $use;
		}

		if(!is_null($encryption_method))
		{
			$this->add_encryption_method($encryption_method);
		}
	}

	public function add_encryption_method($encryption_method){
		$this->encryption_method[] = $encryption_method;
	}
}