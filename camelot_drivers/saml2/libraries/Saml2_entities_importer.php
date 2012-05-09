<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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

class Saml2_entities_importer {

	protected $CI;

	public function __construct()
	{
		$this->CI = get_instance();
	}

	public function import($entities){
		foreach ($entities as $entity) {
			$this->_import($entity);
		}
	}
	protected function _import($entity){

	}
}