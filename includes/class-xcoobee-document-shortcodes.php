<?php
/**
 * The XcooBee_Document_Shortcodes class
 *
 * @package XcooBee/Document
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generate plugin shortcodes.
 *
 * @since 1.0.0
 */
class XcooBee_Document_Shortcodes {

	/**
	 * @var int Number of dropzones created so far.
	 */
	private $document_instances = 0;
	
	/**
	 * The constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'xcoobee_document', [ $this, 'document' ] );
		add_shortcode( 'xcoobee_document_reference', [ $this, 'document_reference' ] );
		add_shortcode( 'xcoobee_document_param', [ $this, 'document_param' ] );
		add_shortcode( 'xcoobee_document_bee_param', [ $this, 'document_bee_param' ] );
	}

	/**
	 * Updates and returns the number of document instances created so far.
	 *
	 * @since 1.0.0
	 * @return int Number of instances.
	 */
	private function get_document_instances() {
		$this->document_instances += 1;
		return $this->document_instances;
	}

	/**
	 * Generates the HTML output for `[xcoobee_document][/xcoobee_document]`.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $atts    Shortcode attributes.
	 * @param string $contnet The enclosed content.
	 * @return string HTML output.
	 */
	public function document( $atts, $content = '' ) {		
		$atts = shortcode_atts( array(
			'bee'             => 'transfer',
			'include'         => '',
			'allow_anonymous' => 'yes',
			'height'          => '350px',
			'width'           => '500px',
			'dropzone_text'   => __( 'Drag and drop your files here', 'xcoobee' ),
			'browse_text'     => __( 'Browse Files', 'xcoobee' ),
			'send_text'       => __( 'Send', 'xcoobee' ),
			'success_text'    => xbee_get_text( 'message_success_send_files' ),
			'class'           => '',
			'id'              => '',
		), $atts );

		// Filtering.
		$atts = xbee_filter_strings(
			$atts,
			[
				'browse_text' => [ 'max_length' => 50 ],
				'send_text'   => [ 'max_length' => 50 ],
			]
		);

		// Unique id for the dropzone area.
		$form_id = $this->get_document_instances();

		// Global style.
		$base_font_size      = get_option( 'xbee_document_dropzone_base_font_size', '' );
		$base_font_size_unit = get_option( 'xbee_document_dropzone_base_font_size_unit', '' );
		$border_radius       = get_option( 'xbee_document_dropzone_border_radius', '' );
		$border_radius_unit  = get_option( 'xbee_document_dropzone_border_radius_unit', '' );
		$text_color          = get_option( 'xbee_document_dropzone_text_color', '' );
		$secondary_color     = get_option( 'xbee_document_dropzone_secondary_color', '' );
		$primary_color       = get_option( 'xbee_document_dropzone_primary_color', '' );
		
		$base_font_size = ! empty( $base_font_size ) && ! empty( $base_font_size_unit ) ? $base_font_size . $base_font_size_unit : '';

		// HTML attributes
		$class = 'xbee-document' . xbee_add_css_class( ! empty( $atts['class'] ), $atts['class'], true, false );
		$style = xbee_generate_inline_style( [
			'height'           => $atts['height'],
			'width'            => $atts['width'],
			'color'            => $text_color,
			'font-size'        => $base_font_size,
			'background-color' => $secondary_color,
			'border-radius'    => $border_radius . $border_radius_unit,
		] );

		$dropzone_sytle = xbee_generate_inline_style( [
			'border-color'  => $primary_color,
			'border-radius' => $border_radius . $border_radius_unit,
		] );

		$html_atts['class'] = $class;
		$html_atts['id'] = $atts['id'];
		$html_atts['style'] = $style;

		// Add a period before file extensions.
		if ( ! empty( $atts['include'] ) ) {
			$atts['include'] = implode( ',', array_map( function( $ext ) {
				return '.' . $ext;
			}, explode( ',', $atts['include'] ) ) );
		}

		ob_start();
		?>
		<div <?php xbee_generate_html_tag_atts( [ 'class' => $class, 'id' => $atts['id'], 'style' => $style ], false, false, true ); ?>>
			<form class="xbee-dropzone" id="xbee-dropzone-<?php echo $form_id; ?>" <?php xbee_generate_html_tag_atts( [ 'style' => $dropzone_sytle ], false, false, true ); ?>>
				<svg class="xbee-upload-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1950 1950"><path d="M1302.78 756.237q0-14-9-23l-352-352q-9-9-23-9t-23 9l-351 351q-10 12-10 24 0 14 9 23t23 9h224v352q0 13 9.5 22.5t22.5 9.5h192q13 0 22.5-9.5t9.5-22.5v-352h224q13 0 22.5-9.5t9.5-22.5zm640 288q0 159-112.5 271.5t-271.5 112.5h-1088q-185 0-316.5-131.5t-131.5-316.5q0-130 70-240t188-165q-2-30-2-43 0-212 150-362t362-150q156 0 285.5 87t188.5 231q71-62 166-62 106 0 181 75t75 181q0 76-41 138 130 31 213.5 135.5t83.5 238.5z" fill="<?php echo $primary_color; ?>"/></svg>
				<input type="hidden" name="form_id" value="<?php echo $form_id; ?>" />
				<input type="hidden" name="xbee_bee_name" value="<?php echo $atts['bee']; ?>" />
				<div class="xbee-dropzone-text"><?php echo $atts['dropzone_text']; ?></div>
				<div class="xbee-params">
					<?php echo do_shortcode( $content ); ?>
				</div>
				<div class="xbee-previews"></div>
				<div class="xbee-actions">
					<input type="button" class="btn-browse<?php xbee_add_css_class( in_array( $atts['bee'], xbee_get_bee_system_names( 'no_file_upload' ) ), 'xbee-hide', true, true ); ?>" value="<?php echo $atts['browse_text']; ?>" />
					<input class="btn-submit" type="submit" value="<?php echo $atts['send_text']; ?>" />
				</div>
				<div class="xbee-response" style="background:<?php echo $secondary_color; ?>;"></div>
			</form>
			<a class="xbee-powered" href="https://www.xcoobee.com/" target="_blank">
				<span class="xbee-powered-text"><?php _e( 'Powered by XcooBee – Your Secure File Network', 'xcoobee' ); ?></span>
				<img class="xbee-powered-logo" src="<?php echo XBEE_DIR_URL; ?>assets/dist/images/icon-xcoobee.svg" />
			</a>
		</div>
		<script>
			jQuery(document).ready(function() {
				var params = {
					id: '<?php echo $form_id; ?>',
					allowAnonymous: '<?php echo $atts['allow_anonymous']; ?>' === 'yes' ? true : false,
					beeName: '<?php echo $atts['bee']; ?>',
					beesRequireFileUpload: <?php echo json_encode( xbee_get_bee_system_names( 'file_upload' ) ); ?>,
					acceptedFiles: '<?php echo $atts['include']; ?>',
					successText: '<?php echo $atts['success_text']; ?>',
				};

				xbeeCreateDropzone(params);
			});
		</script>
		<?php
		$output = ob_get_contents();
		ob_clean();
		return $output;
	}

