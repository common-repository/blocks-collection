<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 */
class Gutenberg_Blocks_Collection_Blocks {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {

		// Hook the enqueue functions into the editor
		add_action( 'init', array( $this, 'wligblocks_plugin_editor_scripts' ) );
		//add_action( 'enqueue_block_assets', array( $this, 'wligblocks_plugin_view_scripts' ) );
		add_action( 'block_categories_all', array( $this, 'wligblocks_block_category' ), 10, 2 );
	}

	/**
	 * Enqueue block JavaScript and CSS for the editor
	 */
	public function wligblocks_plugin_editor_scripts() {
	 
	    // Enqueue block editor JS
	    wp_register_script(
	        'wligblocks/editor-scripts',
	        GBC_PLUGIN_URL .'/build/index.js',
	        [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ],
	        filemtime( GBC_PLUGIN_PATH . '/build/index.js' ) 
	    );
	 
	    // Enqueue block editor styles
	    wp_register_style(
	        'wligblocks/stylesheets',
	        GBC_PLUGIN_URL .'/build/index.css',
	        [ 'wp-edit-blocks' ],
	        filemtime( GBC_PLUGIN_PATH . 'build/index.css' ) 
	    );

	    //Get options
	    $options = get_option( 'wligblocks_options' );
	    wp_localize_script(
	        'wligblocks/editor-scripts',
	        'Wligblocks_Data',
	        array(
	            'options' => $options
	        )
	    );

		/**
		 * Registers the block using the metadata loaded from the `block.json` file.
		 * Behind the scenes, it registers also all assets so they can be enqueued
		 * through the block editor in the corresponding context.
		 *
		 * @see https://developer.wordpress.org/reference/functions/register_block_type/
		 */
	    register_block_type('wligblocks/block-library', array(
	        'editor_script' => 'wligblocks/editor-scripts',
	        'style' => 'wligblocks/stylesheets'
	    ));

		//register_block_type( GBC_PLUGIN_PATH . '/build' );
	}

	/**
	 * Enqueue view scripts
	 */
	public function wligblocks_plugin_view_scripts() {
	    if ( is_admin() ) {
	        return;
	    }

	    //Get options
	    $options = get_option( 'wligblocks_options' );

	    //Check if pricing block enable
	    if( !empty( $options['enable_pb'] ) ) {
	        wp_enqueue_script(
	            'wligblocks/view-scripts',
	            GBC_PLUGIN_URL .'/assets/dist/build.view.js',
	            array( 'wp-blocks', 'wp-element', 'react', 'react-dom' )
	        );
	    }
	}

	/**
	 * Added block category
	 */
	public function wligblocks_block_category( $categories, $be_context ) {
	    return array_merge(
	        $categories,
	        array(
	            array(
	                'slug' => 'weblineindia',
	                'title' => __( 'WeblineIndia', 'wligblocks' ),
	            ),
	        )
	    );
	}
}

new Gutenberg_Blocks_Collection_Blocks();