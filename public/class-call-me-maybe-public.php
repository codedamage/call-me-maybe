<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/codedamage
 * @since      1.0.0
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/public
 * @author     Viktor <oleksuh@gmail.com>
 */
class Call_Me_Maybe_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('call_me_maybe', [$this, 'form_shortcode']);
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action ( 'wp_head', array( $this, 'javascript_variables' ) );

	}

	/**
	 * Create form shortcode.
	 *
	 * @since    1.0.0
	 */
	public function form_shortcode(){
		$html = '<form action="" method="post" name="callback_form">
				    <div class="form-field">    
				        <label>Name: </label>
				        <input name="name" type="text" placeholder="Type your name" required>
				    </div>
				    <div class="form-field">    
				        <label>Email: </label>
				        <input name="email"  type="email" placeholder="Type a valid email" required>
				    </div>
				    <div class="form-field">    
				        <label>Phone: </label>
				        <input name="phone"  type="text" placeholder="+1 201-926-9775" required>
				    </div>
				    <div class="form-field">    
				        <label>Date: </label>
				        <input name="date" min="'. date('Y-m-d').'" type="date" required>
				    </div>
				    <input type="hidden" name="action" value="send_enquiry" style="display: none; visibility: hidden; opacity: 0;">
				    <button class="button" type="submit">Call me back!</button>
				</form>';
		return $html;
	}

	/**
	 * Create form variables.
	 *
	 * @since    1.0.0
	 */
	function javascript_variables(){ ?>
		<script type="text/javascript">
            var ajax_url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
            var ajax_nonce = '<?php echo wp_create_nonce( "secure_nonce_cmm" ); ?>';
		</script><?php
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Call_Me_Maybe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Call_Me_Maybe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/call-me-maybe-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Call_Me_Maybe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Call_Me_Maybe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'call-me-maybe-public', plugin_dir_url( __FILE__ ) . 'js/call-me-maybe-public.js', array( 'jquery' ), null, true );

		// set variables for script
		wp_localize_script( 'call-me-maybe-public', 'settings', array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'error'      => __( 'Sorry, something went wrong. Please try again', 'call-me-maybe' )
		));
	}

}
