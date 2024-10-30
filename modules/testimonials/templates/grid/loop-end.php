<?php
/**
 * Template for WP Testimonials with rotator widget Pro -Loop End
 *
 * This template can be overridden by copying it to yourtheme/inboundwp-lite/testimonials/grid/loop-end.php
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

	</div>
	<?php if( $pagination ) { ?>
		<div class="ibwp-tm-paging <?php echo 'ibwp-tm-'.$pagination_type; ?> ibwp-clearfix">
			<?php if( $pagination_type == "numeric" || ($multi_page && $pagination_type == "prev-next") ) {
				echo ibwpl_pagination( array('paged' => $paged, 'total' => $max_num_pages, 'multi_page' => $multi_page, 'pagination_type' => $pagination_type) );
			} else { ?>
				<div class="ibwp-tm-pagi-btn ibwp-tm-next-btn"><?php next_posts_link( __('Next', 'featured-and-trending-post').' &raquo;', $max_num_pages ); ?></div>
				<div class="ibwp-tm-pagi-btn ibwp-tm-prev-btn"><?php previous_posts_link( '&laquo; '.__('Previous', 'featured-and-trending-post') ); ?></div>
			<?php } ?>
		</div>
	<?php } ?>
</div>