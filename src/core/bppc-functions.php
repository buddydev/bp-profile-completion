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
function bpprofilec_get_option( $setting = '' ) {

	$default  = bpprofilec_get_default_options();
	$settings = get_option( 'bppc_settings' );

	if ( isset( $settings[ $setting ] ) ) {
		return $settings[ $setting ];
	} elseif ( isset( $default[ $setting ] ) ) {
		return $default[ $setting ];
	}

	return false;
}

/**
 * Get default options.
 *
 * @return array
 */
function bpprofilec_get_default_options() {

	$defaults = array(
		'required_criteria'                  => array(
			'all_req_fields'    => 'all_req_fields',
			'req_profile_photo' => 'req_profile_photo',
			'req_profile_cover' => 'req_profile_cover',
		),
		'restrict_access_to_profile_only'    => 1,
		'show_profile_incomplete_message'    => 1,
		'required_fields_incomplete_message' => __( 'Please fill all required profile fields.', 'bp-profile-completion' ),
		'profile_photo_incomplete_message'   => __( 'Please upload your profile photo!', 'bp-profile-completion' ),
		'profile_cover_incomplete_message'   => __( 'Please upload your profile cover!', 'bp-profile-completion' ),
	);

	return $defaults;
}

/**
 * Check if all required fields is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprofilec_is_required_fields_mandatory() {
	$required_criteria = bpprofilec_get_option( 'required_criteria' );

	return in_array( 'all_req_fields', (array) $required_criteria );
}

/**
 * Check if profile photo is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprofilec_is_profile_photo_mandatory() {
	$required_criteria = bpprofilec_get_option( 'required_criteria' );

	return in_array( 'req_profile_photo', (array) $required_criteria );
}

/**
 * Check if profile cover is mandatory or not for profile completion.
 *
 * @return bool
 */
function bpprofilec_is_profile_cover_mandatory() {
	$required_criteria = bpprofilec_get_option( 'required_criteria' );

	return in_array( 'req_profile_cover', (array) $required_criteria );
}

/**
 * Check if restrict access to profile only enabled or not.
 *
 * @return bool
 */
function bpprofilec_is_enable_profile_only_restriction() {
	return bpprofilec_get_option( 'restrict_access_to_profile_only' );
}

/**
 * Check weather enable show profile message or not.
 *
 * @return bool
 */
function bpprofile_is_enable_show_profile_incomplete_message() {
	return bpprofilec_get_option( 'show_profile_incomplete_message' );
}