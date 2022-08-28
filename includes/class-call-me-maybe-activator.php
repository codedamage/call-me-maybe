<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/codedamage
 * @since      1.0.0
 *
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Call_Me_Maybe
 * @subpackage Call_Me_Maybe/includes
 * @author     Viktor <oleksuh@gmail.com>
 */
class Call_Me_Maybe_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'callback_requests';

		$sql = "CREATE TABLE $table_name (
		 id mediumint(9) NOT NULL AUTO_INCREMENT,
          name varchar(255) DEFAULT '' NOT NULL,
          email varchar(255) NOT NULL,
          phone varchar(32) NOT NULL,
          date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,  
          PRIMARY KEY  (id)
	) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
