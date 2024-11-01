<?php
/**
 * The document tab
 *
 * @package XcooBee/Document/Admin/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$dropzone_base_font_size      = get_option( 'xbee_document_dropzone_base_font_size', '' );
$dropzone_base_font_size_unit = get_option( 'xbee_document_dropzone_base_font_size_unit', '' );
$dropzone_text_color          = get_option( 'xbee_document_dropzone_text_color', '' );
$dropzone_primary_color       = get_option( 'xbee_document_dropzone_primary_color', '' );
$dropzone_secondary_color     = get_option( 'xbee_document_dropzone_secondary_color', '' );
?>

<?php settings_fields( 'xbee_document' ); ?>
<div class="intro">
	<div class="right">
		<h2><?php _e( 'XcooBee Document Addon', 'xcoobee' ); ?></h2>
		<p>
		<p><?php _e( 'Allow sending and receiving of secure files via the XcooBee Privacy Network. You can apply workflow to your documents on XcooBee and bypass limitations of WordPress on file sizes and processing. Very large files can be uploaded and downloaded quickly and even on small shared server WordPress deployments.
You start by embedding a drop zone your users can use to drop of documents and files anywhere on your pages.', 'xcoobee' ); ?></p>
	</div>
	<div class="left">
		<img src="<?php echo XBEE_DIR_URL . 'assets/dist/images/icon-xcoobee-document.svg'; ?>" />
	</div>
</div>

<!-- Section: Dropzone Layout -->
<div class="section" id="xbee-dropzone-layout">
	<h2 class="headline"><?php _e( 'Dropzone Layout', 'xcoobee' ); ?></h2>
	<p class="message"><?php _e( 'These are the global preferences for the dropzone areas in your website. Shortcode attributes can be used to override these values for any particular dropzone. You can also use the CSS selectors to style the dropzone at your own.', 'xcoobee' ); ?></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="xbee_document_dropzone_base_font_size"><?php _e( 'Base Font Size', 'xcoobee' ); ?></label></th>
				<td>
					<input name="xbee_document_dropzone_base_font_size" data-xbee-disallow-chars="eE.-" type="number" min="1" max="100" step="1" id="xbee_document_dropzone_base_font_size" value="<?php echo esc_attr( $dropzone_base_font_size ); ?>" class="small-text" />
					<div class="radio-buttons-group">
						<label for="xbee_document_dropzone_base_font_size_unit_px">px<input type="radio" name="xbee_document_dropzone_base_font_size_unit" value="px" id="xbee_document_dropzone_base_font_size_unit_px" <?php checked( $dropzone_base_font_size_unit, 'px' ); ?>></label>
						<label for="xbee_document_dropzone_base_font_size_unit_pt">pt<input type="radio" name="xbee_document_dropzone_base_font_size_unit" value="pt" id="xbee_document_dropzone_base_font_size_unit_pt" <?php checked( $dropzone_base_font_size_unit, 'pt' ); ?>></label>
						<label for="xbee_document_dropzone_base_font_size_unit_em">em<input type="radio" name="xbee_document_dropzone_base_font_size_unit" value="em" id="xbee_document_dropzone_base_font_size_unit_em" <?php checked( $dropzone_base_font_size_unit, 'em' ); ?>></label>
						<label for="xbee_document_dropzone_base_font_size_unit_percent">&percnt;<input type="radio" name="xbee_document_dropzone_base_font_size_unit" value="%" id="xbee_document_dropzone_base_font_size_unit_percent" <?php checked( $dropzone_base_font_size_unit, '%' ); ?>></label>
					</div>
					<p class="description"><?php _e( 'Set base font size for the dropzone area (leave this empty to use your theme\'s default).', 'xcoobee' ); ?></p>
				</td>
				<td rowspan="4" class="dropzone-preview">
					<div class="xbee-document" id="xbee-dropzone-preview">
						<div class="xbee-dropzone">
							<svg class="xbee-upload-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -256 1950 1950"><path d="M1302.78 756.237q0-14-9-23l-352-352q-9-9-23-9t-23 9l-351 351q-10 12-10 24 0 14 9 23t23 9h224v352q0 13 9.5 22.5t22.5 9.5h192q13 0 22.5-9.5t9.5-22.5v-352h224q13 0 22.5-9.5t9.5-22.5zm640 288q0 159-112.5 271.5t-271.5 112.5h-1088q-185 0-316.5-131.5t-131.5-316.5q0-130 70-240t188-165q-2-30-2-43 0-212 150-362t362-150q156 0 285.5 87t188.5 231q71-62 166-62 106 0 181 75t75 181q0 76-41 138 130 31 213.5 135.5t83.5 238.5z" fill="#3fcb78"/></svg>
							<div class="xbee-dropzone-text"><?php _e( 'Drag and drop your files here.', 'xcoobee' ); ?></div>
							<div class="xbee-response"><div class="xbee-progress-bar"></div></div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="xbee_document_dropzone_text_color"><?php _e( 'Text Color', 'xcoobee' ); ?></label></th>
				<td>
					<input name="xbee_document_dropzone_text_color" type="text" id="xbee_document_dropzone_text_color" value="<?php echo esc_attr( $dropzone_text_color ); ?>" class="color-field" />
					<p class="description"><?php _e( 'Color of the text inside the dropzone.', 'xcoobee' ); ?></p>	
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="xbee_document_dropzone_primary_color"><?php _e( 'Primary Color', 'xcoobee' ); ?></label></th>
				<td>
					<input name="xbee_document_dropzone_primary_color" type="text" id="xbee_document_dropzone_primary_color" value="<?php echo esc_attr( $dropzone_primary_color ); ?>" class="color-field" />
					<p class="description"><?php _e( 'This color will be used for the border, the progress bar and the close icon.', 'xcoobee' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="xbee_document_dropzone_secondary_color"><?php _e( 'Secondary Color', 'xcoobee' ); ?></label></th>
				<td>
					<input name="xbee_document_dropzone_secondary_color" type="text" id="xbee_document_dropzone_secondary_color" value="<?php echo esc_attr( $dropzone_secondary_color ); ?>" class="color-field" />
					<p class="description"><?php _e( 'This color will be used for the background.', 'xcoobee' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- End Section: Dropzone Layout -->

<!-- Section: Find Bees -->
<div class="section">
	<h2 class="headline"><?php _e( 'Search Bees', 'xcoobee' ); ?></h2>
	<p class="message"><?php _e( 'Bees can do many tasks safely while looking out for your privacy. If you need to know the correct name of a bee to use in a shortcode, search here for the bee system name.', 'xcoobee' ); ?></p>
	<p class="xbee-search-bees-container"><input type="text" class="xbee-search-bees" id="xbee-search-bees" placeholder="<?php _e( 'Search bees', 'xcoobee' ); ?>" /><span class="xbee-spinner" data-spinner="get-bees"></span></p>
	<div class="xbee-notification" data-notification="search-bees"></div>
	<div id="xbee-search-bees-results"></div>
</div>
<!-- End Section: Find Bees -->

<!-- Section: Shortcodes -->
<div class="section shortcodes">
	<h2 class="headline"><?php _e( 'Shortcodes', 'xcoobee' ); ?></h2>
	<p class="message"><?php _e( 'Use the following shortcodes to display file upload areas on your site.', 'xcoobee' ); ?></p>
	<div class="tabs">
		<nav class="tabs-nav">
			<a class="nav active" data-nav="xcoobee-document"><code>[xcoobee_document]</code><span><?php _e( 'The main shortcode that renders a drop area.', 'xcoobee' ); ?></span></a>
			<a class="nav" data-nav="xcoobee-document-reference"><code>[xcoobee_document_reference]</code><span><?php _e( 'Child shortcode of <em>[xcoobee_document]</em> to render an input field for User Reference.', 'xcoobee' )?></span></a>
			<a class="nav" data-nav="xcoobee-document-param"><code>[xcoobee_document_param]</code><span><?php _e( 'Child shortcode of <em>[xcoobee_document]</em> to render an input field to enter a custom parameter.', 'xcoobee' ); ?></span></a>
			<a class="nav" data-nav="xcoobee-document-bee-param"><code>[xcoobee_document_bee_param]</code><span><?php _e( 'Child shortcode of <em>[xcoobee_document] to send a bee parameter to be used when hiring a bee.</em>', 'xcoobee' ); ?></span></a>
		</nav>
		<div class="tabs-content">
			<div class="content active" data-nav="xcoobee-document">
			<table class="shortcode-info">
					<thead>
						<tr>
							<th><?php _e( 'Attribute', 'xcoobee' ); ?></th>
							<th><?php _e( 'Description', 'xcoobee' ); ?></th>
							<th><?php _e( 'Default', 'xcoobee' ); ?></th>
							<th><?php _e( 'Example', 'xcoobee' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>height</code></td>
							<td><?php _e( 'Dropzone height.', 'xcoobee' ); ?></td>
							<td><code>250px</code></td>
							<td><code>250px</code></td>
						</tr>
						<tr>
							<td><code>width</code></td>
							<td><?php _e( 'Dropzone width.', 'xcoobee' ); ?></td>
							<td><code>500px</code></td>
							<td><code>500px</code></td>
						</tr>
						<tr>
							<td><code>bee</code></td>
							<td><?php _e( 'System name of the hiring bee.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>transfer</code></td>
						</tr>
						<tr>
							<td><code>include</code></td>
							<td><?php _e( 'CSV list of file extensions to allow. This will be applied on top of what the bee normally allows.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>jpg,png,pdf</code></td>
						</tr>
						<tr>
							<td><code>dropzone_text</code></td>
							<td><?php _e( 'Alternate text for the dropzone area.', 'xcoobee' ); ?></td>
							<td><code><?php _e( 'Drag and drop your files here', 'xcoobee' ); ?></code></td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>browse_text</code></td>
							<td><?php _e( 'Alternate text for the browse files button.', 'xcoobee' ); ?></td>
							<td><code><?php _e( 'Browse Files', 'xcoobee' ); ?></code></td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>send_text</code></td>
							<td><?php _e( 'Alternate text for the submission button.', 'xcoobee' ); ?></td>
							<td><code><?php _e( 'Send', 'xcoobee' ); ?></code></td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>class</code></td>
							<td><?php _e( 'Additional CSS classes to the dropzone area.', 'xcoobee'); ?></td>
							<td>&nbsp;</td>
							<td><code>my-class my-second-class</code></td>
						</tr>
						<tr>
							<td><code>id</code></td>
							<td><?php _e( 'Custom HTML Id for the dropzone area.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>my-dropzone</code></td>
						</tr>
					</tbody>
				</table>
				<div class="example" id="shortcode-example-xcoobee-document"><span class="xbee-copy-text xbee-tooltip" data-tooltip="<?php _e('Copy', 'xcoobee'); ?>" data-copy="shortcode-example-xcoobee-document"></span><span class="headline"><?php _e( 'Example', 'xcoobee' ); ?></span><code>[xcoobee_document height=&quot;250px&quot; width=&quot;400px&quot; bee=&quot;transfer&quot; include=&quot;jpg,png&quot; dropzone_text=&quot;Drag and drop your files here from anywhere&quot; browse_text=&quot;Browse Files&quot; send_text=&quot;Send Files&quot; class=&quot;my-dropzone&quot; id=&quot;upload-files&quot;][/xcoobee_document]</code></div>
			</div>
			<div class="content" data-nav="xcoobee-document-reference">
				<table class="shortcode-info">
					<thead>
						<tr>
							<th><?php _e( 'Attribute', 'xcoobee' ); ?></th>
							<th><?php _e( 'Description', 'xcoobee' ); ?></th>
							<th><?php _e( 'Default', 'xcoobee' ); ?></th>
							<th><?php _e( 'Example', 'xcoobee' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>label</code></td>
							<td><?php _e( 'Label for the input field.', 'xcoobee' ); ?></td>
							<td><code><?php _e( 'User Reference', 'xcoobee' ); ?></code></td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>required</code></td>
							<td><?php _e( 'Make this a required filed.', 'xcoobee' ); ?></td>
							<td><code>no</code></td>
							<td><code>yes</code></td>
						</tr>
					</tbody>
				</table>
				<div class="example" id="shortcode-example-xcoobee-document-reference"><span class="xbee-copy-text xbee-tooltip" data-tooltip="<?php _e('Copy', 'xcoobee'); ?>" data-copy="shortcode-example-xcoobee-document-reference"></span><span class="headline"><?php _e( 'Example', 'xcoobee' ); ?></span><code><em>[xcoobee_document]</em>[xcoobee_document_reference label=&quot;User Reference&quot; required=&quot;yes&quot;]<em>[/xcoobee_document]</em></code></div>
			</div>
			<div class="content" data-nav="xcoobee-document-param">
				<table class="shortcode-info">
					<thead>
						<tr>
							<th><?php _e( 'Attribute', 'xcoobee' ); ?></th>
							<th><?php _e( 'Description', 'xcoobee' ); ?></th>
							<th><?php _e( 'Default', 'xcoobee' ); ?></th>
							<th><?php _e( 'Example', 'xcoobee' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>name</code></td>
							<td><?php _e( 'Field name.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>custom_param</code></td>
						</tr>
						<tr>
							<td><code>value</code></td>
							<td><?php _e( 'Default value.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>value</code></td>
						</tr>
						<tr>
							<td><code>label</code></td>
							<td><?php _e( 'Label for the input field. If left empty, the field will not be visible and the default <code>value</code> will be used.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>required</code></td>
							<td><?php _e( 'Make this a required filed.', 'xcoobee' ); ?></td>
							<td><code>no</code></td>
							<td><code>yes</code></td>
						</tr>
					</tbody>
				</table>
				<div class="example" id="shortcode-example-xcoobee-document-param"><span class="xbee-copy-text xbee-tooltip" data-tooltip="<?php _e('Copy', 'xcoobee'); ?>" data-copy="shortcode-example-xcoobee-document-param"></span><span class="headline"><?php _e( 'Example', 'xcoobee' ); ?></span><code><em>[xcoobee_document]</em>[xcoobee_document_param name=&quot;your_name&quot; value=&quot;No Name&quot; label=&quot;Your Name&quot; required=&quot;yes&quot;]<em>[/xcoobee_document]</em></code></div>
			</div>
			<div class="content" data-nav="xcoobee-document-bee-param">
				<table class="shortcode-info">
					<thead>
						<tr>
							<th><?php _e( 'Attribute', 'xcoobee' ); ?></th>
							<th><?php _e( 'Description', 'xcoobee' ); ?></th>
							<th><?php _e( 'Default', 'xcoobee' ); ?></th>
							<th><?php _e( 'Example', 'xcoobee' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>name</code></td>
							<td><?php _e( 'Parameter name.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>text_size</code></td>
						</tr>
						<tr>
							<td><code>value</code></td>
							<td><?php _e( 'Parameter value.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>25</code></td>
						</tr>
						<tr>
							<td><code>label</code></td>
							<td><?php _e( 'Label for the input field. If left empty, the field will not be visible and the default <code>value</code> will be used.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code><?php _e( 'Your text', 'xcoobee' ); ?></code></td>
						</tr>
						<tr>
							<td><code>required</code></td>
							<td><?php _e( 'Make this a required filed.', 'xcoobee' ); ?></td>
							<td><code>no</code></td>
							<td><code>yes</code></td>
						</tr>
					</tbody>
				</table>
				<div class="example" id="shortcode-example-xcoobee-document-bee-param"><span class="xbee-copy-text xbee-tooltip" data-tooltip="<?php _e('Copy', 'xcoobee'); ?>" data-copy="shortcode-example-xcoobee-document-bee-param"></span><span class="headline"><?php _e( 'Example', 'xcoobee' ); ?></span><code><em>[xcoobee_document]</em>[xcoobee_document_bee_param name=&quot;text_size&quot; value=&quot;25&quot; label=&quot;Font Size&quot;]<em>[/xcoobee_document]</em></code></div>
			</div>
		</div>
	</div>
</div>
<!-- End Section: Shortcodes -->

<!-- Section: Helper Functions -->
<div class="section helper-functions">
	<h2 class="headline"><?php _e( 'Helper Functions', 'xcoobee' ); ?></h2>
	<p class="message"><?php _e( 'Helper functions allow you to easily communicate with the XcooBee secure network.', 'xcoobee' ); ?></p>
	<div class="tabs">
		<nav class="tabs-nav">
			<a class="nav active" data-nav="xbee-send-file"><code>xbee_send_file($recipient, $file_path)</code><span><?php _e( 'Send files securly via XcooBee.', 'xcoobee' ); ?></span></a>
		</nav>
		<div class="tabs-content">
			<div class="content active" data-nav="xbee-send-file">
				<table class="shortcode-info">
					<thead>
						<tr>
							<th><?php _e( 'Parameter', 'xcoobee' ); ?></th>
							<th><?php _e( 'Description', 'xcoobee' ); ?></th>
							<th><?php _e( 'Default Value', 'xcoobee' ); ?></th>
							<th><?php _e( 'Example', 'xcoobee' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><code>$recipient</code></td>
							<td><?php _e( 'The recipient of the file. Could be a XcooBee Id or an email address.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>~XcooBee</code><code>email@example.com</code></td>
						</tr>
						<tr>
							<td><code>$file_path</code></td>
							<td><?php _e( 'The absolute path of the file to be sent.', 'xcoobee' ); ?></td>
							<td>&nbsp;</td>
							<td><code>/path/to/file.jpg</code></td>
						</tr>
					</tbody>
				</table>
				<div class="example" id="helper-example-xbee-send-file"><span class="xbee-copy-text xbee-tooltip" data-tooltip="<?php _e('Copy', 'xcoobee'); ?>" data-copy="helper-example-xbee-send-file"></span><span class="headline"><?php _e( 'Example', 'xcoobee' ); ?></span><code>xbee_send_file('~XcooBee', '/path/to/file.jpg');</code></div>
			</div>
		</div>
	</div>
</div>
<!-- End Section: Helper Functions -->

<p class="actions"><?php submit_button( __( 'Save Changes', 'xcoobee' ), 'primary', 'submit', false ); ?></p>