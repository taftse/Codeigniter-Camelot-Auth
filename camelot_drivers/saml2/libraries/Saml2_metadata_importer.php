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
class Saml2_metadata_importer
{
	protected $metadata;
	protected $namespaces;
	protected $imported_entities;

	public function __construct()
	{
		
	}

	public function import_from_file($file){
		return $this->parse_metadata(file_get_contents($file));
	}

	public function import_from_url($URL){
		
		return $this->parse_metadata(file_get_contents($URL));
	}

	public function import_from_text($xml){
		return $this->parse_metadata($xml);
		
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

		$imported_entity = new Entity($entity_attributes['entityID'],$entity_attributes['ID'],$entity_attributes['validUntil'],$entity_attributes['cacheDuration']);

		foreach ($this->namespaces as $namespace => $URL)  {
			foreach ($entity->children($URL) as $num => $node) {
				switch ($node->getName()) {
					case 'Extensions':
						$imported_entity->set_extension($node);
						break;
					case 'IDPSSODescriptor':
						 $imported_entity->add_descriptor($this->get_IDPSSODescriptor($node));
						break;
					case 'SPSSODescriptor':
						 $imported_entity->add_descriptor($this->get_SPSSODescriptor($node));
						break;
					case 'Organization':
						$imported_entity->add_organisation($this->get_organization($node));
						break;
					case 'ContactPerson':
						$imported_entity->add_contact_person($this->get_contact_person($node));
						break;
					case 'Signature':
						$imported_entity->set_signature($node);
						break;
					default:	
						echo 'Unknown metadata schema: '.$entity->children($URL)->getName().' ';
						break;
				}
			}
		}
		return $imported_entity;
	} 

