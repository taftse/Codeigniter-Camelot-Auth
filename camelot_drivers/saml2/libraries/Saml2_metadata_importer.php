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
include_once (__DIR__.'/../models/Entity.php');
class saml2_metadata_importer
{
	protected $metadata;
	protected $namespaces;
	protected $imported_entities;

	public function __construct()
	{
		
	}

	public function import_from_file($file){
		$this->parse_metadata(file_get_contents($file));
	}

	public function import_from_url($URL){
		
		$this->parse_metadata(file_get_contents($URL));
	}

	public function import_from_text($xml){
		$this->parse_metadata($xml);
		
	}

	protected function parse_metadata($xml_metadata){
		$this->metadata = new SimpleXMLElement($xml_metadata);
		$this->namespaces = $this->metadata->getNamespaces(TRUE);
		$this->namespaces[''] = NULL;
		if($this->metadata->getName() == 'EntityDescriptor'){
			return $this->get_entity($this->metadata);
		}else if($this->metadata->getName() == 'EntitiesDescriptor'){
			return $this->get_entities($this->metadata);
		}else{
			return 'Unknown Metadata Type';
		}
	}

	protected function get_entity($entity)
	{
		$entity_attributes['entityID'] =NULL;
		$entity_attributes['ID'] = NULL;
		$entity_attributes['validUntil'] = NULL;
		$entity_attributes['cacheDuration'] = NULL;	

		$entity_attributes = $this->get_attributes($entity,$entity_attributes);
		
		echo $entity->getName().' '. $entity_attributes['entityID'].' <br/>';

		$imported_entity = new Entity($entity_attributes['entityID'],$entity_attributes['ID'],$entity_attributes['validUntil'],$entity_attributes['cacheDuration']);

		foreach ($this->namespaces as $namespace => $URL)  {
			echo $entity->children($URL)->getName().' <br/>';
			switch ($entity->children($URL)->getName()) {
				case 'Extensions':
					var_dump($entity->children($URL));
					$imported_entity->set_extensions();
					break;
				case 'IDPSSODescriptor':
					 $imported_entity->add_descriptor($this->get_IDPSSODescriptor($entity->children($URL)));
					break;
				case 'SPSSODescriptor':
					 $this->get_SPSSODescriptor($entity->children($URL));
					break;
				case '':
					break;

				default:	
					echo 'Unknown metadata schema: '.$entity->children($URL)->getName().' ';
					break;
			}
		}
		return $imported_entity;
	} 

	protected function get_entities($entities)
	{
		//var_dump($entities);
		//var_dump($entities->EntitiesDescriptor->children());
		//$entities = array();
		
		$imported_entities = array();
		$last_count = 0;
		foreach ($this->namespaces as $namespace => $URL) {
		//	var_dump($entities->children($URL));
			foreach ($entities->children($URL) as $num =>$entity) {
				//var_dump($entity);
				switch ($entity->getName()) {
					case 'EntityDescriptor':
						$imported_entities[] = $this->get_entity($entity);		
					break;
					default:
						echo 'Unknown metadata schema: '.$entity->getName().' <br/>';
						break;
				}
				echo 'Entities imported '.count($imported_entities).'<br/>';
				$last_count = $imported_entities;
			}	
		}

		return $imported_entities;	
	}

