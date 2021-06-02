<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $checkout;
if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );

	?>
	<hr>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
		// do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>
		<p class="form-row validate-required">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
				<span class="woocommerce-terms-and-conditions-checkbox-text">I have read the terms and conditions and accept them.</span>&nbsp;<span class="required">*</span>
			</label>
			<input type="hidden" name="terms-field" value="1" />
		</p>
		<p class="form-row validate-required">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="privacy_policy" id="privacy_policy" />
				<span class="woocommerce-privacy-policy-checkbox-text">You agree that your data will be used to process your request. You can find information and revocation instructions in the data <a href="<?php echo esc_url(get_permalink(wc_privacy_policy_page_id())); ?>">protection declaration</a>.</span>&nbsp;<span class="required">*</span>
			</label>
			<input type="hidden" name="terms-field" value="1" />
		</p>
	</div>
	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions', $checkout );
}
