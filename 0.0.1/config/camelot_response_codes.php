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

/**
 * Response codes 
 */

$config['Camelot_Response_Codes']['unknown_authentication_provider'] = '404';
$config['Camelot_Response_Codes']['unknown_authentication_driver'] = '404';
$config['Camelot_Response_Codes']['unknown_authentication_provider_function'] = '404';
$config['Camelot_Response_Codes']['function_not_supported'] = '404';
$config['Camelot_Response_Codes']['driver_file_missing'] = '404';
$config['Camelot_Response_Codes']['provider_file_missing'] = '404';
$config['Camelot_Response_Codes']['no_valid_class'] = '404';
$config['Camelot_Response_Codes']['oauth2_provider_file_missing'] = '404';
$config['Camelot_Response_Codes']['no_valid_provider_class'] = '404';