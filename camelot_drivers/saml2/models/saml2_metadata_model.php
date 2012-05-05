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
 *  @copyright       2012, Timothy Seebus
 *  @link            http://labs.Twsweb-int.com/network
 *  @filesource
 */

class saml2_metadata_model extends Camelot_model {
		
	public function __construct()
	{
		parent::__construct();

		$this->_table = 'Auth_Saml2_Metadata';
		$this->primary_key = 'Saml2_Metadata_ID';
	}

	public function get_URL_by_ID($metadata_ID){
		$metadata = $this->get($metadata_ID);
		return $metadata;
	}

	public function get_URL_by_Name($metadata_name){
		$metadata =$this->_set_where('Saml2_Metadata_Name',$metadata_name);
		$query = $this->db->get($this->_table);
		if($query->num_rows() == 1){
			var_dump($query->row()->Saml2_Metadata_URL);
        	return $query->row()->Saml2_Metadata_URL;
    	}
    	return FALSE;
	}
}