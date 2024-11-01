<?php
/**
 * The XcooBee_Document_Admin class
 *
 * @package XcooBee/Document/Admin
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generates the options page.
 *
 * @since 1.0.0
 */
class XcooBee_Document_Admin {
	/**
	 * The constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_page' ] );
		add_action( 'admin_init', [ $this, 'settings' ] );
		add_action( 'wp_ajax_xbee_get_bees', [ $this, 'get_bees' ] );
	}

	/**
	 * Registers option page.
	 *
	 * @since 1.0.0
	 */
	public function add_page() {
		add_submenu_page(
			'xcoobee',
			__( 'Document', 'xcoobee' ),
			__( 'Document', 'xcoobee' ),
			'manage_options',
			'admin.php?page=xcoobee&tab=document'
		);
	}

	public function settings() {
		// Document settings.
		register_setting( 'xbee_document', 'xbee_document_dropzone_base_font_size' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_base_font_size_unit' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_border_radius' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_border_radius_unit' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_text_color' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_secondary_color' );
		register_setting( 'xbee_document', 'xbee_document_dropzone_primary_color' );
	}

	public function get_bees() {
		try {
			$xcoobee = XcooBee::get_xcoobee( true );
			$bees = $xcoobee->bees->listBees();

			if ( 200 === $bees->code ) {
				$result = ( object ) [
					'result' => $bees->result->bees->data,
					'status' => 'success',
					'code'   => 'success_get_bees',
					'errors' => [],
				];
			} else {
				$result = ( object ) [
					'result' => false,
					'status' => 'error',
					'code'   => 'error_get_bees',
					'errors' => [ xbee_get_text( 'message_error_get_bees' ) ],
				];
			}
		} catch( Exception $e ) {
			$result = ( object ) [
				'result' => false,
				'status' => 'error',
				'code'   => 'error_get_bees',
				'errors' => [ $e->getMessage() ],
			];
		}

		// Send response, and die.
		echo json_encode( $result );
		wp_die();
	}
}

new XcooBee_Document_Admin;