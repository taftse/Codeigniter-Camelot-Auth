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

class Camelot_Driver{

    public $camelot;
    protected $CI;

    public function __construct($camelot = NULL){
    	include_once 'camelot_loader.php';
        $this->camelot = $camelot;
        $this->CI =& get_instance();
        $this->load = new Camelot_Loader($camelot->driver_name);
        $this->CI->load->model('Camelot_model');
    }
}

