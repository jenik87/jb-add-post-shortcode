<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//Option Page
class jbOptionPage {
	private $jb_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'jb_add_option_page' ) );
		add_action( 'admin_init', array( $this, 'jb_option_page_init' ) );
	}

	public function jb_add_option_page() {
		add_menu_page(
			'Add Post Form Shortcode',
			'Add Post Form',
			'manage_options',
			'add-post-form-shortcode',
			array( $this, 'jb_create_option_page' ),
			'dashicons-shortcode',
			6
		);
	}

	public function jb_create_option_page() {
		$this->jb_options = get_option( 'jb_options' ); ?>

		<div class="wrap">
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'jb_options_group' );
					do_settings_sections( 'jb_options_email' );
					submit_button();
				?>
			</form>
			<p>
				<?php _e('Use this shortcode for add form - ', 'jb'); ?>
				<b>[jb_add_post_form]</b>
			</p>
		</div>
	<?php }

	public function jb_option_page_init() {
		register_setting(
			'jb_options_group',
			'jb_options',
			array( $this, 'jb_options_sanitize' )
		);

		add_settings_section(
			'jb_setting_section',
			esc_html__( 'Settings', 'jb' ),
			array( $this, 'jb_options_section_info' ),
			'jb_options_email'
		);

		add_settings_field(
			'jb_email',
			esc_html__( 'Admin Email', 'jb' ),
			array( $this, 'jb_email_callback' ),
			'jb_options_email',
			'jb_setting_section'
		);
	}

	public function jb_options_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['jb_email'] ) ) {
			$sanitary_values['jb_email'] = sanitize_text_field( $input['jb_email'] );
		}

		return $sanitary_values;
	}

	public function jb_options_section_info() {
		
	}

	public function jb_email_callback() {
		printf(
			'<input class="regular-text" type="text" name="jb_options[jb_email]" id="jb_email" value="%s">',
			isset( $this->jb_options['jb_email'] ) ? esc_attr( $this->jb_options['jb_email']) : ''
		);
	}

}
if ( is_admin() )
	$jb_options_page = new jbOptionPage();
