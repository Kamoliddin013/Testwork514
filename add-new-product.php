<?php
/*
Template Name: Add New Product
*/
?>
<?php get_header(); ?>
<style>
    .add-new-product{
        margin: 0 auto;
	    padding: 50px;
        width: 600px;
        display: block;
    }
</style>
	<div id="primary" class="content-area">
		<main id="main" class="site-main add-new-product">
			<form method="post"  enctype="multipart/form-data">
				<input type="hidden" name="is_product_submit" value="1"/>
				<div><h4>Product Data</h4></div>
				<div>
					<div><label>Product Name</label></div>
					<div><input type="text" name="proname" class="proname"/></div>
				</div>
				<div>
					<div><label>Product Description</label></div>
					<div><textarea name="prodesc" class="prodesc"></textarea></div>
				</div>
				<div>
					<div><label>Product Price</label></div>
					<div><input type="text" name="proprice" class="proprice"/></div>
				</div>
				<div><h4>Custom Product Fields</h4></div>
				<p class="form-field custom_field_type">
					<label for="custom_field_type"><?php echo __( 'Date Field', 'woocommerce' ); ?></label>
					<span class="wrap">
						<input type="date" name="kamol_date_input" value="<?php echo date( 'Y-m-d' ); ?>"/>
					</span>
				</p>

				<div class="mgt_input">
					<label class="control-label"><?php echo esc_html__("Product Types", "woocommerce"); ?></label>
					<select  name="kamol_type_product_select" class="form-control" required>
						<option value="">Select</option>
						<option value="rare">Rare</option>
						<option value="fre">Frequent</option>
						<option value="unu">Unusual</option>
					</select>
				</div>
				<div>
					<div><label>Product Thumbnail Image</label></div>
					<div class="image_upl">
						<label for="my_image_upload"
						       class="control-label add-listing-author-image-label">
							<img src=""
							     class="add-listing-author-image">
						</label>
					</div>
					<input type="file" name="my_image_upload" id="my_image_upload"
					       onchange="show(this)" required  />
					<script type="text/javascript">
                        function show(input) {
                            if (input.files && input.files[0]) {
                                var filerdr = new FileReader();
                                filerdr.onload = function (e) {
                                    $('#user_img').attr('src', e.target.result);
                                }
                                filerdr.readAsDataURL(input.files[0]);
                            }
                        }
					</script>
					<?php wp_nonce_field('my_image_upload', 'my_image_upload_nonce'); ?>

				</div>
				<hr>
				<div>
					<div><label>Product Custom Uploaded Image</label></div>
					<div class="image_upl_2">
						<label for="my_image_upload_2"
						       class="control-label add-listing-author-image-label">
							<img src=""
							     class="add-listing-author-image">
						</label>
					</div>
					<input type="file" name="my_image_upload_2" id="my_image_upload_2"
					       onchange="show(this)" required  />
					<script type="text/javascript">
                        function show(input) {
                            if (input.files && input.files[0]) {
                                var filerdr = new FileReader();
                                filerdr.onload = function (e) {
                                    $('#user_img').attr('src', e.target.result);
                                }
                                filerdr.readAsDataURL(input.files[0]);
                            }
                        }
					</script>
					<?php wp_nonce_field('my_image_upload_2', 'my_image_upload_2_nonce'); ?>

				</div>
				<div>
					<input type="submit" value="Submit" class="submit" onclick="prodsubmit();"/>
				</div>
			</form>
		</main>
	</div>
<?php get_footer();
if (isset($_POST['is_product_submit'])) {

	$objProduct = new WC_Product();

	$objProduct->set_name($_POST['proname']);
	$objProduct->set_status("publish");  // can be publish,draft or any wordpress post status
	$objProduct->set_catalog_visibility('visible'); // add the product visibility status
	$objProduct->set_description($_POST['prodesc']);
	$objProduct->set_regular_price($_POST['proprice']); // set product price
	$product_id = $objProduct->save();

	$new_date = date('Y-m-d', strtotime($_POST['kamol_date_input']));
	update_post_meta( $product_id, 'kamol_date_custom', $new_date );
	$selected_select_type = sanitize_text_field($_POST['kamol_type_product_select']);
	update_post_meta( $product_id, '_select_type_product', esc_attr( $selected_select_type ) );



	if ( isset($_POST['my_image_upload_nonce'])  && wp_verify_nonce($_POST['my_image_upload_nonce'], 'my_image_upload')
	) {
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		$attachment_id = media_handle_upload('my_image_upload', $product_id);

		if (is_wp_error($attachment_id)) {
			// There was an error uploading the image.
		} else {
			// The image was uploaded successfully!
			set_post_thumbnail($product_id, $attachment_id);
		}

	}
	if ( isset($_POST['my_image_upload_2_nonce'])  && wp_verify_nonce($_POST['my_image_upload_2_nonce'], 'my_image_upload_2')
	) {
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');

		$attachment_id = media_handle_upload('my_image_upload_2', $product_id);

		if (is_wp_error($attachment_id)) {
			// There was an error uploading the image.
		} else {
			// The image was uploaded successfully!
			update_post_meta( $product_id, 'kamol-img', $attachment_id );
		}

	}
}
?>