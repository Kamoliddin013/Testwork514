<?php

// First Register the Tab by hooking into the 'woocommerce_product_data_tabs' filter
add_filter( 'woocommerce_product_data_tabs', 'add_kamol_custom_product_data_tab' );
function add_kamol_custom_product_data_tab( $product_data_tabs ) {
	$product_data_tabs['kamol-custom-tab'] = array(
		'label'  => __( 'Kamol Custom Fields', 'kamol_text_domain' ),
		'target' => 'kamol_custom_product_data',
		'priority' => 1,
	);

	return $product_data_tabs;
}

// functions you can call to output text boxes, select boxes, etc on admin panel.
add_action( 'woocommerce_product_data_panels', 'add_kamol_custom_product_data_fields' );
function add_kamol_custom_product_data_fields() {
	global $woocommerce, $post;
	?>
	<!-- id below must match target registered in above add_kamol_custom_product_data_tab function -->
	<div id="kamol_custom_product_data" class="panel woocommerce_options_panel">
	<!--Datetime-->
		<p class="form-field custom_field_type">
			<label for="custom_field_type"><?php echo __( 'Date Field', 'woocommerce' ); ?></label>
			<span class="wrap">
				<?php $exists_date = get_post_meta( $post->ID, 'kamol_date_custom', true );
				if ( $exists_date != null || $exists_date != '' ) {
					?>
					<input type="date" name="kamol_date_input" id="kamol_date_value_id" value="<?php echo date('Y-m-d', strtotime($exists_date)) ?>"/>
					<?php
				} else {
					?>
					<input type="date" name="kamol_date_input" value="<?php echo date( 'Y-m-d' ); ?>"/>
				<?php }
				?>
			</span>
			<span class="description"><?php _e( 'Product created time : ' . $post->post_date, 'woocommerce' ); ?></span>
		</p>

		<?php
		woocommerce_wp_select(
			array(
				'id'      => '_select_type_product',
				'label'   => __( 'Product type', 'woocommerce' ),
				'options' => array(
					''  => __( 'Select', 'woocommerce' ),
					'rare'  => __( 'Rare', 'woocommerce' ),
					'fre' => __( 'Frequent', 'woocommerce' ),
					'unu'     => _x( 'Unusual', 'Tax status', 'woocommerce' ),
				),
			)
		);
		?>
<!--		custom image uploader-->
		<?php
//		custom image uploader
		$kamol_uploaded_img = (array) get_post_meta( $post->ID, 'kamol-img', true );
		$image_id = $kamol_uploaded_img[0];
		if ( $image = wp_get_attachment_image_src( $image_id ) ) {
			?>
			<p>
				<span for='clear' style="margin-right: 5px;"><?php _e( 'Custom image for Product:', 'woocommerce' ); ?></span>
			</p>
			<p class="upload-kamol-image">
				<a href="#" class="kamol-upl"><img src="<?php echo wp_get_attachment_url( $image_id ) ?>"/></a>
				<a href="#" class="kamol-rmv">Remove image</a>
				<input type="hidden" name="kamol-img" value=" <?php echo $image_id ?>" id="uploaded_image_id_custom">
			</p>
			<?php
		} else {
			?>
			<p class="upload-kamol-image">
				<a href="#" class="kamol-upl">Upload Custom image to Product</a>
				<a href="#" class="kamol-rmv" style="display:none">Remove image</a>
				<input type="hidden" name="kamol-img" value="">
			</p>
			<?php
		} ?>
<!--		updater btn-->
		<p class="span_save_product_changes">
			<span for='Save' class="span_save_product_changes"><?php _e( 'Save your product with changes:', 'woocommerce' ); ?></span>

			<input type="submit" class="update_changes" value="Update Product">
		</p>
<!--		cleaner btn-->
		<p class="span_save_product_changes">
			<span for='clear'><?php _e( 'Clear all changes:', 'woocommerce' ); ?></span>

			<input type="button" class="clear_changes" name="Clear" value="Clear" id="myClearBtn">
		</p>
	</div>
	<?php

}


add_action( 'woocommerce_process_product_meta', 'kamol_save_fields', 10, 2 );
function kamol_save_fields( $id, $post ) {
	//date
	$new_date = date('Y-m-d', strtotime($_POST['kamol_date_input']));
	update_post_meta( $id, 'kamol_date_custom', $new_date );
	//img
	update_post_meta( $id, 'kamol-img', $_POST['kamol-img'] );
	//simple select
	update_post_meta( $id, '_select_type_product', $_POST['_select_type_product'] );
}