<?php
/*
Plugin Name: API Fixer
Plugin URI:  http://joshuahackett.com
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







function facebook_add_user_data() {

  // Register a response field from the 'user' object, with a key of 'email', and some args
  register_rest_field( 'user', 'email', array(
          // Callback function to retrieve value of this field
          'get_callback'  => 'rest_get_user_field',
          // Value readable but not updatable
          'update_callback'   => null,
          'schema'            => null,
       )
  );
}
add_action( 'rest_api_init', 'facebook_add_user_data' );

function rest_get_user_field( $user, $field_name, $request ) {
    return get_user_meta( $user[ 'id' ], $field_name, true );
}
