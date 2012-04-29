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
 * supported and active drivers
 */
$config['Authentication_Drivers']['oauth2'] = TRUE;
$config['Authentication_Drivers']['oauth1'] = TRUE;
$config['Authentication_Drivers']['saml2'] = TRUE;
$config['Authentication_Drivers']['ldap'] = TRUE;
$config['Authentication_Drivers']['local'] = TRUE;
$config['Authentication_Drivers']['openid'] = TRUE;



/**
*	
* if no provider is specified should the driver try to detect the driver to use ?
* TRUE = yes
* FALSE = no
*/
$config['Authentication_Provider_Detect'] = TRUE;

/*
*
*/
$config['Authentication_Provider_Uri_Segment'] = 3;
/**
 * please specify the default driver to use if
 * Authentication_Driver_Detect is set to FALSE or if the system cannot detect what driver to use?
 */
$config['Authentication_Provider_Default'] = 'Local';

/**
 *  info For routing Provider requests to the correct drivers
 *  will only be used when calling the detect driver function 
 */
$config['Authentication_Providers']['Local'] = array('Driver' => 'local');
$config['Authentication_Providers']['Google'] = array('Driver' => 'oauth2');
$config['Authentication_Providers']['Facebook'] = array('Driver' => 'oauth2');
$config['Authentication_Providers']['Github'] = array('Driver' => 'oauth2');
$config['Authentication_Providers']['Twitter'] = array('Driver' => 'oauth1');
$config['Authentication_Providers']['Foursquare'] = array('Driver' => 'oauth2');
$config['Authentication_Providers']['Edugate'] = array('Driver' => 'saml2');
$config['Authentication_Providers']['Youtube'] = array('Driver' => 'oauth2');

/**
 *  Should Camelot-Auth Force the use of https ? True = yes, False = no 
 */
$config['Authentication_force_secure_connection'] = TRUE;


/**
 * the expected segment where the provider can be found
 */

$config['Authentication_Default_Segment'] = 3;
/**
 * force the use of the default Provider if no other provider is specified ?
 */

$config['Authentication_Use_Default_Provider'] = FALSE;

// The uri to the login page 
$config['Authentication_Login_Uri'] = 'account/login';