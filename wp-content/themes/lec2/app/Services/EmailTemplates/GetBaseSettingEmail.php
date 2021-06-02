<?php


namespace App\Services\EmailTemplates;


class GetBaseSettingEmail
{

    public static function getBaseColor() {
        return get_option( 'woocommerce_email_base_color' );
    }

    public static function getBackGroundColor() {
        return get_option( 'woocommerce_email_background_color' );
    }

    public static function getBodyBackGroundColor() {
        return get_option( 'woocommerce_email_body_background_color' );
    }

    public static function getBodyTextColor() {
        return get_option( 'woocommerce_email_text_color' );
    }

    public static function getHeaderImage() {
        return get_option( 'woocommerce_email_header_image' ) ? get_option( 'woocommerce_email_header_image' ) : get_site_url().'/wp-content/themes/lec2/resources/views/frontend/dist/assets/images/logo-desktop-w.png';
    }

    /**
     * Replace placeholder text in strings.
     *
     * @since  3.7.0
     * @param  string $string Email footer text.
     * @return string         Email footer text with any replacements done.
     */
    public static function replace_placeholders( $string ) {

        $home_path       = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );

        if ($string) {
            return str_replace (
                array (
                    '{site_title}',
                    '{site_address}',
                    '{site_url}',
                    '{woocommerce}',
                    '{WooCommerce}',
                ),
                array (
                    get_option( 'blogname' ),
                    $home_path,
                    $home_path,
                    '<a href="https://woocommerce.com">WooCommerce</a>',
                    '<a href="https://woocommerce.com">WooCommerce</a>',
                ),
                $string
            );
        } else {
            return __('LEC2 © '.date('Y').'. All rights reserved.', LEC2_DOMAIN);
        }
    }

    public static function getFooter() {
        return self::replace_placeholders(get_option('woocommerce_email_footer_text') );
    }
}