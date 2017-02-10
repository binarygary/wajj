<?php
/**
 * WDS ACF JSON Juggler Automation
 *
 * @since   0.1.0
 * @package WDS ACF JSON Juggler
 */

/**
 * WDS ACF JSON Juggler Automation.
 *
 * @since 0.1.0
 */
class WDSACFJSONJ_Automation {
	/**
	 * Parent plugin class
	 *
	 * @var   WDS_ACF_JSON_Juggler
	 * @since 0.1.0
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 *
	 * @param  WDS_ACF_JSON_Juggler $plugin Main plugin object.
	 *
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'load_acf_json' ) );
		add_action( 'init', array( $this, 'modify_acf_cpts' ) );
	}

	/**
	 * Add revisions to the ACF CPTs.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function modify_acf_cpts() {
		add_post_type_support( 'acf-field-group', 'revisions' );
		add_post_type_support( 'acf-field', 'revisions' );
	}

	/**
	 * Ready, Aim... Load JSON!
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function load_acf_json() {

		$groups = acf_get_field_groups();

		// bail early if no field groups
		if ( empty( $groups ) ) {

			return;

		}

		// find JSON field groups which have not yet been imported
		foreach ( $groups as $group ) {

			// vars
			$local    = acf_maybe_get( $group, 'local', false );
			$modified = acf_maybe_get( $group, 'modified', 0 );
			$private  = acf_maybe_get( $group, 'private', false );

			// ignore DB / PHP / private field groups
			if ( $local !== 'json' || $private ) {

				// do nothing

			} elseif ( ! $group['ID'] ) {

				$sync[ $group['key'] ] = $group;

			} elseif ( $modified && $modified > get_post_modified_time( 'U', true, $group['ID'], true ) ) {

				$sync[ $group['key'] ] = $group;

			}

		}

		// bail if no sync needed
		if ( empty( $sync ) ) {

			return;

		}


		// disable JSON
		// - this prevents a new JSON file being created and causing a 'change' to theme files - solves git anoyance
		// acf_update_setting( 'json', false );

		foreach( $sync as $key => $v ) {

			// append fields
			if ( acf_have_local_fields( $key ) ) {

				$sync[ $key ]['fields'] = acf_get_local_fields( $key );

			}

			// import
			acf_import_field_group( $sync[ $key ] );

		}

	}

}
