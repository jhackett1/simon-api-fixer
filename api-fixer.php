<?php
/*
Plugin Name: Simon Says
Plugin URI:  http://github.com/jhackett1/simon-api-fixer
Description: Rejigs the output of the user API endpoint expose users who have not authored posts, to make the team gallery work
Version:     1
Author:      Joshua Hackett
Author URI:  http://joshuahackett.com
*/


// Display users with no posts
class UserFields {
 function __construct() {
  add_filter('rest_user_query',           [$this, 'show_all_users']);
 }
function show_all_users($prepared_args) {
    unset($prepared_args['has_published_posts']);
    return $prepared_args;
  }
}
new UserFields();

// Add the field to the right route
function jh_add_user_data() {

  // Register a response field from the 'user' object, with a key of 'email', and some args
  register_rest_field( 'user', 'jh_meta', array(
          // Callback function to retrieve value of this field
          'get_callback'  => 'rest_get_user_field',
          // Value readable but not updatable
          'update_callback'   => null,
          'schema'            => null,
       )
  );
}

// Do the thing
add_action( 'rest_api_init', 'jh_add_user_data' );


// Callback to populate field with data
function rest_get_user_field( $user, $field_name, $request ) {

  $pic_1 = xprofile_get_field_data(  'Primary gallery picture',  $user['id'],  'array' );
  $pic_2 = xprofile_get_field_data(  'Alternate gallery picture',  $user['id'],  'array' );
  $pic_fallback = bp_core_fetch_avatar ( array(
    'item_id' => $user['id'],
    'html'=>false,
    'type'=>'full' ) );

  return array(
      dept => get_user_meta($user['id'],'user_team',true)[0],
      roles => get_user_meta($user['id'],'simon_capabilities',true),
      job_title=> get_user_meta($user['id'],'user_job_title',true),
      phone => get_user_meta($user['id'],'user_telephone',true),
      email => get_userdata($user['id'])->user_email,
      twitter => get_user_meta($user['id'],'user_twitter_handle',true),
      primary_picture => $pic_1,
      alt_picture => $pic_2,
      fallback_picture => $pic_fallback
  );

}
