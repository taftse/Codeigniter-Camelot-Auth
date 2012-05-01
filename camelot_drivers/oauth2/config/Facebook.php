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
//Provides access to the birthday with year as the birthday property
$config['Facebook_Permissions']['user_birthday'] = FALSE;
//Provides read access to the authorized user's check-ins or a friend's check-ins that the user can see. This permission is superseded by user_status for new applications as of March, 2012.
$config['Facebook_Permissions']['user_checkins'] = FALSE;
//Provides access to education history as the education property
$config['Facebook_Permissions']['user_education_history'] = FALSE;
// /Provides access to the list of events the user is attending as the events connection
$config['Facebook_Permissions']['user_events'] = FALSE;
//Provides access to the list of groups the user is a member of as the groups connection
$config['Facebook_Permissions']['user_groups'] = FALSE;
//Provides access to the user's hometown in the hometown property
$config['Facebook_Permissions']['user_hometown'] = FALSE;
//Provides access to the user's list of interests as the interests connection
$config['Facebook_Permissions']['user_interests'] = FALSE;
//Provides access to the list of all of the pages the user has liked as the likes connection
$config['Facebook_Permissions']['user_likes'] = FALSE;
//Provides access to the user's current location as the location property
$config['Facebook_Permissions']['user_location'] = FALSE;
//Provides access to the user's notes as the notes connection
$config['Facebook_Permissions']['user_notes'] = FALSE;
//Provides access to the photos the user has uploaded, and photos the user has been tagged in
$config['Facebook_Permissions']['user_photos'] = FALSE;
//Provides access to the questions the user or friend has asked
$config['Facebook_Permissions']['user_questions'] = FALSE;
//Provides access to the user's family and personal relationships and relationship status
$config['Facebook_Permissions']['user_relationships'] = FALSE;
// Provides access to the user's relationship preferences
$config['Facebook_Permissions']['user_relationship_details'] = FALSE;
//Provides access to the user's religious and political affiliations
$config['Facebook_Permissions']['user_religion_politics'] = FALSE;
//Provides access to the user's status messages and checkins. Please see the documentation for the location_post table for information on how this permission may affect retrieval of information about the locations associated with posts.
$config['Facebook_Permissions']['user_status'] = FALSE;
//Provides access to the videos the user has uploaded, and videos the user has been tagged in
$config['Facebook_Permissions']['user_videos'] = FALSE;
//Provides access to the user's web site URL
$config['Facebook_Permissions']['user_website'] = FALSE;
//Provides access to work history as the work property
$config['Facebook_Permissions']['user_work_history'] = FALSE;



//Provides access to Friends "About Me" section of the profile in the about property
$config['Facebook_Permissions']['friends_about_me'] = FALSE;
//Provides access to the user's list of activities as the activities connection
$config['Facebook_Permissions']['friends_activities'] = FALSE;
//Provides access to the birthday with year as the birthday property
$config['Facebook_Permissions']['friends_birthday'] = FALSE;
//Provides read access to the authorized user's check-ins or a friend's check-ins that the user can see. This permission is superseded by user_status for new applications as of March, 2012.
$config['Facebook_Permissions']['friends_checkins'] = FALSE;
//Provides access to education history as the education property
$config['Facebook_Permissions']['friends_education_history'] = FALSE;
//Provides access to the list of events the user is attending as the events connection
$config['Facebook_Permissions']['friends_events'] = FALSE;
//Provides access to the list of groups the user is a member of as the groups connection
$config['Facebook_Permissions']['friends_groups'] = FALSE;
//Provides access to the user's hometown in the hometown property
$config['Facebook_Permissions']['friends_hometown'] = FALSE;
//Provides access to the user's list of interests as the interests connection
$config['Facebook_Permissions']['friends_interests'] = FALSE;
//Provides access to the list of all of the pages the user has liked as the likes connection
$config['Facebook_Permissions']['friends_likes'] = FALSE;
//Provides access to the user's current location as the location property
$config['Facebook_Permissions']['friends_location'] = FALSE;
//Provides access to the user's notes as the notes connection
$config['Facebook_Permissions']['friends_notes'] = FALSE;
//Provides access to the photos the user has uploaded, and photos the user has been tagged in
$config['Facebook_Permissions']['friends_photos'] = FALSE;
//Provides access to the questions the user or friend has asked
$config['Facebook_Permissions']['friends_questions'] = FALSE;
//Provides access to the user's family and personal relationships and relationship status
$config['Facebook_Permissions']['friends_relationships'] = FALSE;
// Provides access to the user's relationship preferences
$config['Facebook_Permissions']['friends_relationship_details'] = FALSE;
//Provides access to the user's religious and political affiliations
$config['Facebook_Permissions']['friends_religion_politics'] = FALSE;
//Provides access to the user's status messages and checkins. Please see the documentation for the location_post table for information on how this permission may affect retrieval of information about the locations associated with posts.
$config['Facebook_Permissions']['friends_status'] = FALSE;
//Provides access to the videos the user has uploaded, and videos the user has been tagged in
$config['Facebook_Permissions']['friends_videos'] = FALSE;
//Provides access to the user's web site URL
$config['Facebook_Permissions']['friends_website'] = FALSE;
//Provides access to work history as the work property
$config['Facebook_Permissions']['friends_work_history'] = FALSE;

//N/A	Provides access to the user's primary email address in the email property. Do not spam users. Your use of email must comply both with Facebook policies and with the CAN-SPAM Act.
$config['Facebook_Permissions']['email'] = FALSE;		