	protected function get_entities($entities)
	{	
		$imported_entities = array();
		$last_count = 0;
		foreach ($this->namespaces as $namespace => $URL) {
			foreach ($entities->children($URL) as $num =>$entity) {
				switch ($entity->getName()) {
					case 'EntityDescriptor':
						$imported_entities[] = $this->get_entity($entity);		
					break;
					case 'Signature':
						break;
					default:
						echo 'Unknown metadata schema: '.$entity->getName().' <br/>';
						break;
				}
				
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
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['Binding'],$indexed_endpoint_type['Location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['isDefault'],$indexed_endpoint_type['ResponseLocation']);
					break;
					case 'SingleLogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($node);
					break;
					// IDP Descriptor type
					case 'SingleSignOnService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_sign_on_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'NameIDMappingService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_name_ID_mapping_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'AssertionIDRequestService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_assertion_ID_request_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
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
		return $imported_descriptor;
	}

	protected function get_SPSSODescriptor($descriptor)
	{
		include_once (__DIR__.'/../models/Entity/SPSSODescriptor.php');
		$descriptor_attributes['ID'] = NULL;
		$descriptor_attributes['validUntil'] = NULL;
		$descriptor_attributes['cacheDuration'] = NULL;	
		$descriptor_attributes['protocolSupportEnumeration'] = NULL;
		$descriptor_attributes['errorURL'] = NULL;
		$descriptor_attributes['AuthnRequestSigned'] = NULL;
		$descriptor_attributes['WantAssertionSigned'] = NULL;
		$descriptor_attributes = $this->get_attributes($descriptor,$descriptor_attributes);
		$imported_descriptor = new SPSSODescriptor($descriptor_attributes['protocolSupportEnumeration'],$descriptor_attributes['ID'],$descriptor_attributes['validUntil'],$descriptor_attributes['cacheDuration'],$descriptor_attributes['errorURL']);
		
		if(!is_null($descriptor_attributes['AuthnRequestSigned'])){
			$imported_descriptor->set_authn_requests_signed($descriptor_attributes['AuthnRequestSigned']);
		}

		if(!is_null($descriptor_attributes['WantAssertionSigned'])){
			$imported_descriptor->set_want_auth_request_signed($descriptor_attributes['WantAssertionSigned']);
		}
		foreach ($this->namespaces as $namespace => $URL) {
			foreach ($descriptor->children($URL) as $num =>$node) {
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
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['Binding'],$indexed_endpoint_type['Location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['isDefault'],$indexed_endpoint_type['ResponseLocation']);
						break;
					case 'SingleLogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
						break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
						break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($node);
						break;
					// SPSSODescriptor Type
					case 'AssertionConsumerService':
						$indexed_endpoint_type = $this->get_indexed_endpoint_type($node);
						$imported_descriptor->add_assertion_consumer_service($indexed_endpoint_type['Binding'],$indexed_endpoint_type['Location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['isDefault'],$indexed_endpoint_type['ResponseLocation']);
						break;
					case 'AttributeConsumingService':
						$imported_descriptor->add_attribute_consumer_service($node);
						break;
					default:
						echo 'Unknown element';
						break;
				}
			}
		}
		return $imported_descriptor;
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
		return new KeyDescriptor($key, $key_attributes['use'], $encryption_method);
	}

	protected function get_organization($organization){
		include_once (__DIR__.'/../models/Entity/Organization.php');

		$OrganizationName = array('value' => $organization->OrganizationName,'lang'=>$organization->OrganizationName->attributes('xml',TRUE)->lang);
		$OrganizationDisplayName = array('value' => $organization->OrganizationDisplayName,'lang'=>$organization->OrganizationDisplayName->attributes('xml',TRUE)->lang);

		$OrganizationURL = array('value' => $organization->OrganizationURL,'lang'=>$organization->OrganizationURL->attributes('xml',TRUE)->lang);
		$Extensions = NULL;
		if(isset($organization->Extensions))
		{
			$Extensions = $organization->Extensions;
		}
		return new Organization($OrganizationName,$OrganizationDisplayName,$OrganizationURL,$Extensions);	
	}

	protected function get_contact_person($contact_person)
	{
		include_once (__DIR__.'/../models/Entity/ContactPerson.php');
		
		
		$imported_contact = new ContactPerson($contact_person->attributes()->contactType);
		
		if(isset($contact_person->Extensions))
		{
			$imported_contact->set_extensions($contact_person->Extensions);
		}
		
		if(isset($contact_person->Company))
		{
			$imported_contact->set_company($contact_person->Company);
		}
		
		if(isset($contact_person->GivenName))
		{
			$imported_contact->set_given_name($contact_person->GivenName);
		}
		
		if(isset($contact_person->SurName))
		{
			$imported_contact->set_sur_name($contact_person->SurName);
		}
		
		if(isset($contact_person->EmailAddress))
		{
			$imported_contact->set_email_address($contact_person->EmailAddress);
		}
		
		if(isset($contact_person->TelephoneNumber))
		{
			$imported_contact->set_telephone_number($contact_person->$TelephoneNumber);
		}
		return $imported_contact;		
	}

	protected function get_endpoint_type($node)
	{

		$endpoint_type['Binding'] = NULL;
		$endpoint_type['Location'] = NULL;
		$endpoint_type['ResponseLocation'] = NULL;
		return $this->get_attributes($node,$endpoint_type);
		
		
	}

	protected function get_indexed_endpoint_type($node)
	{
		$indexed_endpoint_type['Binding'] = NULL;
		$indexed_endpoint_type['Location'] = NULL;
		$indexed_endpoint_type['ResponseLocation'] = NULL;
		$indexed_endpoint_type['index'] = NULL;
		$indexed_endpoint_type['isDefault'] = FALSE;
		return $this->get_attributes($node,$indexed_endpoint_type);
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
						$imported_descriptor->add_artifact_resolution_service($indexed_endpoint_type['Binding'],$indexed_endpoint_type['Location'],$indexed_endpoint_type['index'],$indexed_endpoint_type['isDefault'],$indexed_endpoint_type['ResponseLocation']);
					break;
					case 'SingleSogoutService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_single_logout_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'ManageNameIDService':
						$endpoint_type = $this->get_endpoint_type($node);
						$imported_descriptor->add_manage_name_ID_service($endpoint_type['Binding'],$endpoint_type['Location'],$endpoint_type['ResponseLocation']);
					break;
					case 'NameIDFormat':
						$imported_descriptor->add_name_ID_format($this->get_any_URI($node));
					break;
				}*/