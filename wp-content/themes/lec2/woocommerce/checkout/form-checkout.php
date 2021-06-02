<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $theme_options;

do_action( 'woocommerce_before_checkout_form', $checkout );
$theme_options = get_fields('option');

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

?>

<style type="text/css">
    .ui-widget-header {
        background: #21a9dc;
    }
    #payment {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color:rgba(0, 0, 0, 0.9)!important;
        z-index: 0;
    }
    #payment .payment-content {
        width: 50%;
        margin: 10% auto;
        background-color: white;
    }
    .checkout-page #order_review, .checkout-page #order_review_heading {
        padding-left: unset;
        float: unset;
        clear: unset;
    }
    .woocommerce table.shop_table,
    .woocommerce table.shop_table td,
    .woocommerce table.shop_table tbody th,
    .woocommerce table.shop_table tfoot td,
    .woocommerce table.shop_table tfoot th {
        border: none;
    }
    .checkout-page .col2-set {
        width: 100%;
    }
    .checkout-page .col2-set p {
        padding: 0px;
    }
    #ship-to-different-address {
        margin-bottom: 1.15em;
    }
    .checkout-page .col2-set label {
        margin: 0px;
    }
    .room-reservation {
        display: none;
    }
    .gj-unselectable {
        width: 50%;
        display: inline-block;
        position: relative;
    }
    .gj-datepicker [role=right-icon] {
        border: 1px solid #ced4da;
        position: absolute;
        top: 3px;
        right: 3px;
    }
    .gj-datepicker-bootstrap [role=right-icon] button {
        min-width: 40px;
        height: 38px;
        border: unset;
        border-left: 1px solid #ced4da !important;
    }
    .woocommerce form .form-row label.checkbox {
        font-size: 1.8rem;
        font-weight: 400;
    }
    .checkout-page .col2-set input.input-checkbox {
        margin-right: 8px;
    }
    hr {
        height: 1px;
        border: 0;
        background-color: #ebebeb;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .form-group-actions {
        width: 100%;
        text-align: center;
    }
    .woocommerce form .form-row .optional {
        display: none;
    }
    .select2-container--default .select2-selection--single {
        border-radius: unset;
    }
    #payment.show_payment {
        display: block!important;
        z-index: 999999!important;
    }
    #place_order {
        width: 100%;
        background-color: #7be1d1;
        color: #24407a;
    }
    .woocommerce form .form-row label, .woocommerce-page form .form-row label {
        display: none;
    }
    .woocommerce-invalid #terms {
        outline: unset;
    }
    .btn-info.disabled, .btn-info:disabled {
        cursor: not-allowed;
    }
    .room-reservation .gj-datepicker [role=right-icon] {
        z-index: -1;
        top: 0px;
        right: 0px;
    }
    .room-reservation .gj-unselectable:last-child {
        margin-left: 2%;
    }
    .room-reservation .gj-unselectable {
        width: 49%;
    }
    #arrival_date, #departure_date {
        background-color: transparent;
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    (function( $ ) {
        function checkout_validate_func() {
            var is_valid = true;
            if ($("#room_reservation").length > 0) {
                if ( $("#room_reservation").is(":checked") ) {
                    $("#arrival_date, #departure_date" ).each(function() {
                        if (!$(this).val())
                            is_valid = false;
                    });
                }
            }
            if ( $("#billing_country").val() === 'default' ) {
                is_valid = false;
            }
            $(".form-fields").each(function( index ) {
                if ($(this).find("#ship-to-different-address").length > 0) {
                    if ( $("#ship-to-different-address-checkbox").is(":checked") ) {
                        $(this).find( "p.validate-required input, p.validate-required select" ).each(function( index2 ) {
                            if (!$(this).val())
                                is_valid = false;
                        });
                        if ( $("#shipping_country").val() === 'default' ) {
                            is_valid = false;
                        }
                    }
                } else {
                    $(this).find( "p.validate-required input[type=text], p.validate-required select" ).each(function( index ) {
                        if (!$(this).val()) {
                            is_valid = false;
                        }
                    });
                    $(this).find( "p.validate-required input[type=checkbox]" ).each(function( index ) {
                        if (!$(this).is(":checked")) {
                            is_valid = false;
                        }
                    });
                }
            });

            return is_valid;
        }

        $(document).ready(function($){
            $('#room_reservation').click(function(){
                if($(this).is(':checked')){
                    $('.room-reservation').slideDown();
                } else {
                    $('.room-reservation').slideUp();
                }
            });
            $('#checkout_submit').click(function(){
                if($('.order-total bdi').text()==="$0.00"){
                    form_checkout_submit();
                } else {
                    $("#payment").addClass('show_payment');
                }
            });
            $( ".form-fields p.validate-required input, .form-fields p.validate-required select, #ship-to-different-address-checkbox, #room_reservation, #arrival_date, #departure_date" ).change(function() {
                if (checkout_validate_func()) {
                    $('#checkout_submit').prop('disabled', false);
                } else {
                    $('#checkout_submit').prop('disabled', true);
                }
            });
            $('.woocommerce-privacy-policy-link').text('protection declaration');
        });
        $(document).keyup(function(e) {
            if (e.keyCode === 27) {
                $("#payment").removeClass('show_payment');
            }
        });
        $(document).mouseup(function(e) {
            var container = $(".payment-content");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $("#payment").removeClass('show_payment');
            }
        });
    })(jQuery);
</script>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

        <div class="col2-set" id="customer_details">
            <div class="col-1">
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>

                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                <?php do_action( 'woocommerce_checkout_billing' ); ?>
            </div>

            <div class="col-2">
                <?php do_action( 'woocommerce_checkout_shipping' ); ?>
            </div>
        </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

</form>

<script type="text/javascript">
    function form_checkout_submit() {
        jQuery("#payment").removeClass('show_payment');
        jQuery(".woocommerce-checkout").submit();
    }
</script>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