	/**
	 * The [xcoobee_document_reference] shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public function document_reference( $atts ) {
		$atts = shortcode_atts( [
			'label'       => __( 'User Reference', 'xcoobee' ),
			'class'       => '',
			'style'       => '',
			'placeholder' => '',
			'required'    => 'no',
		], $atts, 'xcoobee_document_reference' );

		// Filtering.
		$atts = xbee_filter_strings(
			$atts,
			[
				'label' => [ 'max_length' => 50 ],
			]
		);

		return $this->get_form_field(
			'text',
			[
				'class'       => $atts['class'],
				'id'          => 'xbee_user_reference',
				'style'       => $atts['style'],
				'name'        => 'xbee_user_reference',
				'placeholder' => $atts['placeholder'],
			],
			$atts['label'],
			'div',
			'yes' === $atts['required'] ? true : false
		);
	}

	/**
	 * The [xcoobee_document_param] shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public function document_param( $atts ) {
		$atts = shortcode_atts( [
			'label'       => '',
			'type'        => 'text',
			'class'       => '',
			'id'          => '',
			'style'       => '',
			'name'        => '',
			'value'       => '',
			'placeholder' => '',
			'required'    => 'no',
		], $atts, 'xcoobee_document_param' );

		// Filtering.
		$atts = xbee_filter_strings(
			$atts,
			[
				'label' => [ 'max_length' => 50 ],
				'name'  => [ 'max_length' => 50 ],
				'value' => [ 'max_length' => 50 ],
			]
		);

		return $this->get_form_field(
			empty($atts['label']) ? 'hidden' : $atts['type'],
			[
				'class'       => $atts['class'],
				'id'          => $atts['id'],
				'style'       => $atts['style'],
				'name'        => "xbee_params[{$atts['name']}]",
				'value'       => $atts['value'],
				'placeholder' => $atts['placeholder'],
			],
			$atts['label'],
			'div',
			'yes' === $atts['required'] ? true : false
		);
	}

	/**
	 * The [xcoobee_document_bee_param] shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public function document_bee_param( $atts ) {
		$atts = shortcode_atts( [
			'label'       => '',
			'type'        => 'text',
			'class'       => '',
			'id'          => '',
			'style'       => '',
			'name'        => '',
			'value'       => '',
			'placeholder' => '',
			'required'    => 'no',
		], $atts, 'xcoobee_document_bee_param' );

		// Name and value are required.
		if ( empty( $atts['name'] ) || empty( $atts['value'] ) ) {
			return;
		}

		// Filtering.
		$atts = xbee_filter_strings(
			$atts,
			[
				'label' => [ 'max_length' => 50 ],
				'name'  => [ 'max_length' => 50 ],
				'value' => [ 'max_length' => 50 ],
			]
		);

		return $this->get_form_field(
			empty($atts['label']) ? 'hidden' : $atts['type'],
			[
				'class'       => $atts['class'],
				'id'          => $atts['id'],
				'style'       => $atts['style'],
				'name'  => "xbee_bee_params[{$atts['name']}]",
				'value' => $atts['value'],
				'placeholder' => $atts['placeholder'],
			],
			$atts['label'],
			'div',
			'yes' === $atts['required'] ? true : false
		);
	}

	/**
	 * Returns the HTML structure of a form field.
	 *
	 * @param string $type Field type.
	 * @param array $atts Field attributes.
	 * @return void
	 */
	protected function get_form_field( $type, $atts, $label = '', $enclose = 'div', $required = false ) {
		$field = '';

		if ( ! empty( $label ) ) {
			$field .= '<label';
			$field .= isset( $atts['id'] ) && ! empty( $atts['id'] ) ? " for=\"{$atts['id']}\"" : '';
			$field .= ">{$label}" . ( $required ? "<span class=\"required\">*</span>" : '' ) . "</label>";
		}

		if ( 'text' === $type || 'hidden' === $type ) {
			$field .= "<span class=\"xbee-param\"><input type=\"{$type}\"";
			foreach( $atts as $name => $value ) {
				if ( ! empty( $value ) ) {
					$field .= " {$name}=\"{$value}\"";
				}
			}
			$field .= $required ? ' required' : '';
			$field .= ' /></span>';
		}

		if ( ! empty( $enclose ) ) {
			$field_style = empty($label) ? ' style="display:none;"' : '';
			$field = "<{$enclose} class=\"xbee-field\"{$field_style}>" . $field . "</{$enclose}>";
		}

		return $field;
	}
}

new XcooBee_Document_Shortcodes;