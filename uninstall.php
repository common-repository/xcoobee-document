<?php
/**
 * Uninstall actions
 *
 * Remove plugin settings from the database.
 *
 * @package XcooBee/Document
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if uninstall not called from WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 * Only remove plugin data if the XBEE_REMOVE_ALL_DATA constant is set to true in
 * user's wp-config.php. This is to prevent data loss when deleting the plugin from
 * the backend and to ensure only the site owner can perform this action.
 */
if ( defined( 'XBEE_REMOVE_ALL_DATA' ) && true === XBEE_REMOVE_ALL_DATA ) {
	// Delete plugin options.
	delete_option( 'xbee_document_dropzone_text_color' );
	delete_option( 'xbee_document_dropzone_secondary_color' );
	delete_option( 'xbee_document_dropzone_primary_color' );
	delete_option( 'xbee_document_dropzone_base_font_size' );
	delete_option( 'xbee_document_dropzone_base_font_size_unit' );
}