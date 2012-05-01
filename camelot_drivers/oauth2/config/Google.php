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
$config['Oauth2_Callback_URL_Override'] = "";
$config['Oauth2_Authorize_URL'] = 'https://accounts.google.com/o/oauth2/auth';
$config['Oauth2_Access_Token_URL'] = 'https://accounts.google.com/o/oauth2/token';
$config['Oauth2_Endpoint'] = 'https://www.googleapis.com/oauth2/v1/userinfo';
/*
* does the provider support CSRF Protection 
* Assume Not unless stated otherwhise 
*/
$config['Oauth2_CSRF_Supported'] = FALSE;

$config['Oauth2_Force_Approval'] = FALSE;

$config['Oauth2_Grant_Type'] = '';


/**
* for more infomation on google premissions check out 
* https://code.google.com/oauthplayground/
*/

// Userinfo - Email
$config['Google_Permissions']['https://www.googleapis.com/auth/userinfo.email'] = TRUE;
// Userinfo - Profile
$config['Google_Permissions']['https://www.googleapis.com/auth/userinfo.profile'] = TRUE;

// Adsense Management
$config['Google_Permissions']['https://www.googleapis.com/auth/adsense'] = FALSE;
// Google Affiliate Network
$config['Google_Permissions']['https://www.googleapis.com/auth/gan'] = FALSE;
// Analytics
$config['Google_Permissions']['https://www.googleapis.com/auth/analytics.readonly'] = FALSE;
// Google Books
$config['Google_Permissions']['https://www.googleapis.com/auth/books'] = FALSE;
// Blogger
$config['Google_Permissions']['https://www.googleapis.com/auth/blogger'] = FALSE;
// Calendar
$config['Google_Permissions']['https://www.googleapis.com/auth/calendar'] = FALSE;
// Google Cloud Storage
$config['Google_Permissions']['https://www.googleapis.com/auth/devstorage.read_write'] = FALSE;
// Contacts
$config['Google_Permissions']['https://www.google.com/m8/feeds/'] = FALSE;
// Content API for Shopping
$config['Google_Permissions']['https://www.googleapis.com/auth/structuredcontent'] = FALSE;
// Chrome Web Store
$config['Google_Permissions']['https://www.googleapis.com/auth/chromewebstore.readonly'] = FALSE;
// Documents List
$config['Google_Permissions']['https://docs.google.com/feeds/'] = FALSE;
// Google Drive
$config['Google_Permissions']['https://www.googleapis.com/auth/drive.file'] = FALSE;
// Gmail
$config['Google_Permissions']['https://mail.google.com/mail/feed/atom'] = FALSE;
// Google+
$config['Google_Permissions']['https://www.googleapis.com/auth/plus.me'] = FALSE;
// Groups Provisioning
$config['Google_Permissions']['https://apps-apis.google.com/a/feeds/groups/'] = FALSE;
// Google Latitude
$config['Google_Permissions']['https://www.googleapis.com/auth/latitude.all.best'] = FALSE;
$config['Google_Permissions']['https://www.googleapis.com/auth/latitude.all.city'] = FALSE;
// Moderator
$config['Google_Permissions']['https://www.googleapis.com/auth/moderator'] = FALSE;
// Nicknames Provisioning
$config['Google_Permissions']['https://apps-apis.google.com/a/feeds/alias/'] = FALSE;
// Orkut
$config['Google_Permissions']['https://www.googleapis.com/auth/orkut '] = FALSE;
// Picasa Web
$config['Google_Permissions']['https://picasaweb.google.com/data/'] = FALSE;
// Sites
$config['Google_Permissions']['https://sites.google.com/feeds/'] = FALSE;
// Spreadsheets
$config['Google_Permissions']['https://spreadsheets.google.com/feeds/'] = FALSE;
// Tasks
$config['Google_Permissions']['https://www.googleapis.com/auth/tasks'] = FALSE;
// URL Shortener
$config['Google_Permissions']['https://www.googleapis.com/auth/urlshortener'] = FALSE;
// User Provisioning
$config['Google_Permissions']['https://apps-apis.google.com/a/feeds/user/'] = FALSE;
// Webmaster Tools
$config['Google_Permissions']['https://www.google.com/webmasters/tools/feeds/'] = FALSE;
// YouTube
$config['Google_Permissions']['https://gdata.youtube.com'] = FALSE;


