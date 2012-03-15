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


class Camelot_Loader{

    protected $CI;
    public function __construct($driver_name)
    {
        $this->CI =& get_instance();
        define('CAMELOT_DRIVER_PATH', '../camelot_drivers/'.$driver_name.'/');
    }
    /**
     * Loads a config file
     *
     * @param   string
     * @param   bool
     * @param   bool
     * @return  void
     */
    public function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
    {
        $this->CI->load->config(CAMELOT_DRIVER_PATH.'config/'.$file, $use_sections,$fail_gracefully);
    }

    public function library($library = '', $params = NULL, $object_name = NULL)
    {
        $this->CI->load->library(CAMELOT_DRIVER_PATH.'library/'.$library,$params,$object_name);
    }

    public function model()
    {

    }

    public function language()
    {

    }
}