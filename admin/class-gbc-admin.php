<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 */
class Gutenberg_Blocks_Collection_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Other important variables
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private $plugin_options_key = 'wligblocks';
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		//Load options
	 	$this->options = get_option( 'wligblocks_options' );

	 	//Action to load settings
		add_action( 'admin_init', array( $this, 'settings_init' ) );

		// Admin footer text.
		add_filter( 'admin_footer_text', array( $this, 'admin_footer' ), 1, 2 );
	}

	/**
	 * Register the menu pages for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menus() {

		//Add admin menu page
		add_menu_page( __( 'Gutenberg Blocks Collection', 'wligblocks' ), __( 'Gutenberg Blocks Collection', 'wligblocks' ), 'manage_options', $this->plugin_options_key, array (
				&$this,
				'plugin_options_page' 
		) );
	}

	/**
	 * Plugin options page callback
	 *
	 * @since    1.0.0
	 */
	public function plugin_options_page(){

		//Add message
		if( isset( $_GET['settings-updated'] ) ) {
 			add_settings_error( 'wligblocks_messages', 'wligblocks_message', __( 'Settings Updated', 'wligblocks' ), 'updated' );
		}

		//Show message
		settings_errors( 'wligblocks_messages' );
		?>
		<div class="wrap">
			<h2><?php _e( 'Gutenberg Blocks Collection - Configuration Settings', 'wligblocks' );?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( $this->plugin_options_key ); ?>
				<?php do_settings_sections( $this->plugin_options_key ); ?>
				<?php submit_button(); ?>
			</form>
		</div><?php
	}

	/**
	 * Init function to initialize hooks & functions
	 *
	 * @since    1.0.0
	 */
	public function settings_init() {

	 	register_setting( 'wligblocks', 'wligblocks_options' );

		/* Create settings section */
		add_settings_section(
		    'wligblocks_general', 
		    false,
		    array( $this, 'general_section_callback' ),
		    $this->plugin_options_key
		);

		//init all options
	 	add_settings_field(
	        'enable_pb',
	        __( 'Enable Pricing Block', 'wligblocks' ),
	        array( $this, 'enable_pb_callback' ),
	        $this->plugin_options_key,
	        'wligblocks_general',
	        array( 'label_for' => 'enable_pb' )
	    );
	 	/*add_settings_field(
	        'pb_column_limit',
	        __( 'Pricing Block Column Limit', 'wligblocks' ),
	        array( $this, 'pb_column_limit_callback' ),
	        $this->plugin_options_key,
	        'wligblocks_general',
	        array( 'label_for' => 'pb_column_limit' )
	    );*/
	}

	/**
	 * General section callback function.
	 *
	 * @since    1.0.0
	 */
	public function general_section_callback() {
		?>
		<div class="wliplugin-cta-wrap">
			<h1 class="head">We're here to help !</h1>
			<p>Our plugin comes with free, basic support for all users. We also provide plugin customization in case you want to customize our plugin to suit your needs.</p>
			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Gutenberg%20Blocks%20Collection&utm_campaign=Free%20Support" target="_blank" class="button">Need help?</a>
			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Gutenberg%20Blocks%20Collection&utm_campaign=Plugin%20Customization" target="_blank" class="button">Want to customize plugin?</a>
		</div>
		<div class="wliplugin-cta-upgrade">
			<p class="note">Want to hire Wordpress Developer to finish your wordpress website quicker or need any help in maintenance and upgrades?</p>
			<a href="https://www.weblineindia.com/contact-us.html?utm_source=WP-Plugin&utm_medium=Gutenberg%20Blocks%20Collection&utm_campaign=Hire%20WP%20Developer" target="_blank" class="button button-primary">Hire now</a>
		</div>
		<?php
	}

	/**
	 * Settings callback function.
	 *
	 * @since    1.0.0
	 */
	public function enable_pb_callback() {

		//Get option
	 	$enable_pb = !empty( $this->options['enable_pb'] ) ? $this->options['enable_pb'] : '';
		?>		
		<input type='checkbox' name='wligblocks_options[enable_pb]' <?php checked( $enable_pb, 1, 1 ); ?> value='1'>
		<?php
	}

	/**
	 * Settings callback function.
	 *
	 * @since    1.0.0
	 */
	public function pb_column_limit_callback() {

		//Get option
	 	$pb_column_limit = !empty( $this->options['pb_column_limit'] ) ? esc_html( $this->options['pb_column_limit'] ) : 3;
		?>		
		<input type='number' min="1" class="small-text" name='wligblocks_options[pb_column_limit]' value='<?php echo $pb_column_limit;?>'>
		<p class="description"><?php _e( 'Enter limit of Pricing Block Columns while adding in block editor.', 'wligblocks' );?></p>
		<?php
	}

	/**
	 * Register the stylesheets & scripts for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles_scripts( $hook ) {

		//Check if setting page
		if( 'toplevel_page_'. $this->plugin_options_key == $hook ) {
			wp_enqueue_style( $this->plugin_name .'admin', plugin_dir_url( __FILE__ ) . 'css/gbc-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register settings link on plugin page.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_link($links, $file) {

    	$pluginFile = GBC_PLUGIN_FILE;    	 
        if (basename($file) == $pluginFile) {
        	
            $linkSettings = '<a href="' . admin_url("admin.php?page=". $this->plugin_options_key) . '">'. __('Settings', 'wligblocks' ) .'</a>';
            array_unshift($links, $linkSettings);
        }
        return $links;
    }

	/**
	 * When user is on a Gutenberg Blocks Collection related admin page, display footer text
	 * that graciously asks them to rate us.
	 *
	 * @since 1.0.0
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public function admin_footer( $text ) {

		global $current_screen;

		//Check of relatd screen match
		if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, $this->plugin_options_key ) !== false ) {
			
			$url  = 'https://wordpress.org/support/plugin/blocks-collection/reviews/?filter=5#new-post';
			$wpdev_url  = 'https://www.weblineindia.com/wordpress-development.html?utm_source=WP-Plugin&utm_medium=Gutenberg%20Blocks%20Collection&utm_campaign=Footer%20CTA';
			$text = sprintf(
				wp_kses(
					'Please rate our plugin %1$s <a href="%2$s" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%3$s" target="_blank" rel="noopener">WordPress.org</a> to help us spread the word. Thank you from the <a href="%4$s" target="_blank" rel="noopener noreferrer">WordPress development</a> team at WeblineIndia.',
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
						),
					)
				),
				'<strong>"Blocks Collection"</strong>',
				$url,
				$url,
				$wpdev_url
			);
		}

		return $text;
	}
}