	protected function get_IDPSSODescriptor($descriptor)
	{
		include_once (__DIR__.'/../models/Entity/IDPSSODescriptor.php');
		$descriptor_attributes['ID'] = NULL;
		$descriptor_attributes['validUntil'] = NULL;
		$descriptor_attributes['cacheDuration'] = NULL;	
		$descriptor_attributes['protocolSupportEnumeration'] = NULL;
		$descriptor_attributes['errorURL'] = NULL;
		$descriptor_attributes['WantAuthRequestSigned'] = FALSE;
		$descriptor_attributes = $this->get_attributes($descriptor,$descriptor_attributes);
		
		$imported_descriptor = new IDPSSODescriptor($descriptor_attributes['protocolSupportEnumeration'],$descriptor_attributes['ID'],$descriptor_attributes['validUntil'],$descriptor_attributes['cacheDuration'],$descriptor_attributes['errorURL'],$descriptor_attributes['WantAuthRequestSigned']);

		foreach ($this->namespaces as $namespace => $URL) {
			foreach ($descriptor->children($URL) as $num =>$node) {
				var_dump($node->getName());
				switch ($node->getName()) {
					// Role Descriptor
					case 'Signature':
						$imported_descriptor->set_signature($node);
					break;
					case 'Extensions':
						$imported_descriptor->set_extension($node);
					break;
					case 'KeyDescriptor':
						$key_descriptor = $this->get_key_descriptor($node);
						$imported_descriptor->add_key_descriptor($key_descriptor);
					break;
					case 'Organization':
						$organization = $this->get_organization($node);
						$imported_descriptor->add_organisation($organization);
					break;
					case 'ContactPerson':
						$contact_persons = $this->get_contact_persons($node);
						$imported_descriptor->add_contact_persons($contact_persons);
					break;
					// sso descriptor type
					case 'ArtifactResolutionService':
						$indexed_endpoint_type = $this->get_indexed_endpoint_type($node);
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['binding'],$indexed_endpoint_type['location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['default'],$indexed_endpoint_type['response_location']);
					break;
					case 'SingleSogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($this->get_any_URI($node));
					break;
					// IDP Descriptor type
					case 'SingleSignOnService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_sign_on_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'NameIDMappingService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_name_ID_mapping_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'AssertionIDRequestService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_assertion_ID_request_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'AttributeProfile':
						$imported_descriptor->add_attribute_profile($this->get_any_URI($node));
					break;

					case 'Attribute':
						$imported_descriptor->add_attribute($node);
					break;
				}
			}
		}
	}

	protected function get_SPSSODescriptor($descriptor)
	{
		include_once (__DIR__.'/../models/Entity/SPSSODescriptor.php');
		$descriptor_attributes['ID'] = NULL;
		$descriptor_attributes['validUntil'] = NULL;
		$descriptor_attributes['cacheDuration'] = NULL;	
		$descriptor_attributes['protocolSupportEnumeration'] = NULL;
		$descriptor_attributes['errorURL'] = NULL;
		$descriptor_attributes = $this->get_attributes($descriptor,$descriptor_attributes);
		
		$imported_descriptor = new SPSSODescriptor($descriptor_attributes['protocolSupportEnumeration'],$descriptor_attributes['ID'],$descriptor_attributes['validUntil'],$descriptor_attributes['cacheDuration'],$descriptor_attributes['errorURL']);
		var_dump($imported_descriptor);

		foreach ($this->namespaces as $namespace => $URL) {
			foreach ($descriptor->children($URL) as $num =>$node) {
				switch ($node->getName()) {
					case 'Signature':
						$imported_descriptor->set_signature($node);
					break;
					case 'Extensions':
						$imported_descriptor->set_extension($node);
					break;
					case 'KeyDescriptor':
						$key_descriptor = $this->get_key_descriptor($node);
						$imported_descriptor->add_key_descriptor($key_descriptor);
					break;
					case 'Organization':
						$organization = $this->get_organization($node);
						$imported_descriptor->add_organisation($organization);
					break;
					case 'ContactPerson':
						$contact_persons = $this->get_contact_persons($node);
						$imported_descriptor->add_contact_persons($contact_persons);
					break;
					// sso descriptor type
					case 'ArtifactResolutionService':
						$indexed_endpoint_type = $this->get_indexed_endpoint_type($node);
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['binding'],$indexed_endpoint_type['location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['default'],$indexed_endpoint_type['response_location']);
					break;
					case 'SingleSogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($this->get_any_URI($node));
					break;
				}
			}
		}
	}

	protected function get_key_descriptor($key_descriptor){

		include_once (__DIR__.'/../models/Entity/KeyDescriptor.php');

		$key_attributes['use'] = NULL;

		$key_attributes = $this->get_attributes($key_descriptor,$key_attributes);

		$encryption_method = NULL;

		foreach ($this->namespaces as $namespace => $URL){
			switch ($key_descriptor->children($URL)->getName()) {
				case 'KeyInfo':
					$key = $key_descriptor->children($URL)->children('ds',TRUE)->children('ds',TRUE);
					break;
				case 'EncryptionMethod':
					$encryption_method = $key_descriptor->children($URL);
					break;
			}
		}
		var_dump($key);
		return new KeyDescriptor($key, $key_attributes['use'], $encryption_method);
	}

	protected function get_organization($organization){
		throw new Exception("Error Processing Request get_organization not implemented", 1);
		
	}

	protected function get_contact_persons($contact_persons)
	{
		throw new Exception("Error Processing Request get_contact_persons not implemented", 1);
		
	}

	protected function get_endpoint_type($node)
	{
		$indexed_endpoint_type['binding'] = NULL;
		$indexed_endpoint_type['location'] = NULL;
		$indexed_endpoint_type['response_location'] = NULL;

		throw new Exception("Error Processing Request get_endpoint_type not implemented", 1);
		
	}

	protected function get_indexed_endpoint_type($node)
	{
		$indexed_endpoint_type['binding'] = NULL;
		$indexed_endpoint_type['location'] = NULL;
		$indexed_endpoint_type['index'] = NULL;
		$indexed_endpoint_type['default'] = FALSE;
		$indexed_endpoint_type['response_location'] = NULL;

		throw new Exception("Error Processing Request get_indexed_endpoint_type not implemented", 1);
		
	}

	protected function get_any_URI($node)
	{
		throw new Exception("Error Processing Request get_any_URI not implemented", 1);
	}
	/**
	* parses the attribute list and returns a array 
	* if the array field is provided then it will override values;
	*/
	protected function get_attributes($node, $array = NULL){
		foreach ($node->attributes() as $key => $value) {
				$array[$key] = $value;
		}
		return $array;
	}
}



// role descriptor switch 
/*
switch ($node->getName()) {
					case 'Signature':
					$imported_descriptor->set_signature($node);
					break;
					case 'Extensions':
					$imported_descriptor->set_extension($node);
					break;
					case 'KeyDescriptor':
					$key_descriptor = $this->get_key_descriptor($node);
					$imported_descriptor->add_key_descriptor($key_descriptor);
					break;
					case 'Organization':
					$organization = $this->get_organization($node);
					$imported_descriptor->add_organisation($organization);
					break;
					case 'ContactPerson':
					$contact_persons = $this->get_contact_persons($node);
					$imported_descriptor->add_contact_persons($contact_persons);
					break;
					// sso descriptor type
					case 'ArtifactResolutionService':
						$indexed_endpoint_type = $this->get_indexed_endpoint_type($node);
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['binding'],$indexed_endpoint_type['location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['default'],$indexed_endpoint_type['response_location']);
					break;
					case 'SingleSogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['binding'],$endpoint_type['location'],$endpoint_type['response_location']);
					break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($this->get_any_URI($node));
					break;
				}*/