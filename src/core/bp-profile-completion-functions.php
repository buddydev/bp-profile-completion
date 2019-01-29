<?php
/**
 * Core functions file
 *
 * @package BP_Profile_Completion
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get setting
 *
 * @param string $setting Setting name.
 *
 * @return mixed
 */
function bpprocn_get_option( $setting ) {

	$settings = get_option( 'bpprocn_settings', bpprocn_get_default_options() );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : null;
}

/**
 * Get default options.
 *
 * @return array
 */
function bpprocn_get_default_options() {

	$defaults = array(
		'required_criteria'                  => array(
			'all_req_fields'    => 'all_req_fields',
			'req_profile_photo' => 'req_profile_photo',
			'req_profile_cover' => 'req_profile_cover',
		),
		'restrict_access_to_profile_only'    => 1,
		'show_profile_incomplete_message'    => 1,
		'required_fields_incomplete_message' => __( 'Please fill all required profile fields.', 'buddypress-profile-completion' ),
		'profile_photo_incomplete_message'   => __( 'Please upload your profile photo!', 'buddypress-profile-completion' ),
		'profile_cover_incomplete_message'   => __( 'Please upload your profile cover!', 'buddypress-profile-completion' ),
	);

	return $defaults;
}

/**
 * Check if all required fields is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprocn_is_required_fields_required() {
	$required_criteria = bpprocn_get_option( 'required_criteria' );

	return in_array( 'all_req_fields', (array) $required_criteria, true );
}

/**
 * Check if profile photo is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprocn_is_profile_photo_required() {
	$required_criteria = bpprocn_get_option( 'required_criteria' );

	return in_array( 'req_profile_photo', (array) $required_criteria, true );
}

/**
 * Check if profile cover is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprocn_is_profile_cover_required() {
	$required_criteria = bpprocn_get_option( 'required_criteria' );

	return in_array( 'req_profile_cover', (array) $required_criteria, true );
}

/**
 * Check if restrict access to profile only enabled or not.
 *
 * @return bool
 */
function bpprocn_is_profile_restriction_enabled() {
	return bpprocn_get_option( 'restrict_access_to_profile_only' );
}

/**
 * Check weather enable show profile message or not.
 *
 * @return bool
 */
function bpprocn_show_profile_incomplete_message() {
	return bpprocn_get_option( 'show_profile_incomplete_message' );
}

/**
 * Check if user has incomplete profile?
 *
 * @param int $user_id user id.
 *
 * @return bool
 */
function bpprocn_has_incomplete_profile( $user_id ) {

	if ( get_user_meta( $user_id, '_has_complete_profile', true ) ) {
		return false;
	}

	return true;
}
