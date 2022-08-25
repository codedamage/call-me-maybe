<?php


class Enquiries_List_Table extends WP_List_Table {

	function __construct(){
		parent::__construct(array(
			'singular' => 'enquiry',
			'plural'   => 'enquiries',
			'ajax'     => false,
		));

		$this->bulk_action_handler();

		// screen option
		add_screen_option( 'per_page', array(
			'label'   => 'Enquiries per page',
			'default' => 10,
			'option'  => 'enquiries_per_page',
		) );

		$this->prepare_items();

		add_action( 'wp_print_scripts', [ __CLASS__, '_list_table_css' ] );
	}


	function prepare_items(){
		global $wpdb;
		$enquiries = $wpdb->prefix . 'callback_requests';
		$all_num = count($wpdb->get_results( "SELECT * FROM ". $enquiries));
		// pagination
		$per_page = get_user_meta( get_current_user_id(), get_current_screen()->get_option( 'per_page', 'option' ), true ) ?: 500;

		$this->set_pagination_args( array(
			'total_items' => $all_num,
			'per_page'    => $per_page,
		) );
		$cur_page = (int) $this->get_pagenum();
		if ($cur_page > 1){
			$offset = $cur_page * $per_page - $per_page;
		}
		else{
			$offset = 0;
		}
		$search = '';
		if (isset($_GET['s']) && $_GET['s'] !== ''){
			$search = ' WHERE `name` LIKE "%'.$_GET['s'].'%"';
		}
		$order = 'DESC';
		$orderby = 'updated_at';
		if (isset($_GET['order'])){
			$order = $_GET['order'];
		}
		if (isset($_GET['order'])){
			$orderby = $_GET['orderby'];
		}
		// элементы таблицы

		$this->items = $wpdb->get_results( "SELECT * FROM ". $enquiries . " ".$search." ORDER BY `".$orderby."` ".$order." LIMIT " . $per_page . " OFFSET ". $offset . "");

	}

	function get_columns(){
		return array(
			'cb'      => '<input type="checkbox" />',
			'name'    => 'Name',
			'email'   => 'Email',
			'phone'   => 'Phone',
			'date'    => 'Date',
		);
	}

	function get_sortable_columns(){
		return array(
			'updated_at' => array( 'updated_at', 'DESC' ),
		);
	}

	protected function get_bulk_actions() {
		return array(
			'delete' => 'Delete',
		);
	}

	static function _list_table_css(){
		?>
		<style>
            table.logs .column-id{ width:2em; }
            table.logs .column-gclid{ width:8em; }
            table.logs .column-tag{ width:15%; }
		</style>
		<?php
	}

	function column_default( $item, $colname ){

		return isset($item->$colname) ? $item->$colname : print_r($item, 1);

	}

	function column_cb( $item ){
		echo '<input type="checkbox" name="licids[]" id="cb-select-'. $item->id .'" value="'. $item->id .'" />';
	}



	// helpers -------------

	private function bulk_action_handler(){
		if( !empty($_POST['licids']) && !empty($_POST['_wpnonce']) ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'callback_requests';
			$wpdb->get_results( "DELETE FROM `".$table_name."` WHERE `id` IN (".implode(',', $_POST['licids']).")" );
		}
	}



}