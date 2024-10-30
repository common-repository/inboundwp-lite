<?php 
/**
 * Template for Design 2
 *
 * This template can be overridden by copying it to yourtheme/inboundwp-lite/testimonials/designs/design-2.php
 *
 * If you want to override for grid only then put it into 'grid' folder and same for respective.
 *
 * @package InboundWP Lite
 * @subpackage Testimonials
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

global $post; ?>

<div id="ibwp-tm-quote-<?php echo $post->ID; ?>" class="<?php echo $css_class; ?>">
	<div class="ibwp-tm-testimonial-left">
		<?php if ( $author_image && $display_avatar ) { ?>
		<div class="ibwp-tm-avtar-image"><?php echo $author_image;?></div>
		<?php }

		if($display_client && $author != ''){ ?>
		<div class="ibwp-tm-testimonial-author"><strong><?php echo $author; ?></strong></div>
		<?php }

		if( $job_meta ) { ?>
		<div class="ibwp-tm-testimonial-job"><?php echo $job_meta; ?></div>
		<?php }

		if( ! empty( $rating ) ) { ?>
		<div class="ibwp-tm-testimonial-rating">
			<?php for ($i=0; $i<5; $i++) {
				if( $i < $rating ){
					echo '<i class="fa fa-star"></i>';
				} else {
					echo '<i class="fa fa-star-o"></i>';
				}
			} ?>
		</div>
		<?php } ?>
	</div>

	<div class="ibwp-tm-testimonial-content">
		<div class="ibwp-tm-testimonial-title"><?php echo $testimonial_title; ?></div>
		<div class="ibwp-tm-testimonials-text"><em><?php echo get_the_content(); ?></em></div>
	</div>
</div>