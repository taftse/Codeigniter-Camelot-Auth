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

	public $load;
	public $CI;

	public function __construct($prams)
	{
		$this->CI = get_instance();
		$this->load = $prams['load'];
		$this->load->model('SAML2_Model');
		$this->load->model('SAML2_Entity_model');
	}

	public function import($entities ,$federation_ID = null){
		if(is_array($entities)){
			foreach ($entities as $entity) {
				$this->_import($entity);
			}
		}else{
			$this->_import($entities);
		}
	}
	protected function _import($entity){
		//var_dump($entity);
		$entity_data['Entity_UID'] = htmlspecialchars($entity->entity_ID);
	
		if(isset($entity->organization->name['en'][0]))
		{
			$entity_data['Entity_Name'] = htmlspecialchars($entity->organization->display_name['en'][0]);
		}
		var_dump($entity->desctiptors[0]);
		switch (get_class($entity->desctiptors[0])) {
			case 'IDPSSODescriptor':
				$entity_data['Entity_Type'] = 'IDP';
				break;
			case 'SPSSODescriptor':
				$entity_data['Entity_Type'] = 'SP';
				break;
		}
		$entity_ID = $this->CI->SAML2_Entity_model->syncronise($entity_data);
		var_dump($entity_ID);
		//$this->CI->
	}
}