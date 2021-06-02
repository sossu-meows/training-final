<?php

/**
 * Plugin Name: Lec Custom Product Type
 * Description: Custom product type for training products
  */

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class Lec_Product_Type_Plugin {

    /**
     * Build the instance
     */
    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'install' ) );

        add_action( 'woocommerce_loaded', array( $this, 'load_plugin' ) );
        add_filter( 'product_type_selector', array( $this, 'add_type' ) );

        add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_tab' ), 50 );
        add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tab_content' ) );
        add_action( 'woocommerce_process_product_meta_training', array( $this, 'save_training_settings' ) );

        add_action( 'woocommerce_admin_order_data_after_order_details', array($this, 'lec2_checkout_field_display_admin'), 20, 1 );
        add_action( 'woocommerce_checkout_update_order_meta', array($this, 'lec2_checkout_update_order_meta'), 10, 2 );
        add_filter( 'woocommerce_email_order_meta_fields', array($this, 'lec2_display_custom_fields_in_emails'), 10, 3 );
    }

    /**
     * Installing on activation
     *
     * @return void
     */
    public function install() {
        // If there is no training product type taxonomy, add it.
        if ( ! get_term_by( 'slug', 'training', 'product_type' ) ) {
            wp_insert_term( 'training', 'product_type' );
        }
    }
 
    /**
     * Load WC Dependencies
     *
     * @return void
     */
    public function load_plugin() {
        require_once 'includes/class-lec-product-training.php';
    }

    /**
     * Training Type
     *
     * @param array $types
     * @return void
     */
    public function add_type( $types ) {
        $types['training'] = __( 'Training', LEC2_DOMAIN );
       
        return $types;
    }

    /**
     * Add Experience Product Tab.
     *
     * @param array $tabs
     *
     * @return mixed
     */
    public function add_product_tab( $tabs ) {

        $tabs['training_type'] = array(
            'label'    => __( 'Training Type', 'lec2_text_domain' ),
            'target' => 'training_type_product_options',
            'class'  => 'show_if_training',
        );

        return $tabs;
    }
    
    /**
     * Add Content to Product Tab
     */
    public function add_product_tab_content() {
        global $product_object;
        ?>
        <div id='training_type_product_options' class='panel woocommerce_options_panel hidden'>
            <div class='options_group'>
            <?php

            woocommerce_wp_text_input(
              array(
                'id'          => '_member_price',
                'label'       => __( 'Data', 'lec2_text_domain' ),
                'value'       => $product_object->get_meta( '_member_price', true ),
                'default'     => '',
                'placeholder' => 'Enter data',
            ));
            ?>
            </div>
        </div>
        <?php
    }

    /**
     * @param $post_id
     */
    public function save_training_settings( $post_id ) {
        $price = isset( $_POST['_member_price'] ) ? sanitize_text_field( $_POST['_member_price'] ) : '';
        update_post_meta( $post_id, '_member_price', $price );
    }

    /**
     * Display field value on the order edit page
     */

    public function lec2_checkout_field_display_admin($order) {
        echo '<h3 style="padding-top: 180px">Course</h3>';

        $order_id = THWCFD_Utils::get_order_id($order);

        $room_reservation = get_post_meta( $order_id, 'room_reservation', true );
        echo '<p><strong>'.__('Course').': </strong>'.get_post_meta($order_id,'order_custom_training_name',true).'</p>';
        echo '<p><strong>'.__('Execution of Training').': </strong>'.get_post_meta($order_id,'order_custom_execution_of_training',true).'</p>';
        echo '<p><strong>'.__('URL').': </strong>'.get_post_meta($order_id,'order_custom_url',true).'</p>';
        echo '<p><strong>'.__('Date').': </strong>'.get_post_meta($order_id,'order_custom_date',true).'</p>';
        echo '<p><strong>'.__('Fee').': </strong>'.get_post_meta($order_id,'order_custom_price',true).'</p>';
        echo '<p><strong>'.__('Type').': </strong>'.get_post_meta($order_id,'order_custom_training_type',true).'</p>';
        echo '<p><strong>'.__('In house training').':</strong> ' . (get_post_meta( $order_id, 'in_house_training', true )?"yes":"no") . '</p>';
        echo '<p><strong>'.__('Room Reservation').':</strong> ' . ($room_reservation?"yes":"no") . '</p>';
        if ($room_reservation) {
            echo '<p><strong>'.__('Arrival date').':</strong> ' . get_post_meta( $order_id, 'arrival_date', true ) . '</p>';
            echo '<p><strong>'.__('Departure date').':</strong> ' . get_post_meta( $order_id, 'departure_date', true ) . '</p>';
        }

//        echo '<p><strong>'.__('Subscribe newsletter').':</strong> ' . (get_post_meta( $order_id, 'subscribe_newsletter', true )?"yes":"no") . '</p>';
//        echo '<p><strong>'.__('Pass personal data').':</strong> ' . (get_post_meta( $order_id, 'pass_personal_data', true )?"yes":"no") . '</p>';
    }

    public function lec2_display_custom_fields_in_emails($ofields, $sent_to_admin, $order){
        $custom_fields = array();
        $order_id = THWCFD_Utils::get_order_id($order);
        $room_reservation = get_post_meta( $order_id, 'room_reservation', true );
        $custom_fields["in_house_training"] = array('label' => __('In house training'), 'value' => (get_post_meta( $order_id, 'in_house_training', true )?"yes":"no"));
        $custom_fields["room_reservation"] = array('label' => __('Room Reservation'), 'value' => ($room_reservation?"yes":"no"));
        if ($room_reservation) {
            $custom_fields["arrival_date"] = array('label' => __('Arrival date'), 'value' => get_post_meta( $order_id, 'arrival_date', true ));
            $custom_fields["departure_date"] = array('label' => __('Departure date'), 'value' => get_post_meta( $order_id, 'departure_date', true ));
        }
        $custom_fields["subscribe_newsletter"] = array('label' => __('Subscribe newsletter'), 'value' => (get_post_meta( $order_id, 'subscribe_newsletter', true )?"yes":"no"));
        $custom_fields["pass_personal_data"] = array('label' => __('Pass personal data'), 'value' => (get_post_meta( $order_id, 'pass_personal_data', true )?"yes":"no"));

        return array_merge($ofields, $custom_fields);
    }  

    public function lec2_checkout_update_order_meta( $order_id, $posted ) {
        if ( ! empty( $_POST['in_house_training'] ) ) {
            update_post_meta( $order_id, 'in_house_training', wc_clean( $_POST['in_house_training'] ) );
        }
        if ( ! empty( $_POST['room_reservation'] ) ) {
            update_post_meta( $order_id, 'room_reservation', wc_clean( $_POST['room_reservation'] ) );
        }
        if ( ! empty( $_POST['arrival_date'] ) ) {
            update_post_meta( $order_id, 'arrival_date', wc_clean( $_POST['arrival_date'] ) );
        }
        if ( ! empty( $_POST['departure_date'] ) ) {
            update_post_meta( $order_id, 'departure_date', wc_clean( $_POST['departure_date'] ) );
        }
        if ( ! empty( $_POST['subscribe_newsletter'] ) ) {
            update_post_meta( $order_id, 'subscribe_newsletter', wc_clean( $_POST['subscribe_newsletter'] ) );
        }
        if ( ! empty( $_POST['pass_personal_data'] ) ) {
            update_post_meta( $order_id, 'pass_personal_data', wc_clean( $_POST['pass_personal_data'] ) );
        }
        /**
         * #24219 - Add extra information to Order
         */
        if ( ! empty( $_POST['order_custom_execution_of_training'] ) ) {
            update_post_meta( $order_id, 'order_custom_execution_of_training', wc_clean( $_POST['order_custom_execution_of_training'] ) );
        }
        if ( ! empty( $_POST['order_custom_date'] ) ) {
            update_post_meta( $order_id, 'order_custom_date', wc_clean( $_POST['order_custom_date'] ) );
        }
        if ( ! empty( $_POST['order_custom_url'] ) ) {
            update_post_meta( $order_id, 'order_custom_url', wc_clean( $_POST['order_custom_url'] ) );
        }
        if ( ! empty( $_POST['order_custom_price'] ) ) {
            update_post_meta( $order_id, 'order_custom_price', wc_clean( $_POST['order_custom_price'] ) );
        }
        if ( ! empty( $_POST['order_custom_training_type'] ) ) {
            update_post_meta( $order_id, 'order_custom_training_type', wc_clean( $_POST['order_custom_training_type'] ) );
        }
        if ( ! empty( $_POST['order_custom_training_name'] ) ) {
            update_post_meta( $order_id, 'order_custom_training_name', wc_clean( $_POST['order_custom_training_name'] ) );
        }
        if ( ! empty( $_POST['ship_to_different_address'] ) ) {
            update_post_meta( $order_id, 'order_custom_ship_to_different_address', wc_clean( $_POST['ship_to_different_address'] ) );
        }
        /**
         * End #24219 - Add extra information to Order
         */
    }
}

new Lec_Product_Type_Plugin();
