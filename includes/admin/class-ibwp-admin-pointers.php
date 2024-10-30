<?php
/**
 * Adds and controls pointers for contextual help/tutorials
 *
 * @package InboundWP Lite
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class IBWP_Lite_Admin_Pointers {

	public function __construct() {

		// Action to print script at footer
		add_action( 'admin_footer', array($this, 'ibwpl_setup_pointers_for_screen'), 25 );
	}

	/**
	 * Setup pointers for screen.
	 */
	public function ibwpl_setup_pointers_for_screen() {
		if ( ! $screen = get_current_screen() ) {
			return;
		}

		if( $screen->id == 'toplevel_page_ibwp-dashboard' ) {
			$this->ibwpl_product_help_tutorial();
		}
	}

	/**
	 * Pointers for creating a product.
	 */
	public function ibwpl_product_help_tutorial() {
		
		if ( isset($_GET['message']) && $_GET['message'] == 'ibwp-tutorial' && !isset($_GET['settings-updated']) && current_user_can('manage_options') ) {
			
			// These pointers will chain - they will not be shown at once.
			$pointers = array(
				'pointers' => array(
					'title' => array(
						'target'       	=> ".ibwp-dashboard-header",
						'previous'		=> '',
						'next'         	=> 'search',
						'next_trigger'	=> array(),
						'options'      	=> array(
							'content' 	=> '<h3>' . esc_html__( 'Welcome to InboundWP Lite', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'You are about to use most powerful plugin for WordPress ever - With most popular modules for frontend and backend by WP OnlineSupport.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'top',
								'align' => 'left',
							),
						),
					),
					'search' => array(
						'target'       => ".ibwp-dashboard-search-icon",
						'next'         => 'active-module',
						'previous'		=> 'title',
						'next_trigger' => array(),
						'options'      => array(
							'content'  => '<h3>' . esc_html__( 'Module Search', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'You can easily search your favourite modules by clicking the search icon.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Start typing module name and it will pick module within current tab.', 'inboundwp-lite' ) . '</p>',
							'position' => array(
								'edge'  => 'right',
								'align' => 'left',
							),
						),
					),
					'active-module' => array(
						'target'       	=> "#ibwp-module-nav-active_modules",
						'next'         	=> 'modules',
						'previous'		=> 'search',
						'next_trigger' 	=> array(),
						'options'  		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Modules Categories - Active Modules', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'These are the various categories of modules. e.g Site modules, Styling modules and etc.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'This is the Active module category. Your activated modules will be displayed over here.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'So you do not have to find active modules from each tab. You can easily manipulate over here.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'left',
								'align' => 'left',
							),
						),
					),
					'modules' => array(
						'target'       	=> "#ibwp-module-nav-modules",
						'next'         	=> 'site-module',
						'previous'		=> 'active-module',
						'next_trigger' 	=> array(),
						'options' 		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Site Modules', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'This is the site modules category.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Here you can see various modules like Better Heading, Spin Wheel, Marketing Popup, Social Proof or etc.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'You can find with search functionality.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'left',
								'align' => 'left',
							),
						),
					),
					'site-module' => array(
						'target'       	=> ".ibwp-site-modules-wrap .ibwp-site-module-wrap:first",
						'next'         	=> 'activate_module',
						'previous'		=> 'modules',
						'next_trigger' 	=> array(),
						'options' 		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Site Module', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'This one of the site module. e.g Better Heading', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Module holds its respective name and description so you will be cleared from that.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'You can find more information about it by hovering the mouse on info button.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'bottom',
								'align' => 'middle',
							),
						),
					),
					'activate_module' => array(
						'target'       	=> ".ibwp-site-modules-wrap .ibwp-site-module-wrap:first .ibwp-check-slider",
						'next'         	=> 'save_module',
						'previous'		=> 'site-module',
						'next_trigger' 	=> array(),
						'options' 		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Enable Module!', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'This is enable / disabled switch of module.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Once you click, It will be turned to green means a sign of activation.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Once you click module do not forget to save from top right \'Save Changes\' button.', 'inboundwp-lite' ) . '</p>' .
											'<p>' . esc_html__( 'Once module is enabled, it\'s respective menu will be appeared at admin side. e.g If you enable Better Heading then Better Heading - IBWP menu will be appeared.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'left',
								'align' => 'left',
							),
						),
					),
					'save_module' => array(
						'target'       	=> "#ibwp-save-module-btn",
						'next'         	=> 'reset_module',
						'previous'		=> 'activate_module',
						'next_trigger' 	=> array(),
						'options' 		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Save Settings', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'When you enable / disable module, hit the "Save Changes" button to make it live.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'right',
								'align' => 'right',
							),
						),
					),
					'reset_module' => array(
						'target'       	=> "#ibwp-resett-module-btn",
						'next'         	=> '',
						'previous'		=> 'save_module',
						'next_trigger' 	=> array(),
						'options' 		=> array(
							'content'  	=> '<h3>' . esc_html__( 'Reset Settings', 'inboundwp-lite' ) . '</h3>' .
											'<p>' . esc_html__( 'Deactive all modules at just one click.', 'inboundwp-lite' ) . '</p>',
							'position' 	=> array(
								'edge'  => 'right',
								'align' => 'right',
							),
						),
					),
				),
			);
			$this->ibwpl_enqueue_pointers( $pointers );
		} // End of if
	}

	/**
	 * Adds pointer scripts
	 *
	 * @package InboundWP Lite
	 * @since 1.0
	 */
	public function ibwpl_enqueue_pointers( $pointers ) {
		$pointers 		= wp_json_encode( $pointers );
		$dismis_btn 	= '<a style="padding:0 0 0 10px;" class="ibwp-close-help" href="#"><i class="dashicons dashicons-dismiss"></i> '.__('Dismiss', 'inboundwp-lite').'</a>';
		$prev_btn 		= '<a style="padding:0 10px 0 0;" class="ibwp-prev-help" href="#"><i class="dashicons dashicons-arrow-left-alt"></i> '.__('Previous', 'inboundwp-lite').'</a>';
		$next_btn 		= '<a style="padding:0 10px 0 0;" class="ibwp-next-help" href="#"><i class="dashicons dashicons-arrow-right-alt"></i> '.__('Next', 'inboundwp-lite').'</a>';

		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );

		echo "<script type='text/javascript'>
			jQuery( function( $ ) {
				var prev 	= 0;
				var closed 	= 0;
				var count 	= 1;
				var ibwp_pointers = {$pointers};

				setTimeout( init_ibwpl_pointers, 800 );

				function init_ibwpl_pointers() {
					$.each( ibwp_pointers.pointers, function( i ) {
						show_ibwpl_pointer( i );
						count++;
						return false;
					});
				}

				function show_ibwpl_pointer( id ) {
					var pointer = ibwp_pointers.pointers[ id ];
					var options = $.extend( pointer.options, {
						buttons: function( event, t ) {

							if( count == 1 ) {
								var button = $('<div>{$dismis_btn} {$next_btn}</div>');
							} else if( pointer.next && pointer.previous ) {
								var button = $('<div>{$dismis_btn} {$next_btn} {$prev_btn}</div>');
							} else if( pointer.next ) {
								var button = $('<div>{$dismis_btn} {$next_btn}</div>');
							} else {
								var button = $('<div>{$dismis_btn} {$prev_btn}</div>');
							}

							return button.bind( 'click.pointer', function(e) {
								e.preventDefault();

								if( $(e.target).hasClass('ibwp-prev-help') || $(e.target).hasClass('dashicons-arrow-left-alt') ) {
									prev = 1;
								} else {
									prev = 0;
								}

								if( $(e.target).hasClass('ibwp-close-help') || $(e.target).hasClass('dashicons-dismiss') ) {
									closed = 1;
								}

								t.element.pointer('close');
							});
						},
						close: function() {
							if ( pointer.previous && prev ) {
								show_ibwpl_pointer( pointer.previous );
							} else if ( pointer.next && !closed ) {
								show_ibwpl_pointer( pointer.next );
							}
						}
					});
					var this_pointer = $( pointer.target ).pointer( options );
					this_pointer.pointer( 'open' );

					if ( pointer.next_trigger ) {
						$( pointer.next_trigger.target ).on( pointer.next_trigger.event, function() {
							setTimeout( function() { this_pointer.pointer( 'close' ); }, 400 );
						});
					}
				}
			});
		</script>";
	}
}

$ibwp_lite_admin_pointers = new IBWP_Lite_Admin_Pointers();