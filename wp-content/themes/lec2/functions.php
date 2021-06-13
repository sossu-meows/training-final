<?php

/**
 * Ensure dependencies are loaded
 */
const LEC2_DOMAIN = 'lec2';

$error_text = function ($message) {
    wp_die($message);
};

if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    $error_text(sprintf(__('You must run <code>composer install</code> in %s theme folder, Autoloader not found !!!', LEC2_DOMAIN), LEC2_DOMAIN));
}
require_once $composer;

array_map(function ($file) use ($error_text) {
    $file = "/app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $error_text(sprintf(__('Error locating <code>%s</code> for inclusion.', LEC2_DOMAIN), $file));
    }
}, ['App', 'TwigLoader']);

\App\Container::getInstance()->bindConfig('config', [
    'assets' => require get_template_directory() . '/config/assets.php',
    'theme' => require get_template_directory() . '/config/theme.php',
    'view' => require get_template_directory() . '/config/view.php',
])->bindApp();

/*--------------------------------------------------------------------------------------------------------------------*/

/**
 * This is used for debug
 *
 * @param $var
 * @param $isDie
 */
function debug($var, $isDie = false)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';

    if ($isDie) {
        die;
    }
}

/**
 * add field
 */
if (function_exists('acf_add_local_field_group')) :

    acf_add_local_field_group(array(
        'key' => 'group_60b9eccbc1ff2',
        'title' => 'Buy As Gift',
        'fields' => array(
            array(
                'key' => 'field_60b9ecd6f7124',
                'label' => 'Buy As Gift',
                'name' => 'buy-as-gift',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 0,
                'message' => '',
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;
/**
 * Create a coupon programatically
 */
$coupon_code = 'TCP'; // Code
$amount = '3'; // Amount discount  value
$discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product

$coupon = array(
    'post_title' => $coupon_code,
    'post_content' => 'Your Coupon is ' . $coupon_code,
    'post_status' => 'publish',
    'post_author' => 1,
    'post_type' => 'shop_coupon'
);

$new_coupon_id = wp_insert_post($coupon);

// Add meta
update_post_meta($new_coupon_id, 'discount_type', $discount_type);
update_post_meta($new_coupon_id, 'coupon_amount', $amount);
update_post_meta($new_coupon_id, 'individual_use', 'no');
update_post_meta($new_coupon_id, 'product_ids', '');
update_post_meta($new_coupon_id, 'exclude_product_ids', '');
update_post_meta($new_coupon_id, 'usage_limit', '');
update_post_meta($new_coupon_id, 'expiry_date', '');
update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
update_post_meta($new_coupon_id, 'free_shipping', 'no');

// add_action('woocommerce_email_header', 'mm_email_header', 10, 2);
// function mm_email_header($email_heading, $email)
// {
//     echo "<p> khoa check!</p>";
// }
