<?php
/**
 * Admin Settings Pages Helper.
 *
 * @package    BP_Profile_Completion
 * @subpackage Admin
 * @copyright  Copyright (c) 2018, BuddyDev.Com
 * @license    https://www.gnu.org/licenses/gpl.html GNU Public License
 * @author     Ravi Sharma, Brajesh Singh
 * @since      1.0.0
 */

namespace BP_Profile_Completion\Admin;

use \Press_Themes\PT_Settings\Page;

// Exit if file accessed directly over web.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Settings
 */
class Admin_Settings {

	/**
	 * Admin Menu slug
	 *
	 * @var string
	 */
	private $menu_slug;

	/**
	 * Used to keep a reference of the Page, It will be used in rendering the view.
	 *
	 * @var \Press_Themes\PT_Settings\Page
	 */
	private $page;

	/**
	 * Boot settings
	 */
	public static function boot() {
		$self = new self();
		$self->setup();
	}

	/**
	 * Setup settings
	 */
	public function setup() {

		$this->menu_slug = 'bp-profile-completion';

		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	/**
	 * Show/render the setting page
	 */
	public function render() {
		$this->page->render();
	}

	/**
	 * Is it the setting page?
	 *
	 * @return bool
	 */
	private function needs_loading() {

		global $pagenow;

		// We need to load on options.php otherwise settings won't be reistered.
		if ( 'options.php' === $pagenow ) {
			return true;
		}

		if ( isset( $_GET['page'] ) && $_GET['page'] === $this->menu_slug ) {
			return true;
		}

		return false;
	}

	/**
	 * Initialize the admin settings panel and fields
	 */
	public function init() {

		if ( ! $this->needs_loading() ) {
			return;
		}

		$page = new Page( 'bppc_settings', __( 'BuddyPress Profile Completion', 'bp-profile-completion' ) );

		// General settings tab.
		$panel = $page->add_panel( 'settings', _x( 'Settings', 'Admin settings panel title', 'bp-profile-completion' ) );

		$required_criteria = $panel->add_section( 'required_criteria', _x( 'Required criteria for profile completion', 'Admin settings section title', 'bp-profile-completion' ) );

		$defaults = bpprofilec_get_default_options();

		$required_criteria->add_field( array(
			'name'    => 'required_criteria',
			'label'   => _x( 'Required criteria', 'Admin settings', 'bp-profile-completion' ),
			'type'    => 'multicheck',
			'options' => array(
				'all_req_fields'    => __( 'Must fill all required fields', 'bp-profile-completion' ),
				'req_profile_photo' => __( 'Must have profile photo', 'bp-profile-completion' ),
				'req_profile_cover' => __( 'Must have profile cover', 'bp-profile-completion' ),
			),
			'default' => $defaults['required_criteria'],
			'desc'    => __( 'User will need to fill all the selected criteria for profile completion', 'bp-profile-completion' ),
		) );

		$profile_actions = $panel->add_section( 'incomplete_profile_actions', _x( 'Profile incomplete actions', 'Admin settings section title', 'bp-profile-completion' ) );

		$fields = array(
			array(
				'name'    => 'restrict_access_to_profile_only',
				'label'   => _x( 'Restrict to profile only', 'Admin settings', 'bp-profile-completion' ),
				'type'    => 'radio',
				'options' => array(
					1 => __( 'Yes', 'bp-profile-completion' ),
					0 => __( 'No', 'bp-profile-completion' ),
				),
				'default' => $defaults['restrict_access_to_profile_only'],
			),
			array(
				'name'    => 'show_profile_incomplete_message',
				'label'   => _x( 'Show profile incomplete message', 'Admin settings', 'bp-profile-completion' ),
				'type'    => 'radio',
				'options' => array(
					1 => __( 'Yes', 'bp-profile-completion' ),
					0 => __( 'No', 'bp-profile-completion' ),
				),
				'default' => $defaults['show_profile_incomplete_message'],
			),
			array(
				'name'    => 'required_fields_incomplete_message',
				'label'   => _x( 'Required field incomplete message', 'Admin settings', 'bp-profile-completion' ),
				'type'    => 'text',
				'default' => $defaults['required_fields_incomplete_message'],
			),
			array(
				'name'    => 'profile_photo_incomplete_message',
				'label'   => _x( 'Profile photo incomplete message', 'Admin settings', 'bp-profile-completion' ),
				'type'    => 'text',
				'default' => $defaults['profile_photo_incomplete_message'],
			),
			array(
				'name'    => 'profile_cover_incomplete_message',
				'label'   => _x( 'Profile cover incomplete message', 'Admin settings', 'bp-profile-completion' ),
				'type'    => 'text',
				'default' => $defaults['profile_cover_incomplete_message'],
			),
		);

		$profile_actions->add_fields( $fields );

		$this->page = $page;

		// allow enabling options.
		$page->init();
	}

	/**
	 * Add Menu
	 */
	public function add_menu() {

		add_options_page(
			_x( 'BuddyPress Profile Completion', 'Admin settings page title', 'bp-profile-completion' ),
			_x( 'BuddyPress Profile Completion', 'Admin settings menu label', 'bp-profile-completion' ),
			'manage_options',
			$this->menu_slug,
			array( $this, 'render' )
		);
	}
}
