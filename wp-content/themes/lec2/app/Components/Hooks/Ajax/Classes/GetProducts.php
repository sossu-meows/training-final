<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Product\ListProductsByTime;

/**
 * Class GetProducts - Get more products
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetProducts extends AbstractAjax
{
  //training_types_0_execution_of_training_live_course_dates_1_date
  protected $functions = ['get_products' =>  'getProducts'];

  /**
   * Get Products
   */
  public function getProducts()
  {
    $product = new ListProductsByTime();
    $products = $product->execute();

    if ($products) {
      wp_send_json($products);
    } else {
      wp_send_json(array(
        'status'    => false,
      ));
    }
  }
}
