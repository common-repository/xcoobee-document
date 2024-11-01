<?php
/**
 * General-purpose and helper functions
 *
 * @package XcooBee/Document
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Send files via XcooBee.
 *
 * @since 1.0.0
 *
 * @param string $recipient Recipient of the file. Could be a XcooBee Id or an email address.
 * @param string $file_path The absolute path of the file to be sent.
 * @return object Result object.
 */
function xbee_send_file( $recipient, $file_path ) {
	$xcoobee = XcooBee::get_xcoobee( true );
	$upload_files = $xcoobee->bees->uploadFiles( [ $file_path ] );

	if ( 200 === $upload_files->code ) {
		$bees = [ 'transfer' => [] ];
		$parameters = [ 'process' => [
			'fileNames'    => [ basename( $file_path ) ],
			'destinations' => [ $xcoobee->users->getUser()->xcoobeeId ]
		] ];

		$take_off = $xcoobee->bees->takeOff( $bees, $parameters );

		if ( 200 === $take_off->code ) {
			$result = ( object ) [
				'result' => true,
				'status' => 'success',
				'code'   => 'success_send_files',
				'errors' => [],
			];
		} else {
			$result = ( object ) [
				'result' => false,
				'status' => 'error',
				'code'   => 'error_send_files',
				'errors' => $take_off->errors,
			];
		}
	} else {
		$result = ( object ) [
			'result' => false,
			'status' => 'error',
			'code'   => 'error_upload_files',
			'errors' => $upload_files->errors,
		];
	}

	return $result;
}

/**
 * Returns bee system names.
 *
 * @since 1.3.0
 *
 * @param string Type of bees.
 * @return array Bee system names.
 */
function xbee_get_bee_system_names( $type = 'all' ) {
	$bees = [];

	// Bees that require file upload.
	if ( 'file_upload' === $type || 'all' === $type ) {
		$bees = array_merge( $bees, [
			'transfer',
			'xcoobee_send_contact_request',
			'xcoobee_dropbox_uploader',
			'xcoobee_google_drive_uploader',
			'xcoobee_image_resizer',
			'xcoobee_timestamp',
			'xcoobee_onedrive_uploader',
			'xcoobee_bee_watermark',
			'xcoobee_imgur',
			'bee-pdf-password',
			'bee-pdf-converter',
		] );
	}
	
	// Bees that do not require file upload.
	if ( 'no_file_upload' === $type || 'all' === $type ) {
		$bees = array_merge( $bees, [
			'xcoobee_message',
			'xcoobee_twitter',
			'xcoobee_send_contact',
		] );
	}
	
	return $bees;
}