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

class saml2_entity_model extends SAML2_Model {

	public function __construct()
	{
		parent::__construct();

		$this->table = 'Entities';
		$this->primary_key = 'Entity_ID';
	}

	public function syncronise($entity_data)
	{
		// check if the entity exists using entity UID
		$this->db->select('Entity_ID');
		$entity_ID = $this->get_where('Entity_UID',$entity_data['Entity_UID']);
		if($entity_ID['Entity_ID'] == FALSE)
		{
			// insert into db the entity details 
				return $this->insert($entity_data);
		}else{
			// check if everything is up to date 
			if($this->get_where($entity_data) == FALSE){
				$this->update($entity_ID['Entity_ID'],$entity_data);
			}
			return $entity_ID['Entity_ID'];
		}
	}


	public function get_where($key, $value = NULL)
	{
		$this->set_where($key,$value);
		$query = $this->db->get($this->table_preflix.$this->table);
		if($query->num_rows() == 1){
			return $query->row_array();
		}else{
			return FALSE;
		}
	}
}

// Entity_Name, Entity_UID, Entity_Name_ID_Format, Entity_Support_URL, Entity_Home_URL, Entity_Owner_ID, Entity_Type, Entity_Aproved, Entity_Active, Entity_Valid_From, Entity_Valid_To, Entity_Description, Entity_Use_Static, Entity_Created_On, Entity_Last_Updated, Entity_Is_Locked