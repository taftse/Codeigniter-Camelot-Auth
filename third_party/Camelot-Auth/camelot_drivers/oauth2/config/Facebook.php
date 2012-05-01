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

$config['Oauth2_Force_Approval'] = FALSE;

$config['Oauth2_Grant_Type'] = '';

//Provides access to the "About Me" section of the profile in the about property
$config['Facebook_Permissions']['user_about_me'] = FALSE;
//Provides access to the user's list of activities as the activities connection
$config['Facebook_Permissions']['user_activities'] = FALSE;
$config['Facebook_Permissions']['user_birthday'] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
//Provides access to Friends "About Me" section of the profile in the about property
$config['Facebook_Permissions']['friends_about_me'] = FALSE;
//Provides access to the user's list of activities as the activities connection
$config['Facebook_Permissions']['friends_activities'] = FALSE;
$config['Facebook_Permissions']['user_birthday'] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;
$config['Facebook_Permissions'][] = FALSE;

		
		
	friends_birthday	Provides access to the birthday with year as the birthday property
user_checkins	friends_checkins	Provides read access to the authorized user's check-ins or a friend's check-ins that the user can see. This permission is superseded by user_status for new applications as of March, 2012.
user_education_history	friends_education_history	Provides access to education history as the education property
user_events	friends_events	Provides access to the list of events the user is attending as the events connection
user_groups	friends_groups	Provides access to the list of groups the user is a member of as the groups connection
user_hometown	friends_hometown	Provides access to the user's hometown in the hometown property
user_interests	friends_interests	Provides access to the user's list of interests as the interests connection
user_likes	friends_likes	Provides access to the list of all of the pages the user has liked as the likes connection
user_location	friends_location	Provides access to the user's current location as the location property
user_notes	friends_notes	Provides access to the user's notes as the notes connection
user_photos	friends_photos	Provides access to the photos the user has uploaded, and photos the user has been tagged in
user_questions	friends_questions	Provides access to the questions the user or friend has asked
user_relationships	friends_relationships	Provides access to the user's family and personal relationships and relationship status
user_relationship_details	friends_relationship_details	Provides access to the user's relationship preferences
user_religion_politics	friends_religion_politics	Provides access to the user's religious and political affiliations
user_status	friends_status	Provides access to the user's status messages and checkins. Please see the documentation for the location_post table for information on how this permission may affect retrieval of information about the locations associated with posts.
user_videos	friends_videos	Provides access to the videos the user has uploaded, and videos the user has been tagged in
user_website	friends_website	Provides access to the user's web site URL
user_work_history	friends_work_history	Provides access to work history as the work property
email	N/A	Provides access to the user's primary email address in the email property. Do not spam users. Your use of email must comply both with Facebook policies and with the CAN-SPAM Act.