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


$config['Oauth2_Client_ID'] = '';
$config['Oauth2_Client_Secret'] = '';
$config['Oauth2_Callback_URL_Override'] = '';
$config['Oauth2_Authorize_URL'] = '';
$config['Oauth2_Access_Token_URL'] = '';
$config['Oauth2_Endpoint'] = '';
/*
* does the provider support CSRF Protection 
* Assume Not unless stated otherwhise 
*/
$config['Oauth2_CSRF_Supported'] = FALSE;

