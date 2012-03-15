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


$config['Oauth_Client_ID'] = '';
$config['Oauth_Client_Secret'] = '';
$config['Oauth_Callback_URL_Override'] = '';
$config['Oauth_Authorize_URL'] = '';
$config['Oauth_Access_Token_URL'] = '';
$config['Oauth_Endpoint'] = '';
/*
* does the provider support CSRF Protection 
* Assume Not unless stated otherwhise 
*/
$config['Oauth_CSRF_Supported'] = FALSE;

/**
*	The protocol used to encode The access token 
* 	supported encripsion methouds are JSON and NONE
*
*/
$config['Oauth_Authentication_Protocol'] = 'NONE';