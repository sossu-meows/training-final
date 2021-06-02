<?php

/**
 * Training Product Type
 */
class WC_Product_Training extends WC_Product {
    
    /**
     * Initialize simple product.
     *
     * @param WC_Product|int $product Product instance or ID.
     */
    public function __construct( $product = 0 ) {
        // $this->supports[] = 'ajax_add_to_cart';
        parent::__construct( $product );
    }

    /**
     * Return the product type
     * @return string
     */
    public function get_type() {
        return 'training';
    }

    public function is_purchasable() {
        return apply_filters( 'woocommerce_is_purchasable', true, $this );
    }

    /**
     * Returns the product's active price.
     *
     * @param  string $context What the value is for. Valid values are view and edit.
     * @return string price
     */
    public function get_price( $context = 'view' ) {
        if( $this->is_type( 'training' ) ) {
            $product = get_fields( $this->id );
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                foreach ($product['training_types'] as $key => $training_type) {
                    if ($training_type['training_type']->ID == $cart_item['training_type_id']) {
                        if ($cart_item['execution_of_training']) {
                            switch ($cart_item['execution_of_training']) {
                                case 'live_video':
                                    return $this->parse_price($training_type['execution_of_training']['live_course_cost']);
                                    break;
                                
                                case 'recorded_video':
                                    return $this->parse_price($training_type['execution_of_training']['recorded_video_cost']);
                                    break;
                            }
                        } else {
                            if ($training_type['cost'] != '') {
                                return $this->parse_price($training_type['cost']);
                            }
                        }
                    }
                }
                if (!$training_type['cost']) {
                    $price = 0;
                }
                return $this->parse_price($price);
            }
            return 0;
        }
		return $this->get_prop( 'price', $context );
    }

    public function get_training_type( $id ) {
        if(function_exists('get_fields')){
            return get_fields($id);
        }
        return '';
    }

    public function get_training_date( $cart_item ) {
        if (!empty($cart_item['time']) && $cart_item['time']!= 'Array') {
            return $cart_item['time'];
        }
        return '';
    }

    public function get_execution_of_training( $cart_item ) {
        if ($cart_item['execution_of_training']=='live_video') {
            return 'Live Course';
        } elseif ($cart_item['execution_of_training']=='recorded_video') {
            return 'Recorded Video';
        }
        return '';
    }

    public function get_training_url( $cart_item ) {
        if (!empty($cart_item['training_url'])) {
            return $cart_item['training_url'];
        }
        return '';
    }

    public function get_training_name( $id ) {
        return get_the_title($id);
    }

    public function get_training_cost( $id ) {
        if(function_exists('get_post_meta')){
            return get_post_meta($id, "cost", true);
        }
        return '';
    }

    public function parse_price( $text ) {
        return absint(filter_var($text, FILTER_SANITIZE_NUMBER_INT));
    }
}