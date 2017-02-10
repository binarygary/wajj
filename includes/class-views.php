<?php
/**
 * WDS ACF JSON Juggler Views
 *
 * @since   0.1.0
 * @package WDS ACF JSON Juggler
 */

/**
 * WDS ACF JSON Juggler Views.
 *
 * @since 0.1.0
 */
class WDSACFJSONJ_Views {
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
		add_action( 'add_meta_boxes', array( $this, 'add_revisions_box' ) );
	}

	/**
	 * Add a metabox with ACF revisions.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function add_revisions_box() {
		// @TODO Need to check if the meta exists, not if it has revisions.
		if ( key_exists( 'post', $_GET ) && isset( $_GET['post'] ) ) {
			add_meta_box( 'wajj_revisions', __( 'Deleted Fields', 'wajj' ), array( $this, 'display_deleted_fields' ), array( 'acf-field-group', 'acf-field' ), 'side' );
		}
	}

	/**
	 * Check if this post has revisions.
	 *
	 * @param $id integer
	 *
	 * @return bool
	 */
	private function has_revisions( $id ) {
		if ( count( wp_get_post_revisions( $id ) ) > 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * Populate the new metabox.
	 *
	 * @since 0.1.0
	 */
	public function display_deleted_fields() {
		$id = (int) $_GET['post'];

		$fieldgroup = get_post_meta( $id, 'wajj', 1 );

		$args  = array(
			'post_parent' => $id,
			'posts_per_page' => -1,
			'post_type'=> 'acf-field',
			'post_status'=> 'any',
		);
		$query = new WP_Query( $args );

		$post_names=array();
		foreach ($query->posts as $post){
			$post_names[]=$post->post_name;
		}

		error_log(print_r($post_names,1));



		foreach ( $fieldgroup['fields'] as $field ) {
			if (!in_array($field['key'], $post_names)) {
				print_r($field);
				echo "<HR>";
			}
		}

	}

	/**
	 * Display missing field.
	 *
	 * @since 0.1.0
	 */
	private function display_field( $field ) {
		print_r( $field );
		echo "<HR>";
	}
}
