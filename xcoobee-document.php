<?php
/**
 * Plugin Name: XcooBee Document
 * Plugin URI:  https://wordpress.org/plugins/xcoobee-document/
 * Author URI:  https://www.xcoobee.com/
 * Description: Send small and very large files securely through the XcooBee network to any destination including dropbox and google drive.
 * Version:     1.3.3
 * Author:      XcooBee
 * License:     GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Text Domain: xcoobee
 * Domain Path: /languages
 *
 * Requires at least: 4.4.0
 * Tested up to: 5.2.2
 *
 * @package XcooBee/Document
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Globals constants.
 */
define( 'XBEE_DOCUMENT_ABSPATH', plugin_dir_path( __FILE__ ) ); // With trailing slash.
define( 'XBEE_DOCUMENT_DIR_URL', plugin_dir_url( __FILE__ ) );  // With trailing slash.
define( 'XBEE_DOCUMENT_PLUGIN_BASENAME', plugin_basename(__FILE__) );

/**
 * The main class.
 *
 * @since 1.0.0
 */
class XcooBee_Document {
	/**
	 * The singleton instance of XcooBee_Document.
	 *
	 * @since 1.0.0
	 * @var XcooBee_Document
	 */
	private static $instance = null;

	/**
	 * Returns the singleton instance of XcooBee_Document.
	 *
	 * Ensures only one instance of XcooBee_Document is/can be loaded.
	 *
	 * @since 1.0.0
	 * @return XcooBee_Document
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * The constructor.
	 *
	 * Private constructor to make sure it cannot be called directly from outside the class.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Exit if XcooBee for WordPress is not installed and active.
		if ( ! in_array( 'xcoobee/xcoobee.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'admin_notices', array( $this, 'xcoobee_missing_notice' ) );
			return;
		}

		// Register text strings.
		add_filter( 'xbee_text_strings', [ $this, 'register_text_strings' ], 10, 1 );

		// Include required files.
		$this->includes();

		// Register hooks.
		$this->hooks();

		/**
		 * Fires after the plugin is completely loaded.
		 *
		 * @since 1.0.0
		 */
		do_action( 'xcoobee_document_loaded' );
	}

	/**
	 * XcooBee fallback notice.
	 *
	 * @since 1.0.0
	 */
	public function xcoobee_missing_notice() {
		echo '<div class="notice notice-warning"><p><strong>' . sprintf( esc_html__( 'XcooBee Cookie requires XcooBee for WordPress to be installed and active. You can download %s here.', 'xcoobee' ), '<a href="https://wordpress.org/plugins/xcoobee" target="_blank">XcooBee for WordPress</a>' ) . '</strong></p></div>';
	}

	/**
	 * Includes plugin files.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		// Global includes.
		include_once XBEE_DOCUMENT_ABSPATH . 'includes/functions.php';
		include_once XBEE_DOCUMENT_ABSPATH . 'includes/class-xcoobee-document-shortcodes.php';
		include_once XBEE_DOCUMENT_ABSPATH . 'includes/class-xcoobee-document-files.php';

		// Back-end includes.
		if ( is_admin() ) {
			include_once XBEE_DOCUMENT_ABSPATH . 'includes/admin/class-xcoobee-document-admin.php';
		}
		
		// Front-end includes.
		if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
			// Nothing to include for now.
		}
	}

	/**
	 * Plugin hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		add_filter( 'plugin_action_links_' . XBEE_DOCUMENT_PLUGIN_BASENAME, [ $this, 'action_links' ], 10, 1 );
		add_action( 'admin_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );
	}

	/**
	 * Adds plugin action links.
	 *
	 * @since 1.2.0
	 */
	public function action_links( $links ) {
		$action_links = [
			'settings' => '<a href="' . admin_url( 'admin.php?page=xcoobee&tab=document' ) . '" aria-label="' . esc_attr__( 'View XcooBee Document settings', 'xcoobee' ) . '">' . esc_html__( 'Settings', 'xcoobee' ) . '</a>',
		];

		return array_merge( $action_links, $links );
	}

	/**
	 * Loads plugin scripts.
	 *
	 * @since 1.0.0
	 */
	public function scripts() {
		// Back-end scripts.
		if ( 'admin_enqueue_scripts' === current_action() ) {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'xbee-document-admin-scripts', XBEE_DOCUMENT_DIR_URL . 'assets/dist/js/admin/scripts.min.js', [ 'jquery', 'xbee-admin-scripts' ], null, true );
			wp_localize_script( 'xbee-document-admin-scripts', 'xbeeDocumentAdminParams', [
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'text'     => [
					'beeName'        => __( 'Bee', 'xcoobee' ),
					'beeSystemName'  => __( 'Bee System Name', 'xcoobee' ),
					'beeDescription' => __( 'Bee Description', 'xcoobee' ),
				],
				'messages' => [
					'errorFindBees'       => xbee_get_text( 'message_error_find_bees' ),
					'errorFindBeesNoBees' => xbee_get_text( 'message_error_find_bees_no_bees' ),
				],
			] );
		}
		// Front-end scripts.
		else {
			wp_enqueue_script( 'dropzonejs', XBEE_DOCUMENT_DIR_URL . 'assets/dist/vendor/dropzone/dropzone.min.js', [ 'jquery' ], null, false );
			wp_enqueue_script( 'xbee-document-scripts', XBEE_DOCUMENT_DIR_URL . 'assets/dist/js/scripts.min.js', [ 'jquery' ], null, false );
			wp_localize_script( 'xbee-document-scripts', 'xbeeDocumentParams', [
				'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
				'siteUrl'          => site_url(),
				'miniLoginUrl'     => 'test' === xbee_get_env() ? 'https://testapp.xcoobee.net/auth/minlogin?targetUrl=' . urlencode( site_url() ) : 'https://app.xcoobee.net/auth/minlogin?targetUrl=' . urlencode( site_url() ),
				'env'              => xbee_get_env(),
				'borderRadius'     => get_option( 'xbee_document_dropzone_border_radius', 0 ),
				'borderRadiusUnit' => get_option( 'xbee_document_dropzone_border_radius_unit', '' ),
				'primaryColor'     => get_option( 'xbee_document_dropzone_primary_color', '#3fcb78' ),
				'secondaryColor'   => get_option( 'xbee_document_dropzone_secondary_color', '#d1eedd' ),
				'images'           => [
					'iconDelete'  => XBEE_DOCUMENT_DIR_URL . 'assets/dist/images/icon-delete.svg',
					'iconError'   => XBEE_DIR_URL . 'assets/dist/images/icon-error.svg',
					'iconXcooBee' => XBEE_DIR_URL . 'assets/dist/images/icon-xcoobee.svg',
					'loader'      => XBEE_DIR_URL . 'assets/dist/images/loader.svg',
				],
				'messages'     => [
					'errorAcceptedFileExtensions' => xbee_get_text( 'message_error_accepted_file_extensions' ),
					'errorSendFiles'              => xbee_get_text( 'message_error_send_files' ),
					'errorSendNoFiles'            => xbee_get_text( 'message_error_send_no_files' ),
				]
			] );
		}
	}

	/**
	 * Loads plugin styles.
	 *
	 * @since 1.0.0
	 */
	public function styles() {
		// Back-end styles.
		if ( 'admin_enqueue_scripts' === current_action() ) {
			wp_enqueue_style( 'xbee-document-admin-styles', XBEE_DOCUMENT_DIR_URL . 'assets/dist/css/admin/main.min.css', [], false, 'all' );
		}
		// Front-end styles.
		else {
			wp_enqueue_style( 'dropzonejs-basic', XBEE_DOCUMENT_DIR_URL . 'assets/dist/vendor/dropzone/basic.min.css', [], false, 'all' );
			wp_enqueue_style( 'dropzonejs', XBEE_DOCUMENT_DIR_URL . 'assets/dist/vendor/dropzone/dropzone.min.css', [], false, 'all' );	
			wp_enqueue_style( 'xbee-document-styles', XBEE_DOCUMENT_DIR_URL . 'assets/dist/css/main.min.css', [], false, 'all' );
		}
	}

	/**
	 * Defines and registers text strings.
	 *
	 * Use `url_name_of_the_url` for URL keys and `message_type_the_message` for message keys.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $strings Text strings array.
	 * @return array The updated text strings array.
	 */
	public function register_text_strings( $strings ) {
		return array_merge( $strings, [
			// Messages.
			'message_success_send_files'             => __( 'All done, you are good to go. We are sending your files securely.', 'xcoobee' ),
			'message_error_send_files'               => __( 'We could not send your files at the moment. Please try again later.', 'xcoobee' ),
			'message_error_send_no_files'            => __( 'No files found. You need to add at least one file to proceed.', 'xcoobee' ),
			'message_error_accepted_file_extensions' => __( 'Sorry, one of your files cannot be uploaded. The accepted file extensions:', 'xcoobee' ),
			'message_error_find_bees'                => __( 'We could not fetch bee information.', 'xcoobee' ),
			'message_error_find_bees_no_bees'        => __( 'No bees found.', 'xcoobee' ),
		] );
	}

	/**
	 * Activation hooks.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		// Nothing to do for now.
	}
	
	/**
	 * Deactivation hooks.
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {
		// Nothing to do for now.
	}

	/**
	 * Uninstall hooks.
	 *
	 * @since 1.0.0
	 */
	public static function uninstall() {
		include_once XBEE_DOCUMENT_ABSPATH . 'uninstall.php';
	}
}

function init_xcoobee_document() {
	XcooBee_Document::get_instance();
}

add_action( 'plugins_loaded', 'init_xcoobee_document' );

// Plugin hooks.
register_activation_hook( __FILE__, [ 'XcooBee_Document', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'XcooBee_Document', 'deactivate' ] );
register_uninstall_hook( __FILE__, [ 'XcooBee_Document', 'uninstall' ] );