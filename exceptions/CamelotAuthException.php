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

class CamelotAuthException extends Exception{

	protected $return_response;
	

	public function __construct($response_code,$response_message,$log = TRUE, Exception $previous = null,$response_details = null){
		
		parent::__construct($response_message,$response_code,$previous);
		

		if($log == TRUE){
			log_message('error',$this->getFile().':'$this->getLine().'-'.$response_code.': '.$response_message);
		}
		 $this->return_response['response_code'] = $response_code;
		 $this->return_response['response_message'] = $response_message;
		 if (!is_null($response_details)) {
                $this->return_response['details'] = $response_details;
        }
	}

	public __toString(){
		return (object) $this->return_response;
	}
}