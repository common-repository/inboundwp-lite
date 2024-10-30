<?php
/**
 * Handles Content Setting metabox HTML
 * 
 * @package InboundWP Lite
 * @subpackage Social Proof
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$pre_nf_data	= array( 0 => '' );
$content		= get_post_meta( $post->ID, $prefix.'content', true );
$custom_nf		= get_post_meta( $post->ID, $prefix.'custom_nf', true );

// Taking some variables
$custom_nf			= ! empty( $custom_nf )						? $custom_nf					: $pre_nf_data;
$link_type			= isset( $content['link_type'] )			? $content['link_type']			: '';
$custom_link		= isset( $content['custom_link'] )			? $content['custom_link']		: '';
$nf_image			= isset( $content['nf_image'] )				? $content['nf_image']			: '';
$nf_template		= ! empty( $content['nf_template'] )		? $content['nf_template']		: "{name} from {country} just purchased\n{title}\nAbout {time} ago";
?>

<div id="ibwp_sp_content_sett" class="ibwp-vtab-cnt ibwp-sp-content-sett ibwp-clearfix">

	<div class="ibwp-tab-info-wrap">
		<div class="ibwp-tab-title"><?php esc_html_e('Content Settings', 'inboundwp-lite'); ?></div>
		<span class="ibwp-tab-desc"><?php esc_html_e('Choose Social Proof content settings.', 'inboundwp-lite'); ?></span>
	</div>

	<table class="form-table ibwp-tbl">
		<tbody>
			<tr>
				<th>
					<label for="ibwp-sp-noti-templ"><?php _e('Notification Template', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<textarea class="ibwp-textarea large-text ibwp-sp-noti-templ" id="ibwp-sp-noti-templ" name="<?php echo $prefix; ?>content[nf_template]"><?php echo esc_textarea( $nf_template ); ?></textarea><br/>
					<span class="description"><?php _e('Set notificaton template layout. Available template tags are :', 'inboundwp-lite'); ?></span><br/>
					<div class="ibwp-code-tag-wrap">
						<code class="ibwp-copy-clipboard">{title}</code> - <span class="description"><?php _e('Display product title.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{name}</code> - <span class="description"><?php _e('Display user name.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{city}</code> - <span class="description"><?php _e('Display city.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{state}</code> - <span class="description"><?php _e('Display state.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{country}</code> - <span class="description"><?php _e('Display country.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{time}</code> -  <span class="description"><?php _e('Display time.', 'inboundwp-lite'); ?></span><br/>
						<code class="ibwp-copy-clipboard">{rating}</code> -  <span class="description"><?php _e('Display product rating.', 'inboundwp-lite'); ?></span>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-image"><?php _e('Notification Image', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[nf_image]" class="ibwp-select ibwp-sp-nf-image" id="ibwp-sp-nf-image">
						<option value="product_image" <?php selected( $nf_image, 'product_image' ); ?>><?php echo esc_html('Product Image', 'inboundwp-lite'); ?></option>
						<option value="" disabled><?php echo esc_html('Gravatar (User Email)', 'inboundwp-lite'); ?></option>
						<option value="" disabled><?php echo esc_html('First Two Character (Username OR Product Title)', 'inboundwp-lite'); ?></option>
						<option value="" disabled><?php echo esc_html('No Image', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php _e('select notification image type.', 'inboundwp-lite'); ?></span><br/>
					<span class="description ibwp-pro-feature"><?php echo __('If you want to more options. ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-nf-link-type"><?php _e('Notification Link Type', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[link_type]" class="ibwp-select large-text ibwp-show-hide ibwp-sp-nf-link-type" id="ibwp-sp-nf-link-type" data-prefix="lt">
						<option value="" <?php selected( $link_type, '' ); ?>><?php echo esc_html('None', 'inboundwp-lite'); ?></option>
						<option value="product" <?php selected( $link_type, 'product' ); ?>><?php echo esc_html('Product', 'inboundwp-lite'); ?></option>
						<option value="custom_url" <?php selected( $link_type, 'custom_url' ); ?>><?php echo esc_html('Custom', 'inboundwp-lite'); ?></option>
					</select><br/>
					<span class="description"><?php _e('Select notification link type.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-show-hide-row-lt ibwp-show-if-lt-custom_url" style="<?php if( $link_type != 'custom_url' ) { echo 'display: none;'; } ?>">
				<th>
					<label for="ibwp-sp-nf-link"><?php _e('Custom URL', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>content[custom_link]" value="<?php echo ibwpl_esc_attr( $custom_link ); ?>" class="ibwp-text large-text ibwp-sp-nf-link" id="ibwp-sp-nf-link" /><br/>
					<span class="description"><?php _e('Enter custom URL for notification.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
		</tbody>
	</table>

	<!-- Start - Custom Notifiction -->
	<table class="form-table ibwp-tbl ibwp-show-hide-row ibwp-show-if-custom ibwp-sp-custom-nf-tbl" style="<?php if( $source_type != 'custom' ) { echo 'display: none;'; } ?>">
		<tbody>
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php _e('Custom Notification Settings', 'inboundwp-lite'); ?></div>
				</th>
			</tr>
			<tr class="ibwp-sp-custom-nf-row-wrp">
				<td class="ibwp-no-padding">
					<?php foreach ( $custom_nf as $custom_nf_key => $custom_nf_data ) {

						// Taking some variable
						$title		= ! empty( $custom_nf_data['title'] )	? $custom_nf_data['title']		: '';
						$name		= ! empty( $custom_nf_data['name'] )	? $custom_nf_data['name']		: '';
						$email		= ! empty( $custom_nf_data['email'] )	? $custom_nf_data['email']		: '';
						$city		= ! empty( $custom_nf_data['city'] )	? $custom_nf_data['city']		: '';
						$state		= ! empty( $custom_nf_data['state'] )	? $custom_nf_data['state']		: '';
						$country	= ! empty( $custom_nf_data['country'] )	? $custom_nf_data['country']	: '';
						$image		= ! empty( $custom_nf_data['image'] )	? $custom_nf_data['image']		: '';
						$url		= ! empty( $custom_nf_data['url'] )		? $custom_nf_data['url']		: '';
						$time		= ! empty( $custom_nf_data['time'] )	? $custom_nf_data['time']		: '';
						$rating		= ! empty( $custom_nf_data['rating'] )	? $custom_nf_data['rating']		: '';
					?>
						<div class="ibwp-sp-custom-nf-row-inr" data-key="<?php echo ibwpl_esc_attr( $custom_nf_key ); ?>">
							<div class="ibwp-sp-custom-nf-header">								
								<span class="ibwp-sp-custom-nf-row-actions">
									<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-sett ibwp-tooltip" title="<?php esc_html_e('Show / Hide settings', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-admin-generic"></i></span>
									<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-add ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
									<?php if( $custom_nf_key > 0 ) { ?>
										<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-delete ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
									<?php } ?>
									<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-drag ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
								</span>
								<div class="ibwp-sp-custom-nf-ttl">
									<?php echo esc_html_e('Notification', 'inboundwp-lite'); ?> <span class="ibwp-sp-custom-nf-no"></span>
								</div>
							</div>

							<div class="ibwp-sp-custom-nf-row-data">
								<table class="form-table ibwp-tbl">
									<tbody>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-title-<?php echo $custom_nf_key; ?>"><?php _e('Title', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][title]" value="<?php echo ibwpl_esc_attr( $title ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-title" id="ibwp-sp-custom-nf-title-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter product title.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-name-<?php echo $custom_nf_key; ?>"><?php _e('Customer Name', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][name]" value="<?php echo ibwpl_esc_attr( $name ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-name" id="ibwp-sp-custom-nf-name-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter product customer name.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-email-<?php echo $custom_nf_key; ?>"><?php _e('Email Address', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][email]" value="<?php echo ibwpl_esc_attr( $email ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-email" id="ibwp-sp-custom-nf-email-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter product customer email address.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-city-<?php echo $custom_nf_key; ?>"><?php _e('City', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][city]" value="<?php echo ibwpl_esc_attr( $city ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-city" id="ibwp-sp-custom-nf-city-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter customer city.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-state-<?php echo $custom_nf_key; ?>"><?php _e('State', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][state]" value="<?php echo ibwpl_esc_attr( $state ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-state" id="ibwp-sp-custom-nf-state-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter customer state.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-country-<?php echo $custom_nf_key; ?>"><?php _e('Country', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][country]" value="<?php echo ibwpl_esc_attr( $country ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-country" id="ibwp-sp-custom-nf-country-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter customer country.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-image-<?php echo $custom_nf_key; ?>"><?php _e('Image', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo $prefix; ?>custom_nf[<?php echo $custom_nf_key; ?>][image]" value="<?php echo ibwpl_esc_attr( $image ); ?>" class="regular-text ibwp-url ibwp-sp-nf-img ibwp-img-upload-input" id="ibwp-sp-nf-img-<?php echo $custom_nf_key; ?>" />
												<input type="button" name="ibwp_sp_nf_img" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" />
												<input type="button" name="ibwp_sp_nf_img_clear" id="ibwp-sp-url-clear-<?php echo $custom_nf_key; ?>" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>"  data-pdt-preview="1" /> <br />
												<span class="description"><?php _e('Choose product image.', 'inboundwp-lite'); ?></span>
												<?php
													$image_preview = '';
													if( $image != '' ) {
														$image_preview = '<img src="'.esc_url( $image ).'" alt="" />';
													}
												?>
												<div class="ibwp-img-view"><?php echo $image_preview; ?></div>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-url-<?php echo $custom_nf_key; ?>"><?php _e('URL', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][url]" value="<?php echo ibwpl_esc_attr( $url ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-url" id="ibwp-sp-custom-nf-url-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter product url.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-time-<?php echo $custom_nf_key; ?>"><?php _e('Purchase Time', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][time]" value="<?php echo ibwpl_esc_attr( $time ); ?>" class="ibwp-text large-text ibwp-sp-custom-nf-time" id="ibwp-sp-custom-nf-time-<?php echo $custom_nf_key; ?>" /><br/>
												<span class="description"><?php _e('Enter product purchase time. e.g 2 days OR 10 minute', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
										<tr>
											<th>
												<label for="ibwp-sp-custom-nf-rating-<?php echo $custom_nf_key; ?>"><?php _e('Rating', 'inboundwp-lite'); ?></label>
											</th>
											<td>
												<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[<?php echo $custom_nf_key; ?>][rating]" class="ibwp-select ibwp-sp-custom-nf-rating" id="ibwp-sp-custom-nf-rating-<?php echo $custom_nf_key; ?>">
													<option value=""><?php esc_html_e('Select Rating', 'inboundwp-lite'); ?></option>
													<option value="1" <?php selected( $rating, 1 ); ?>>1</option>
													<option value="2" <?php selected( $rating, 2 ); ?>>2</option>
													<option value="3" <?php selected( $rating, 3 ); ?>>3</option>
													<option value="4" <?php selected( $rating, 4 ); ?>>4</option>
													<option value="5" <?php selected( $rating, 5 ); ?>>5</option>
												</select><br/>
												<span class="description"><?php _e('Select rating.', 'inboundwp-lite'); ?></span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div><!-- end .ibwp-sp-custom-nf-row-inr -->
					<?php } ?>
				</td>
			</tr><!-- end .ibwp-sp-custom-nf-row-wrp -->
		</tbody>
	</table>
	<!-- End - Custom Notifiction -->

	<!-- Start - Restriction Settings -->
	<table class="form-table ibwp-tbl ibwp-pro-feature">
		<tbody>
			<tr>
				<th colspan="2">
					<div class="ibwp-sub-sett-title"><i class="dashicons dashicons-admin-generic"></i> <?php echo __('Notification Restriction Settings ', 'inboundwp-lite') . ibwpl_upgrade_pro_link(); ?></div>
				</th>
			</tr>
			<tr>
				<th>
					<label for="ibwp-sp-rating"><?php _e('Minimum Rating', 'inboundwp-lite'); ?></label>
				</th>
				<td>
					<input type="text" name="" value="" class="ibwp-text ibwp-sp-rating" id="ibwp-sp-rating" disabled /><br/>
					<span class="description"><?php _e('Enter number of rating to show notification with given and greater product rating.', 'inboundwp-lite'); ?></span>
				</td>
			</tr>
			<tr class="ibwp-show-hide-row ibwp-show-if-woocommerce" style="<?php if( $source_type != 'woocommerce' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th>
								<label for="ibwp-sp-nf-wc-prd-inc"><?php _e('Products Include', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<select name="" class="ibwp-select2 ibwp-select2-mul ibwp-sp-nf-wc-prd-inc" id="ibwp-sp-nf-wc-prd-inc" data-placeholder="<?php esc_html_e('Select Products', 'inboundwp-lite'); ?>" multiple="multiple" style="width: 99%;" disabled>
									<option></option>
								</select><br/>
								<span class="description"><?php _e('Choose prodcuts to show notification related to selected products only.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-sp-nf-wc-prd-exc"><?php _e('Products Exclude', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<select name="" class="ibwp-select2 ibwp-select2-mul ibwp-sp-nf-wc-prd-exc" id="ibwp-sp-nf-wc-prd-exc" data-placeholder="<?php esc_html_e('Select Products', 'inboundwp-lite'); ?>" multiple="multiple" style="width: 99%;" disabled>
									<option></option>
								</select><br/>
								<span class="description"><?php _e('Choose prodcuts to hide notification related to selected products only.', 'inboundwp-lite'); ?></span><br/>
								<span class="description"><?php _e('Note: This only works if `Products Include` settings is not set.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="ibwp-show-hide-row ibwp-show-if-edd" style="<?php if( $source_type != 'edd' ) { echo 'display: none;'; } ?>">
				<td colspan="2" class="ibwp-no-padding">
					<table class="form-table">
						<tr>
							<th>
								<label for="ibwp-sp-nf-edd-prd-inc"><?php _e('Products Include', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<select name="" class="ibwp-select2 ibwp-select2-mul ibwp-sp-nf-edd-prd-inc" id="ibwp-sp-nf-edd-prd-inc" data-placeholder="<?php esc_html_e('Select Products', 'inboundwp-lite'); ?>" multiple="multiple" style="width: 99%;" disabled>
									<option></option>
								</select><br/>
								<span class="description"><?php _e('Choose prodcuts to show notification related to selected products only.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
						<tr>
							<th>
								<label for="ibwp-sp-nf-edd-prd-exc"><?php _e('Products Exclude', 'inboundwp-lite'); ?></label>
							</th>
							<td>
								<select name="" class="ibwp-select2 ibwp-select2-mul ibwp-sp-nf-edd-prd-exc" id="ibwp-sp-nf-edd-prd-exc" data-placeholder="<?php esc_html_e('Select Products', 'inboundwp-lite'); ?>" multiple="multiple" style="width: 99%;" disabled>
									<option></option>
								</select><br/>
								<span class="description"><?php _e('Choose prodcuts to hide notification related to selected products only.', 'inboundwp-lite'); ?></span><br/>
								<span class="description"><?php _e('Note: This only works if `Products Include` settings is not set.', 'inboundwp-lite'); ?></span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- End - Restriction Settings -->
</div><!-- end .ibwp-sp-content-sett -->

<!-- Clone Notification Template -->
<script type="text/html" id="tmpl-ibwp-sp-custom-nf-tmpl">
	<div class="ibwp-sp-custom-nf-row-inr" data-key="1">
		<div class="ibwp-sp-custom-nf-header">			
			<span class="ibwp-sp-custom-nf-row-actions">
				<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-sett ibwp-tooltip" title="<?php esc_html_e('Show / Hide settings', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-admin-generic"></i></span>
				<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-add ibwp-tooltip" title="<?php esc_html_e('Add', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-plus-alt"></i></span>
				<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-delete ibwp-tooltip" title="<?php esc_html_e('Delete', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-trash"></i></span>
				<span class="ibwp-sp-custom-nf-act-btn ibwp-sp-custom-nf-row-drag ibwp-tooltip" title="<?php esc_html_e('Drag', 'inboundwp-lite'); ?>"><i class="dashicons dashicons-move"></i></span>
			</span>
			<div class="ibwp-sp-custom-nf-ttl">
				<?php echo esc_html_e('Notification', 'inboundwp-lite'); ?> <span class="ibwp-sp-custom-nf-no"></span>
			</div>
		</div>

		<div class="ibwp-sp-custom-nf-row-data">
			<table class="form-table ibwp-tbl">
				<tbody>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-title-1"><?php _e('Title', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][title]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-title" id="ibwp-sp-custom-nf-title-1" /><br/>
							<span class="description"><?php _e('Enter product title.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-name-1"><?php _e('Name', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][name]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-name" id="ibwp-sp-custom-nf-name-1" /><br/>
							<span class="description"><?php _e('Enter product customer name.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-email-1"><?php _e('Email Address', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][email]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-email" id="ibwp-sp-custom-nf-email-1" /><br/>
							<span class="description"><?php _e('Enter product customer email address.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-city-1"><?php _e('City', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][city]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-city" id="ibwp-sp-custom-nf-city-1" /><br/>
							<span class="description"><?php _e('Enter customer city.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-state-1"><?php _e('State', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][state]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-state" id="ibwp-sp-custom-nf-state-1" /><br/>
							<span class="description"><?php _e('Enter customer state.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-country-1"><?php _e('Country', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][country]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-country" id="ibwp-sp-custom-nf-country-1" /><br/>
							<span class="description"><?php _e('Enter customer country.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-image-1"><?php _e('Image', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo $prefix; ?>custom_nf[1][image]" value="" class="regular-text ibwp-url ibwp-sp-nf-img ibwp-img-upload-input" id="ibwp-sp-nf-img-1" />
							<input type="button" name="ibwp_sp_nf_img" class="button-secondary ibwp-image-upload" value="<?php esc_html_e( 'Upload Image', 'inboundwp-lite'); ?>" />
							<input type="button" name="ibwp_sp_nf_img_clear" id="ibwp-sp-url-clear-1" class="button button-secondary ibwp-image-clear" value="<?php esc_html_e( 'Clear', 'inboundwp-lite'); ?>"  data-pdt-preview="1" /> <br />
							<span class="description"><?php _e('Choose product image.', 'inboundwp-lite'); ?></span>
							<div class="ibwp-img-view"></div>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-url-1"><?php _e('URL', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][url]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-url" id="ibwp-sp-custom-nf-url-1" /><br/>
							<span class="description"><?php _e('Enter product url.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-time-1"><?php _e('Purchase Time', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<input type="text" name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][time]" value="" class="ibwp-text large-text ibwp-sp-custom-nf-time" id="ibwp-sp-custom-nf-time-1" /><br/>
							<span class="description"><?php _e('Enter product purchase time. e.g 2 days OR 10 minute', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
					<tr>
						<th>
							<label for="ibwp-sp-custom-nf-rating-1"><?php _e('Rating', 'inboundwp-lite'); ?></label>
						</th>
						<td>
							<select name="<?php echo ibwpl_esc_attr( $prefix ); ?>custom_nf[1][rating]" class="ibwp-select ibwp-sp-custom-nf-rating" id="ibwp-sp-custom-nf-rating-1">
								<option value=""><?php esc_html_e('Select Rating', 'inboundwp-lite'); ?></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select><br/>
							<span class="description"><?php _e('Select rating.', 'inboundwp-lite'); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!-- end .ibwp-sp-custom-nf-row-inr -->
</script><!-- end .tmpl-ibwp-sp-nf-tmpl -->