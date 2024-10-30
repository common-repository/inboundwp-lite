<?php
/**
 * Widget Class
 *
 * Handles testimonial widget functionality of plugin
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function ibwpl_tm_testimonial_widget() {
	register_widget( 'ibwpl_tm_testimonials_widget' );
}

// Action to register widget
add_action( 'widgets_init', 'ibwpl_tm_testimonial_widget' );

class ibwpl_tm_testimonials_widget extends WP_Widget {

	var $defaults;

	/**
	 * Sets up a new widget instance.
	 *
	 * @since 1.0
	 */
	function __construct() {

		$widget_ops = array( 'classname' => 'widget_sp_testimonials', 'description' => esc_html__( 'Display testimonials on your site.', 'inboundwp-lite' ) );
		parent::__construct( 'sp_testimonials', esc_html__( 'Testimonials Slider', 'inboundwp-lite' ), $widget_ops );

		$this->defaults = array(
			'limit' 			=> 20,
			'orderby'			=> 'date',
			'order'				=> 'DESC',
			'title'				=> esc_html__( 'Testimonials', 'inboundwp-lite' ),
			'slides_column'		=> 1,
			'slides_scroll'		=> 1,
			'category'			=> '',
			'display_client'	=> 1,
			'display_avatar'	=> 1,
			'display_job'		=> 1,
			'display_company'	=> 1,
			'image_style'		=> 'circle',
			'design'			=> 'design-1',
			'dots'				=> "true",
			'arrows'			=> "true",
			'autoplay'			=> "true",
			'autoplay_interval'	=> 3000,
			'speed'				=> 300,
			'size'				=> 100,
		);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @since 1.0
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']				= sanitize_text_field( $new_instance['title'] );
		$instance['limit']				= ibwpl_clean_number( $new_instance['limit'], 20, 'number' );
		$instance['slides_column']		= ibwpl_clean_number( $new_instance['slides_column'], 1 );
		$instance['slides_scroll']		= ibwpl_clean_number( $new_instance['slides_scroll'], 1 );
		$instance['autoplay_interval']	= ibwpl_clean_number( $new_instance['autoplay_interval'], 3000 );
		$instance['speed']				= ibwpl_clean_number( $new_instance['speed'], 300 );
		$instance['size']				= ibwpl_clean_number( $new_instance['size'], 100 );
		$instance['orderby']			= !empty( $new_instance['orderby'] ) 				? $new_instance['orderby']	: 'post_date';
		$instance['order']				= ( strtolower( $new_instance['order'] ) == 'asc' ) ? 'ASC'						: 'DESC';
		$instance['category']			= $new_instance['category'];
		$instance['image_style']		= $new_instance['image_style'];
		$instance['design']				= $new_instance['design'];
		$instance['dots']				= $new_instance['dots'];
		$instance['arrows']				= $new_instance['arrows'];
		$instance['display_client']		= ( $new_instance['display_client'] == 1 ) 			? 1	: 0;
		$instance['display_avatar']		= ( $new_instance['display_avatar'] == 1 ) 			? 1 : 0;
		$instance['display_job']		= ( $new_instance['display_job'] == 1 ) 			? 1 : 0;
		$instance['display_company'] 	= ( $new_instance['display_company'] == 1 ) 		? 1 : 0;

		return $instance;
	}

	/**
	 * Outputs the settings form for the widget.
	 *
	 * @since 1.0
	 */
	function form( $instance ) {
		$instance 		= wp_parse_args( (array) $instance, $this->defaults );
		$wtwp_designs 	= ibwpl_tm_designs();
	?>

		<!-- Widget title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo esc_attr($instance['title']); ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>

		<!-- Widget design -->
		<p>
			<label for="<?php echo $this->get_field_id( 'design' ); ?>"><?php _e( 'Design', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'design' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'design' ); ?>">
				<?php if( !empty($wtwp_designs) ) {
					foreach ( $wtwp_designs as $k => $v ) { ?>
						<option value="<?php echo $k; ?>"<?php selected( $instance['design'], $k ); ?>><?php echo $v; ?></option>
				<?php } } ?>
			</select><br/>
			<em><?php _e('Select testimonial design. Note: Some design will not look good in a small area of widget.', 'inboundwp-lite'); ?></em>
		</p>

		<!-- Widget limit -->
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'limit' ); ?>"  value="<?php echo $instance['limit']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" />
		</p>

		<!-- Widget order by -->
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>">
				<option value="date" <?php selected( $instance['orderby'], 'date' ); ?>><?php esc_html_e( 'Date', 'inboundwp-lite' ); ?></option>
				<option value="modified" <?php selected( $instance['orderby'], 'modified' ); ?>><?php esc_html_e( 'Modified Date', 'inboundwp-lite' ); ?></option>
				<option value="title" <?php selected( $instance['orderby'], 'title' ); ?>><?php esc_html_e( 'Testimonial Title', 'inboundwp-lite' ); ?></option>
				<option value="name" <?php selected( $instance['orderby'], 'name' ); ?>><?php esc_html_e( 'Testimonial URL Slug', 'inboundwp-lite' ); ?></option>
				<option value="ID" <?php selected( $instance['orderby'], 'ID' ); ?>><?php esc_html_e( 'ID', 'inboundwp-lite' ); ?></option>
				<option value="author" <?php selected( $instance['orderby'], 'author' ); ?>><?php esc_html_e( 'Author', 'inboundwp-lite' ); ?></option>
				<option value="rand" <?php selected( $instance['orderby'], 'rand' ); ?>><?php esc_html_e( 'Random', 'inboundwp-lite' ); ?></option>
				<option value="menu_order" <?php selected( $instance['orderby'], 'menu_order' ); ?>><?php esc_html_e( 'Menu Order (Sort Order)', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget order -->
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>">
				<option value="ASC" <?php selected( $instance['order'], 'asc' ); ?>><?php esc_html_e( 'Ascending', 'inboundwp-lite' ); ?></option>
				<option value="DESC" <?php selected( $instance['order'], 'desc' ); ?>><?php esc_html_e( 'Descending', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget category -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'inboundwp-lite' ); ?></label>
			<?php
				$dropdown_args = array(
					'hide_empty' 		=> 0, 
					'taxonomy' 			=> IBWPL_TM_CAT,
					'class' 			=> 'widefat',
					'show_option_all' 	=> __( 'All', 'inboundwp-lite' ),
					'id' 				=> $this->get_field_id( 'category' ),
					'name' 				=> $this->get_field_name( 'category' ),
					'selected' 			=> $instance['category']
				);
				wp_dropdown_categories( $dropdown_args );
			?>
		</p>

		<!-- Widget image size -->
		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image Size', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'size' ); ?>"  value="<?php echo $instance['size']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'slides_column' ); ?>" />
		</p>

		<!-- Widget slides column -->
		<p>
			<label for="<?php echo $this->get_field_id( 'slides_column' ); ?>"><?php _e( 'Slides Column', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'slides_column' ); ?>"  value="<?php echo $instance['slides_column']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'slides_column' ); ?>" />
		</p>

		<!-- Widget slides scroll -->
		<p>
			<label for="<?php echo $this->get_field_id( 'slides_scroll' ); ?>"><?php _e( 'Slides to Scroll', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'slides_scroll' ); ?>"  value="<?php echo $instance['slides_scroll']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'slides_scroll' ); ?>" />
		</p>

		<!-- Widget dots-->
		<p>
			<label for="<?php echo $this->get_field_id( 'dots' ); ?>"><?php _e( 'Dots', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'dots' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'dots' ); ?>">
				<option value="true" <?php selected( $instance['dots'], 'true' ); ?>><?php _e( 'True', 'inboundwp-lite' ); ?></option>
				<option value="false" <?php selected( $instance['dots'], 'false' ); ?>><?php _e( 'False', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget arrows -->
		<p>
			<label for="<?php echo $this->get_field_id( 'arrows' ); ?>"><?php _e( 'Arrows', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'arrows' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'arrows' ); ?>">
				<option value="true" <?php selected( $instance['arrows'], 'true' ); ?>><?php _e( 'True', 'inboundwp-lite' ); ?></option>
				<option value="false" <?php selected( $instance['arrows'], 'false' ); ?>><?php _e( 'False', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget autoplay -->
		<p>
			<label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Auto Play', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'autoplay' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay' ); ?>">
				<option value="true" <?php selected( $instance['autoplay'], 'true' ); ?>><?php _e( 'True', 'inboundwp-lite' ); ?></option>
				<option value="false" <?php selected( $instance['autoplay'], 'false' ); ?>><?php _e( 'False', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget autoplay interval -->
		<p>
			<label for="<?php echo $this->get_field_id( 'autoplay_interval' ); ?>"><?php _e( 'Autoplay Interval', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'autoplay_interval' ); ?>"  value="<?php echo $instance['autoplay_interval']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'autoplay_interval' ); ?>" />
		</p>

		<!-- Widget speed -->
		<p>
			<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Speed', 'inboundwp-lite' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'speed' ); ?>"  value="<?php echo $instance['speed']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" />
		</p>

		<!-- Widget image style -->
		<p>
			<label for="<?php echo $this->get_field_id( 'image_style' ); ?>"><?php _e( 'Image Style', 'inboundwp-lite' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'image_style' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'image_style' ); ?>">
				<option value="circle" <?php selected( $instance['image_style'], 'circle' ); ?>><?php _e( 'Circle', 'inboundwp-lite' ); ?></option>
				<option value="square" <?php selected( $instance['image_style'], 'square' ); ?>><?php _e( 'Square', 'inboundwp-lite' ); ?></option>
			</select>
		</p>

		<!-- Widget display avatar -->
		<p>
			<input id="<?php echo $this->get_field_id( 'display_avatar' ); ?>" name="<?php echo $this->get_field_name( 'display_avatar' ); ?>" type="checkbox" value="1" <?php checked($instance['display_avatar'], 1); ?> />
			<label for="<?php echo $this->get_field_id( 'display_avatar' ); ?>"><?php _e( 'Display Avatar', 'inboundwp-lite' ); ?></label>
		</p>

		<!-- Widget display client -->
		<p>
			<input id="<?php echo $this->get_field_id( 'display_client' ); ?>" name="<?php echo $this->get_field_name( 'display_client' ); ?>" type="checkbox" value="1" <?php checked( $instance['display_client'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'display_client' ); ?>"><?php _e( 'Display Client', 'inboundwp-lite' ); ?></label>
		</p>

		<!-- Widget display job -->
		<p>
			<input id="<?php echo $this->get_field_id( 'display_job' ); ?>" name="<?php echo $this->get_field_name( 'display_job' ); ?>" type="checkbox" value="1" <?php checked($instance['display_job'], 1); ?> />
			<label for="<?php echo $this->get_field_id( 'display_job' ); ?>"><?php _e( 'Display Job', 'inboundwp-lite' ); ?></label>
		</p>

		<!-- Widget display company -->
		<p>
			<input id="<?php echo $this->get_field_id( 'display_company' ); ?>" name="<?php echo $this->get_field_name( 'display_company' ); ?>" type="checkbox" value="1" <?php checked($instance['display_company'], 1); ?> />
			<label for="<?php echo $this->get_field_id( 'display_company' ); ?>"><?php _e( 'Display Company', 'inboundwp-lite' ); ?></label>
		</p>

<?php } // End form()

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.0
	 */
	function widget( $args, $instance ) {

		$atts = wp_parse_args( (array) $instance, $this->defaults );
		extract( $args, EXTR_SKIP );

		$shortcode_designs 		= ibwpl_tm_designs();
		$atts['title'] 			= empty( $atts['title'] ) ? '' : apply_filters( 'widget_title', $atts['title'] );
		$atts['cat'] 			= ( !empty( $atts['category'] ) ) ? explode( ',',$atts['category'] )	: '';
		$atts['design'] 		= ( $atts['design'] && ( array_key_exists( trim( $atts['design'] ), $shortcode_designs ) ) ) ? trim( $atts['design'] )	: 'design-1';
		$atts['image_style'] 	= ( $atts['image_style'] == 'circle' ) ? 'ibwp-tm-circle' : 'ibwp-tm-square';

		// Extract Shortcode Var
		extract($atts);

		// Enqueing required script
		wp_enqueue_script( 'wpos-slick-jquery' );
		wp_enqueue_script( 'ibwp-tm-public-script' );

		// Taking some globals
		global $post;

		// Taking some variables
		$prefix 			= IBWPL_TM_META_PREFIX;
		$atts['unique'] 	= ibwpl_get_unique();
		$atts['main_wrap']	= "ibwp-tm-{$design}";

		// Query Parameter
		$args = array (
			'post_type'				=> IBWPL_TM_POST_TYPE,
			'post_status'			=> array( 'publish' ),
			'posts_per_page'		=> $limit,
			'order'					=> $order,
			'orderby'				=> $orderby,
			'ignore_sticky_posts'	=> true,
		);

		// Category Parameter
		if($cat != "") {

			$args['tax_query'] = array(
									array(
										'taxonomy'	=> IBWPL_TM_CAT,
										'field'		=> 'term_id',
										'terms'		=> $cat
									));
		}

		// WP Query
		$query		= new WP_Query($args);
		$post_count = $query->post_count;
		
		// Slider configuration column
		$slides_column = (!empty($slides_column) && $slides_column <= $post_count) ? $slides_column : $post_count;

		// Slider Configuration
		$atts['slider_conf'] = compact( 'slides_column', 'slides_scroll', 'dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed' );

		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		// If post is there
		if( $query->have_posts() ) {

			ibwpl_get_template( IBWPL_TM_DIR_NAME, "widgets/loop-start.php", $atts ); // loop start

			while ( $query->have_posts() ) : $query->the_post();

				$job_data					= array();
				$atts['author_image']		= ibwpl_tm_get_image( $post->ID, $size, $image_style );
				$atts['author'] 			= get_post_meta( $post->ID, '_testimonial_client', true );
				$atts['job_title']			= get_post_meta( $post->ID, '_testimonial_job', true );
				$atts['company'] 			= get_post_meta( $post->ID, '_testimonial_company', true );
				$atts['url']				= get_post_meta( $post->ID, '_testimonial_url', true );
				$atts['rating'] 			= get_post_meta( $post->ID, $prefix.'rating', true );
				$atts['testimonial_title'] 	= get_the_title();
				$atts['css_class'] 			= 'ibwp-tm-quote';

				// Add a CSS class if no image is available.
				if( empty( $atts['author_image'] ) ) {
					$atts['css_class'] .= ' ibwp-tm-no-image';
				}

				// Testimonial Meta
				if( $display_job && $atts['job_title'] ) {
					$job_data[] = $atts['job_title'];
				}
				if( $display_company && $atts['company'] ) {
					$job_data[] = !empty( $atts['url'] ) ? '<a href="'.esc_url( $atts['url'] ).'" target="_blank">'.$atts['company'].'</a>' : $atts['company'];
				}
				$atts['job_meta'] = join( ' / ', $job_data );

				// Design Template
				ibwpl_get_template( IBWPL_TM_DIR_NAME, "widgets/{$design}.php", $atts, null, null, "designs/{$design}.php" );

			endwhile;

			ibwpl_get_template( IBWPL_TM_DIR_NAME, "widgets/loop-end.php", $atts ); // Loop End

		} // End of have_post()

		wp_reset_postdata(); // Reset WP Query

		echo $after_widget;
	}
}