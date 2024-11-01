<?php
/**
 * The XcooBee_Document_Files class
 *
 * @package XcooBee/Document
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Upload and send files.
 *
 * @since 1.0.0
 */
class XcooBee_Document_Files {
	/**
	 * The constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_xbee_document_send', [ $this, 'send' ] );
		add_action( 'wp_ajax_nopriv_xbee_document_send', [ $this, 'send' ] );
		add_action( 'wp_ajax_xbee_document_upload', [ $this, 'upload' ] );
		add_action( 'wp_ajax_nopriv_xbee_document_upload', [ $this, 'upload' ] );
	}

	public function upload() {
		$xcoobee = XcooBee::get_xcoobee();

		// Recipient (recipient) XcooBee Id.
		$recipient = $xcoobee->users->getUser()->xcoobeeId;

		// Form data.
		parse_str( $_POST['data'], $data );

		// The parameters of takeOff().
		$bees = [
			$data['xbee_bee_name'] => [],
		];

		$parameters = [
			'process' => [
				'destinations' => [ $recipient ]
			],
		];

		// Only add files if the hired bee require file upload.
		if ( ! in_array( $data['xbee_bee_name'], xbee_get_bee_system_names( 'no_file_upload' ) ) ) {
			$parameters['process']['fileNames'] = $_POST['files'];
		}

		// Bee-specific parameters.
		if ( ! empty( $data['xbee_bee_params'] ) ) {
			// The xcoobee_message bee has a special structure.
			if ( 'xcoobee_message' === $data['xbee_bee_name'] ) {
				$bees['xcoobee_message'] = [
					'xcoobee_simple_message' => [ 'message' => $data['xbee_params']['message'] ],
					'recipient'              => [ 'xcoobee_id' => $recipient ]
				];
			} else {
				foreach( $data['xbee_bee_params'] as $name => $value ) {
					$bees[ $data['xbee_bee_name'] ][ $name ] = $value;
				}
			}
		}

		// Process parameters.
		if ( ! empty( $data['xbee_params'] ) ) {
			foreach( $data['xbee_params'] as $name => $value ) {
				// Skip 'message' param if the hired bee is xcoobee_message.
				if ( 'xcoobee_message' === $data['xbee_bee_name'] && 'message' === $name ) {
					continue;
				}

				$parameters['custom'][ $name ] = $value;
			}
		}

		if ( isset( $data['xbee_user_reference'] ) ) {
			$parameters['process']['userReference'] = $data['xbee_user_reference'];
		}

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

		// Send response, and die.
		wp_send_json( $result );
	}

	public function send() {
		$files = (array) $_POST['files'];

		try {
			$xcoobee_api = XcooBee::get_xcoobee_api();
			$response = $xcoobee_api->getUploadPolicy( $files );
		} catch ( Exception $e ) {
			$response = $e->getMessage();
		}

		wp_send_json( $response, 200 );
	}
}

new XcooBee_Document_Files;