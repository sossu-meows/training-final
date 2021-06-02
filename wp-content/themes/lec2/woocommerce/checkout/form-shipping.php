<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

global $theme_options;
$terms_and_conditions_text = $theme_options['text_translation']['default_global_settings_text']['terms_and_conditions'];
?>

<div class="woocommerce-additional-fields form-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>

<div class="woocommerce-shipping-fields form-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<div id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'The billing address is different from the address given above.', 'woocommerce' ); ?></span>
			</label>
		</div>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

		</div>

	<?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

<hr>
<div class="woocommerce-terms-and-conditions-wrapper form-fields">
	<?php
	/**
	 * Terms and conditions hook used to inject content.
	 *
	 * @since 3.4.0.
	 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
	 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
	 */
	// do_action( 'woocommerce_checkout_terms_and_conditions' );
		$terms_page_id   = wc_terms_and_conditions_page_id();
		$terms_link      = $terms_page_id ? '<a href="' . esc_url( get_permalink( $terms_page_id ) ) . '" target="_blank">' . $terms_and_conditions_text . '</a>' : $terms_and_conditions_text;

	?>
	<p class="form-row validate-required">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
		<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" id="terms" />
			<span class="required">*</span>&nbsp;<span class="woocommerce-terms-and-conditions-checkbox-text"><?php echo str_replace('[terms]', $terms_link, wc_get_terms_and_conditions_checkbox_text()); ?></span>
		</label>
	</p>
	<p class="form-row validate-required">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
		<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="privacy_policy" id="privacy_policy" />
			<span class="required">*</span>&nbsp;<span class="woocommerce-privacy-policy-checkbox-text"><?php echo wc_replace_policy_page_link_placeholders(wc_get_privacy_policy_text( 'checkout' )); ?></span>
		</label>
	</p>
</div>

<?php do_action( 'woocommerce_checkout_after_terms_and_conditions', $checkout ); ?>

<div class="form-group-actions"> <button disabled type="button" id="checkout_submit" class="btn btn-info">Buy Training</button> </div>