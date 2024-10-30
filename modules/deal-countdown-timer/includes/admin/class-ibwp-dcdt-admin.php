<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Deal Countdown Timer
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Ibwpl_Dcdt_Admin {

	function __construct() {

		// Action to add metabox
		add_action( 'add_meta_boxes', array($this, 'ibwpl_dcdt_sett_metabox') );

		// Action to save metabox
		add_action( 'save_post', array($this, 'ibwpl_dcdt_save_metabox_value') );

		// Action to add EDD custom meta
		add_action( 'edd_after_price_field', array( $this, 'ibwpl_dcdt_add_edd_custom_fields' ) );

		// Filter to save EDD custom meta
		add_filter( 'edd_metabox_fields_save', array( $this, 'ibwpl_dcdt_save_edd_custom_fields' ) );

		// Action to add WC custom meta
		add_action( 'woocommerce_product_options_pricing', array($this, 'ibwpl_dcdt_add_woo_custom_fields') );

		// Action to save WC custom meta
		add_action( 'woocommerce_process_product_meta', array($this, 'ibwpl_dcdt_save_woo_custom_fields') );

		// Filter to add screen id
		add_filter( 'ibwpl_screen_ids', array( $this, 'ibwpl_dcdt_add_screen_id') );
	}
	
	/**
	 * Post Settings Metabox
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_sett_metabox() {
		
		// Settings metabox
		add_meta_box( 'dcdt-post-sett', __( 'Deal Countdown Timer Pro - Settings', 'inboundwp-lite' ), array($this, 'ibwpl_dcdt_cpt_sett_mb'), IBWPL_DCDT_POST_TYPE, 'normal', 'high' );
		
		// Add metasbox on product for timer post
		add_meta_box( 'dcdt-post-sett-product', __( 'Deal Countdown Timer Pro - IBWP', 'inboundwp-lite' ), array($this, 'ibwpl_dcdt_post_type_sett_mb'), array('product','download'), 'normal', 'high' );
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_cpt_sett_mb() {
		include_once( IBWPL_DCDT_DIR .'/includes/admin/metabox/dcdt-post-sett.php');
	}

	/**
	 * Post Settings Metabox HTML
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_post_type_sett_mb() {
		include_once( IBWPL_DCDT_DIR .'/includes/admin/metabox/post-type-sett.php');
	}

	/**
	 * Function to save metabox values
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_save_metabox_value( $post_id ) {

		global $post_type;
		$prefix = IBWPL_DCDT_META_PREFIX; // Taking metabox prefix

		// Taking timer id from product
       	if(isset($_POST[$prefix.'timer_post'])) {

			$timer_post_id	= $_POST[$prefix.'timer_post'] ? $_POST[$prefix.'timer_post'] : '';

			update_post_meta($post_id, $prefix.'timer_post', $timer_post_id);
		}

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                	// Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )  	// Check Revision
		|| ( $post_type !=  IBWPL_DCDT_POST_TYPE ) )              				// Check if current post type is supported.
		{
			return $post_id;
		}

		// General Settings
		$data['timer_style'] 			= isset($_POST[$prefix.'timer_style']) 				? ibwpl_clean($_POST[$prefix.'timer_style'])					: '';
		$data['timer_position'] 		= isset($_POST[$prefix.'timer_position']) 			? ibwpl_clean($_POST[$prefix.'timer_position'])				: '';
		$data['timertext_fontsize']		= !empty($_POST[$prefix.'timertext_fontsize']) 		? ibwpl_clean_number($_POST[$prefix.'timertext_fontsize'])	: 16;
		$data['timertext_color']		= !empty($_POST[$prefix.'timertext_color']) 		? ibwpl_clean_color( $_POST[$prefix.'timertext_color'] ) 	: '#000000';
		$data['timerdigit_fontsize']	= !empty($_POST[$prefix.'timerdigit_fontsize']) 	? ibwpl_clean_number($_POST[$prefix.'timerdigit_fontsize'])	: 25;
		$data['timerdigit_color']		= !empty($_POST[$prefix.'timerdigit_color']) 		? ibwpl_clean_color( $_POST[$prefix.'timerdigit_color'] )	: '#000000';
		$data['is_timerdays']			= !empty($_POST[$prefix.'is_timerdays'])			? 1 														: 0;
		$data['timer_day_text'] 		= isset($_POST[$prefix.'timer_day_text'])			? ibwpl_clean($_POST[$prefix.'timer_day_text']) 				: _e('Days','inboundwp-lite');
		$data['is_timerhours']			= !empty($_POST[$prefix.'is_timerhours']) 			? 1 														: 0;
		$data['timer_hour_text'] 		= isset($_POST[$prefix.'timer_hour_text']) 			? ibwpl_clean($_POST[$prefix.'timer_hour_text']) 			: _e('Hours','inboundwp-lite');
		$data['is_timerminutes']		= !empty($_POST[$prefix.'is_timerminutes'])			? 1 														: 0;
		$data['timer_minute_text'] 		= isset($_POST[$prefix.'timer_minute_text'])		? ibwpl_clean($_POST[$prefix.'timer_minute_text']) 			: _e('Minutes','inboundwp-lite');
		$data['is_timerseconds']		= !empty($_POST[$prefix.'is_timerseconds'])			? 1 														: 0;
		$data['timer_second_text'] 		= isset($_POST[$prefix.'timer_second_text'])		? ibwpl_clean($_POST[$prefix.'timer_second_text']) 			: _e('Seconds','inboundwp-lite');

		// Circle Clock Style Settings - circle
		if( $data['timer_style'] == 'circle' ) {
			$data['circle_border_color'] 	= !empty($_POST[$prefix.'circle_border_color'])		? ibwpl_clean_color($_POST[$prefix.'circle_border_color'])	: '#ff9900';
			$data['circle_border_style'] 	= isset($_POST[$prefix.'circle_border_style'])		? ibwpl_clean($_POST[$prefix.'circle_border_style'])			: '';
		}
		
		// Circle Fill Clock Style Settings - circle-fill
		if( $data['timer_style'] == 'circle-fill' ) {
			$data['circle_bg_color'] 		= !empty($_POST[$prefix.'circle_bg_color'])			? ibwpl_clean_color($_POST[$prefix.'circle_bg_color'])		: '#ff9900';
		}

		// Inventory Product Stock Progress Bar Settings
		$data['stock_prog_bar'] 		= isset($_POST[$prefix.'stock_prog_bar'])			? 1 														: 0;
		if( $data['stock_prog_bar'] ) {
			$data['instock_text'] 			= !empty($_POST[$prefix.'instock_text'])			? ibwpl_clean($_POST[$prefix.'instock_text'])				: __('Just %s item left in stock','inboundwp-lite');
			$data['outofstock_text'] 		= !empty($_POST[$prefix.'outofstock_text'])			? ibwpl_clean($_POST[$prefix.'outofstock_text'])				: __('Out of stock','inboundwp-lite');
			$data['instock_color'] 			= !empty($_POST[$prefix.'instock_color'])			? ibwpl_clean_color($_POST[$prefix.'instock_color'])			: '#000000';
			$data['outofstock_color'] 		= !empty($_POST[$prefix.'outofstock_color'])		? ibwpl_clean_color($_POST[$prefix.'outofstock_color'])		: '#000000';
			$data['progress_bar_color'] 	= !empty($_POST[$prefix.'progress_bar_color'])		? ibwpl_clean_color($_POST[$prefix.'progress_bar_color'])	: '#DC3232';
		}

		if( !empty( $data ) ){
			foreach ($data as $mkey => $mval) {
				update_post_meta( $post_id, $prefix.$mkey, $mval );
			}
		}
	}

	/**
	 * Display the simple sale price field below the normal price field.
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	public function ibwpl_dcdt_add_edd_custom_fields( $post_id ) {

		$prefix 				= IBWPL_DCDT_META_PREFIX;
		$price 					= edd_get_download_price( $post_id );
		$sale_price				= get_post_meta( $post_id, $prefix.'edd_sale_price', true );
		$edd_sale_start_date	= get_post_meta( $post_id, $prefix.'edd_sale_start_date', true );
		$edd_sale_end_date		= get_post_meta( $post_id, $prefix.'edd_sale_end_date', true );
		$variable_pricing 		= edd_has_variable_prices( $post_id );
		$prices					= edd_get_variable_prices( $post_id );
		$single_option_mode		= edd_single_price_option_mode( $post_id );

		$price_display			= $variable_pricing ? ' style="display:none;"' 	: '';
		$variable_display		= $variable_pricing ? '' 						: ' style="display:none;"';
		?>

		<div id="edd_sale_price_field" class="edd_pricing_fields" <?php echo $price_display; ?>>
			<?php
				$price_args = array(
					'name'	=> $prefix.'edd_sale_price',
					'value' => ! empty( $sale_price ) ? esc_attr( edd_format_amount( $sale_price ) ) : '',
					'class'	=> 'edd-price-field edd-sale-price-field'
				);

				$currency_position = edd_get_option( 'currency_position' );
				if ( empty( $currency_position ) || $currency_position == 'before' ) :
					echo edd_currency_filter( '' ) . ' ' . EDD()->html->text( $price_args ) . ' ';
				else :
					echo EDD()->html->text( $price_args ) . ' ' . edd_currency_filter( '' ) . ' ';
				endif;

				_e( 'Sale price', 'inboundwp-lite' );
			?>
		</div>

		<div id="edd_sale_start_date_field" class="edd_pricing_fields" <?php echo $price_display; ?>>
			<?php
				$edd_sale_start_date 	= array(
					'name' 	=> $prefix.'edd_sale_start_date',
					'value'	=> !empty($edd_sale_start_date) ? esc_attr( $edd_sale_start_date ) : '',
					'class'	=> 'edd-sale-start-date',
					'id'	=> 'edd-sale-start-date'
				);

				echo EDD()->html->text($edd_sale_start_date);
				echo '&nbsp;&nbsp;';
				_e( 'Sale Start Date', 'inboundwp-lite' );
			?>
		</div>
		<div id="edd_sale_end_date_field" class="edd_pricing_fields" <?php echo $price_display; ?>>
			<?php
				$edd_sale_end_date 	= array(
					'name' 	=> $prefix.'edd_sale_end_date',
					'value'	=> !empty($edd_sale_end_date) ? esc_attr( $edd_sale_end_date ) : '',
					'class'	=> 'edd-sale-end-date',
					'id'	=> 'edd-sale-end-date'
				);

				echo EDD()->html->text($edd_sale_end_date);
				echo '&nbsp;&nbsp;';
				_e( 'Sale End Date', 'inboundwp-lite' );
			?>
		</div>

	<?php }

	/**
	 * Save the sale price by adding it to the EDD post
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	public function ibwpl_dcdt_save_edd_custom_fields( $fields ) {

		$prefix 	= IBWPL_DCDT_META_PREFIX;
		$fields[] 	= $prefix.'edd_sale_price';
		$fields[] 	= $prefix.'edd_sale_start_date';
		$fields[] 	= $prefix.'edd_sale_end_date';

		return $fields;
	}

	/**
	 * Add Timer start & end time field in Woocommerce Product General Tab
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	function ibwpl_dcdt_add_woo_custom_fields() {

		global $post;
		$prefix = IBWPL_DCDT_META_PREFIX;
		
		// Start Time field
		woocommerce_wp_text_input( 
			array( 
			  'id' 			=> $prefix.'start_time', 
			  'label' 		=> __( 'Start Time', 'inboundwp-lite' ),
			  'value'		=> get_post_meta( $post->ID, $prefix.'start_time', true ), 
			  'placeholder' => __( 'Choose Start Time', 'inboundwp-lite' ),
			  'desc_tip' 	=> 'true',
			  'description' => __( 'Set start time for Deal Coundown Timer.', 'inboundwp-lite' ),
			  'class'		=> 'dcdt-start-timepicker',
			)
		);

		// End Time field
		woocommerce_wp_text_input( 
			array( 
			  'id' 			=> $prefix.'end_time', 
			  'label' 		=> __( 'End Time', 'inboundwp-lite' ),
			  'value'		=> get_post_meta( $post->ID, $prefix.'end_time', true ),  
			  'placeholder' => __( 'Choose End Time', 'inboundwp-lite' ),
			  'desc_tip' 	=> 'true',
			  'description' => __( 'Set end time for Deal Coundown Timer.', 'inboundwp-lite' ),
			  'class'		=> 'dcdt-end-timepicker',
			)
		);
	}

	/**
	 * Save Timer start & end time field in Woocommerce Product General Tab
	 *
	 * @subpackage Deal Countdown Timer
	 * @since 1.0
	 */
	function ibwpl_dcdt_save_woo_custom_fields( $post_id ) {

	  	$prefix 	= IBWPL_DCDT_META_PREFIX;
	  	$timer_post = $_POST[$prefix.'timer_post'];
		$start_time = !empty($_POST[$prefix.'start_time']) 	? $_POST[$prefix.'start_time'] 	: current_time('H:i:s');
	  	$end_time	= !empty($_POST[$prefix.'end_time']) 	? $_POST[$prefix.'end_time'] 	: '23:59:59';

		if( ! empty( $start_time ) ) {
		 	update_post_meta( $post_id, $prefix.'start_time', esc_attr( $start_time ) );
		} else { 
			delete_post_meta( $post_id, $prefix.'start_time' );
		}

		if( ! empty( $end_time ) ) {
		 	update_post_meta( $post_id, $prefix.'end_time', esc_attr( $end_time ) );
		} else { 
			delete_post_meta( $post_id, $prefix.'end_time' );
		}
	}

	/**
	 * Function to add screen id
	 * 
	 * @subpackage Deal Countdown Timer
 	 * @since 1.0
	 */
	function ibwpl_dcdt_add_screen_id( $screen_ids ) {

		$screen_ids['main'][] = IBWPL_DCDT_POST_TYPE;

		return $screen_ids;
	}
}

$ibwpl_dcdt_admin = new Ibwpl_Dcdt_Admin();