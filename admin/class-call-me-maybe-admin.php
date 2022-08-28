<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/codedamage
 * @since      1.0.0
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/admin
 * @author     Viktor <oleksuh@gmail.com>
 */
class Call_Me_Maybe_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->enquiries_admin_nav();
		add_action( 'wp_ajax_nopriv_send_enquiry', array( $this, 'send_enquiry' ) );
		add_action( 'wp_ajax_send_enquiry', array( $this, 'send_enquiry' ) );

	}

	public function enquiries_admin_nav(){
		add_action( 'admin_menu', 'enquiries_main_page' );
		function enquiries_main_page(){
			$hook =  add_menu_page(
				'Enquiries',
				'Callback enquiries',
				'edit_others_posts',
				'enquiries-list',
				'enquiries_callback',
				'dashicons-cloud-saved',
				6 );
			add_action( "load-$hook", 'enquiries_table_page_load' );
		}

		function enquiries_table_page_load(){
			require_once __DIR__ . '/class-enquiries_List_Table.php';
			$GLOBALS['Enquiries_List_Table'] = new Enquiries_List_Table();
		}

		function enquiries_callback() {
			global $wpdb;
			$enquiries = $wpdb->prefix . 'callback_requests';
			$all_num = count($wpdb->get_results( "SELECT * FROM ". $enquiries));
			?>
			<div class="wrap">
				<h1 class="wp-heading-inline"><?php echo get_admin_page_title() ?></h1>
				<?php
				echo '<form id="enquiry-filter" method="get">';
				echo '<input type="hidden" name="page" value="enquiries-list">';
				$GLOBALS['Enquiries_List_Table']->search_box('Search enquiries by name', 's');
				echo '</form>';
				echo '<form action="" method="POST">';
				$GLOBALS['Enquiries_List_Table']->display();
				echo '</form>';
				?>
			</div>
			<?php
		}
	}

    public function send_enquiry() {
	    $data = $_POST;
        global $wpdb;
	    $enquiries = $wpdb->prefix . 'callback_requests';
	    // check the nonce
	    check_ajax_referer( 'secure_nonce_cmm', 'security' );

        $name = sanitize_text_field($data['name']);
	    $email = sanitize_text_field($data['email']);
	    $phone= sanitize_text_field($data['phone']);
	    $date = date( 'Y-m-d H:i:s', strtotime($data['date']) );

	    $query = $wpdb->insert($enquiries, array(
		    'name' => $name,
		    'email' => $email,
		    'phone' => $phone,
		    'date' => $date,
		    'created_at' => date('Y-m-d H:i:s')
	    ));

	    if ( $query !== false) {
		    wp_send_json_success( __( 'Thanks, we will call you back as soon as possible!', 'call-me-maybe' ) );
	    } else {
		    wp_send_json_error();
	    }
    }

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/call-me-maybe-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/call-me-maybe-admin.js', array( 'jquery' ), $this->version, false );

	}

}
