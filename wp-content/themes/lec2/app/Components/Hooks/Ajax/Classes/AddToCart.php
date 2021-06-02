<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Product\Single;
/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class AddToCart extends AbstractAjax
{
    protected $functions = [ 'add_to_cart' =>  'addToCart'];

    /**
     * getMorePartner
     */
    public function addToCart() {
        if (!isset($_POST['training_id'])) {
            die('Missing training id');
        }

        if (!isset($_POST['training_type_id'])) {
            die('Missing training type id');
        }

        WC()->cart->empty_cart();
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['training_id']));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $product_status = get_post_status($product_id);

        if ($passed_validation && WC()->cart->add_to_cart($product_id, 1, 0, array(), array('training_type_id' => $_POST['training_type_id'], 'execution_of_training' => $_POST['execution_of_training'], 'training_url' => $_POST['training_url'], 'time' => $_POST['time'])) && 'publish' === $product_status) {
            if (wp_redirect( wc_get_checkout_url() )) {
                exit;
            }
        } else {
            if (wp_redirect( get_permalink($product_id) )) {
                exit;
            }
        }
    }
}