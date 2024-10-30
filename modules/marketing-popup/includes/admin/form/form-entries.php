<?php
/**
 * Form Entries HTML
 *
 * @package InboundWP Lite
 * @subpackage Marketing Popup
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class IBWPL_MP_Email_Lists extends WP_List_Table {

	var $prefix, $per_page, $entries_count, $redirect_url;

	// Construct
	function __construct() {
		
		$this->prefix       	= IBWPL_MP_META_PREFIX;
		$this->per_page    	 	= apply_filters( 'ibwpl_mp_form_entries_per_page', 15 ); // Per page
		$this->redirect_url		= add_query_arg( array('post_type' => IBWPL_MP_POST_TYPE, 'page' => 'ibwp-mp-form-entries'), admin_url('edit.php') );

		// Set parent defaults
		parent::__construct( array(
								'singular'  => 'ibwp_mp_entry',		// singular name of the listed records
								'plural'    => 'ibwp_mp_entry',		// plural name of the listed records
								'ajax'      => true					// does this table support ajax?
							));

		$this->entries_count = ibwpl_mp_entries_count( array(
														'popup_id'	=> isset( $_GET['popup_id'] ) ? $_GET['popup_id'] : '',
														'search'	=> isset( $_GET['s'] ) ? $_GET['s'] : '',
													));
	}

	/**
	 * Displaying emails data
	 * 
	 * Does prepare the data for displaying the emails in the table.
	 * 
	 * @since 1.0
	 */
	function ibwpl_mp_form_entries() {

		// Taking some variable
		$entries	= array();
		$orderby    = isset( $_GET['orderby'] ) ? urldecode( $_GET['orderby'] ) : 'created_date';
		$order      = isset( $_GET['order'] )   ? $_GET['order']                : 'DESC';
		$args       = array(
						'limit'		=> $this->per_page,
						'orderby'	=> $orderby,
						'order'		=> $order,
						'search'	=> isset( $_GET['s'] ) ? $_GET['s'] : '',
						'popup_id'	=> isset( $_GET['popup_id'] ) ? $_GET['popup_id'] : '',
					);

		// Get Emails Data
		$entries_data = ibwpl_mp_get_entries( $args );

		if( !empty( $entries_data ) ) {
			foreach ( $entries_data as $entry_key => $entry_data ) {

				$entries[$entry_key]['id'] 				= $entry_data->id;
				$entries[$entry_key]['name'] 			= $entry_data->name;
				$entries[$entry_key]['email'] 			= $entry_data->email;
				$entries[$entry_key]['phone'] 			= $entry_data->phone;
				$entries[$entry_key]['popup_id'] 		= $entry_data->popup_id;
				$entries[$entry_key]['created_date']	= $entry_data->created_date;
			}
		}

		return $entries;
	}

	/**
	 * Display Columns
	 * 
	 * Handles which columns to show in table
	 * 
	 * @subpackage Marketing Popup
	 * @since 1.0
	 */
	function get_columns(){
		$columns = array(
			'cb'			=> '<input type="checkbox" />', //Render a checkbox instead of text
			'id'			=> __('ID', 'inboundwp-lite'),
			'email'			=> __('Email', 'inboundwp-lite'),
			'name'			=> __('Name', 'inboundwp-lite'),
			'phone'			=> __('Phone', 'inboundwp-lite'),
			'popup_id'		=> __('Popup', 'inboundwp-lite'),
			'created_date'	=> __('Created Date', 'inboundwp-lite'),
		);
		return $columns;
	}

	/**
	 * Mange column data
	 * 
	 * Default Column for listing table
	 * 
	 * @since 1.0
	 */
	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case "popup_id":
				$popup_id 		= $item['popup_id'];
				$popup_url 		= add_query_arg( array( 'popup_id' => $popup_id ), $this->redirect_url );
				$default_val	= '<a href="'.esc_url( $popup_url ).'" title="'.esc_html__('Click to view Popup entries', 'inboundwp-lite').'">'. get_the_title( $popup_id ) .'</a>';
				break;

			default:
				$default_val = $item[ $column_name ];
				break;
		}
		return $default_val;
	}

	/**
	 * Handles checkbox HTML
	 * 
	 * @since 1.0
	 **/
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],  // Let's simply repurpose the table's singular label ("ibwp-mp-emails")
			$item['id']                // The value of the checkbox should be the record's id
		);
	}

	/**
	 * Sortable Columns
	 *
	 * Handles soratable columns of the table
	 * 
	 * @since 1.0
	 */
	function get_sortable_columns() {

		$sortable_columns = array(
			'id'    		=> array('id', false),
			'created_date'  => array('created_date', false)
		);
		return $sortable_columns;
	}

	/**
	 * Manage Entries Column
	 *
	 * @since 1.0
	 */
	function column_email( $item ) {

		$paged 				= isset($_GET['paged']) ? $_GET['paged'] : false;
		$page_url			= add_query_arg( array( 'paged' => $paged ), $this->redirect_url );
		$view_entry 		= add_query_arg( array( 'action' => 'view', 'entry_id' => $item['id'] ), $page_url );
		$delete_entries 	= add_query_arg( array( 'action' => 'delete', 'ibwp_mp_entry[]' => $item['id'], '_wpnonce' => wp_create_nonce('bulk-ibwp_mp_entry') ), $page_url );

		$actions['view']	= sprintf('<a class="ibwp-mp-action-link" href="%s">'.__('View', 'inboundwp-lite').'</a>', $view_entry );
		$actions['delete']	= sprintf('<a class="ibwp-confirm ibwp-mp-action-link" href="%s">'.__('Delete', 'inboundwp-lite').'</a>', $delete_entries );

		// Return contents
		return sprintf('%1$s %2$s',
		   /*%1$s*/ $item['email'],
		   /*%2$s*/ $this->row_actions( $actions )
		);
	}

	/**
	 * Bulk actions field
	 *
	 * Handles Bulk Action combo box values
	 * 
	 * @since 1.0
	 */
	function get_bulk_actions() {
		$actions = array(
						'delete' => __('Delete', 'inboundwp-lite')
					);
		return $actions;
	}

	/**
	 * Message to show when no records in database table
	 *
	 * @since 1.0
	 */
	function no_items() {
		echo __('No entries found.', 'inboundwp-lite');
	}

	/**
	 * Prepare Items for emails listing
	 * 
	 * @since 1.0
	 **/
	function prepare_items() {
		
		// Get how many records per page to show
		$per_page	= $this->per_page;
		
		// Get All, Hidden, Sortable columns
		$columns	= $this->get_columns();
		$hidden		= array();
		$sortable	= $this->get_sortable_columns();

		// Get final column header
		$this->_column_headers = array($columns, $hidden, $sortable);

		// Get current page number
		$current_page = $this->get_pagenum();

		// Get total count
		$total_items = $this->entries_count;

		// Get page items
		$this->items = $this->ibwpl_mp_form_entries();

		// Register pagination options and calculations.
		$this->set_pagination_args( array(
										'total_items' => $total_items,                  // Calculate the total number of items
										'per_page'    => $per_page,                     // Determine how many items to show on a page
										'total_pages' => ceil($total_items / $per_page)	// Calculate the total number of pages
									));
	}
}

$email_lists = new IBWPL_MP_Email_Lists();
$email_lists->prepare_items();

// Little Patch to avoid too long URL Error
ibwpl_avoid_long_url();
?>

<div class="wrap ibwp-mp-form-entries-wrap">

	<h2><?php _e( 'Marketing Popup Form Entries', 'inboundwp-lite' ); ?></h2>

	<?php if( ! empty($_GET['message']) && $_GET['message'] == 1 ) {
		ibwpl_display_message( 'update', __('Entries deleted successfully.', 'inboundwp-lite') );
	} ?>

	<form id="ibwp-mp-from-entries" class="ibwp-mp-from-entries" method="get" action="">

		<input type="hidden" name="post_type" value="<?php echo $_REQUEST['post_type'] ?>" />
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

		<?php

			$email_lists->search_box( __( 'Search', 'inboundwp-lite' ), 'inboundwp-lite' );

			$email_lists->views();		// Showing sorting links on the top of the list

			$email_lists->display();	// Display all the entries
		?>
	</form><!-- end .ibwp-mp-from-entries -->
</div><!-- end .ibwp-mp-form-entries-wrap -->