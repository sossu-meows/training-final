<style>
    .im {
        color: black!important;
    }
    h3 {
        color: <?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getBaseColor() ?>!important;
    }
    p {
        color: black!important;
    }
</style>
<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div dir="ltr" style="background-color: <?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getBackGroundColor() ?>;margin:0;padding:70px 0;width:100%">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tbody>

        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff;border:1px solid #dedede;border-radius:3px">
                    <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: <?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getBaseColor() ?>;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;border-radius:3px 3px 0 0">
                                <tbody>
                                <tr>
                                    <td style="padding:26px 48px;display:block">
                                        <div style="border-radius:7px 7px 0 0"><img title="lec2-logo" alt="logo" border="0" width="39px" height="60px" style="display: block;float:left;padding-bottom: 25px;" src="<?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getHeaderImage() ?>" class="logo"></div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td valign="top" style="background-color: <?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getBodyBackGroundColor() ?>">
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td valign="top" style="padding:28px 48px 12px">
                                                    <div style="color:<?php echo \App\Services\EmailTemplates\GetBaseSettingEmail::getBodyTextColor() ?>;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left">

                                                        <?php /* translators: %s: Customer billing full name */ ?>
                                                        <p><?php printf( esc_html__( 'You’ve received the following order from %s:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

                                                        <?php
                                                        $order_id = THWCFD_Utils::get_order_id($order);
                                                        $room_reservation = get_post_meta($order_id);
                                                        $before = '';
                                                        $after  = '';
                                                        echo '<h3>'.wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) ).'</h3>';

                                                        echo '<p><strong>'.__('Course').': </strong>'.get_post_meta($order_id,'order_custom_training_name',true).'</p>';
                                                        echo '<p><strong>'.__('Execution of Training').': </strong>'.get_post_meta($order_id,'order_custom_execution_of_training',true).'</p>';
                                                        echo '<p><strong>'.__('URL').': </strong>'.get_post_meta($order_id,'order_custom_url',true).'</p>';
                                                        echo '<p><strong>'.__('Date').': </strong>'.get_post_meta($order_id,'order_custom_date',true).'</p>';
                                                        echo '<p><strong>'.__('Fee').': </strong>'.get_post_meta($order_id,'order_custom_price',true).'</p>';
                                                        echo '<p><strong>'.__('Type').': </strong>'.get_post_meta($order_id,'order_custom_training_type',true).'</p>';
                                                        ?>
                                                        <h3>Course participants</h3>
                                                        <?php

                                                        function code_to_country_admin_new_order( $code ){

                                                            $code = strtoupper($code);

                                                            $countryList = array(
                                                                'AF' => 'Afghanistan',
                                                                'AX' => 'Aland Islands',
                                                                'AL' => 'Albania',
                                                                'DZ' => 'Algeria',
                                                                'AS' => 'American Samoa',
                                                                'AD' => 'Andorra',
                                                                'AO' => 'Angola',
                                                                'AI' => 'Anguilla',
                                                                'AQ' => 'Antarctica',
                                                                'AG' => 'Antigua and Barbuda',
                                                                'AR' => 'Argentina',
                                                                'AM' => 'Armenia',
                                                                'AW' => 'Aruba',
                                                                'AU' => 'Australia',
                                                                'AT' => 'Austria',
                                                                'AZ' => 'Azerbaijan',
                                                                'BS' => 'Bahamas the',
                                                                'BH' => 'Bahrain',
                                                                'BD' => 'Bangladesh',
                                                                'BB' => 'Barbados',
                                                                'BY' => 'Belarus',
                                                                'BE' => 'Belgium',
                                                                'BZ' => 'Belize',
                                                                'BJ' => 'Benin',
                                                                'BM' => 'Bermuda',
                                                                'BT' => 'Bhutan',
                                                                'BO' => 'Bolivia',
                                                                'BA' => 'Bosnia and Herzegovina',
                                                                'BW' => 'Botswana',
                                                                'BV' => 'Bouvet Island (Bouvetoya)',
                                                                'BR' => 'Brazil',
                                                                'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
                                                                'VG' => 'British Virgin Islands',
                                                                'BN' => 'Brunei Darussalam',
                                                                'BG' => 'Bulgaria',
                                                                'BF' => 'Burkina Faso',
                                                                'BI' => 'Burundi',
                                                                'KH' => 'Cambodia',
                                                                'CM' => 'Cameroon',
                                                                'CA' => 'Canada',
                                                                'CV' => 'Cape Verde',
                                                                'KY' => 'Cayman Islands',
                                                                'CF' => 'Central African Republic',
                                                                'TD' => 'Chad',
                                                                'CL' => 'Chile',
                                                                'CN' => 'China',
                                                                'CX' => 'Christmas Island',
                                                                'CC' => 'Cocos (Keeling) Islands',
                                                                'CO' => 'Colombia',
                                                                'KM' => 'Comoros the',
                                                                'CD' => 'Congo',
                                                                'CG' => 'Congo the',
                                                                'CK' => 'Cook Islands',
                                                                'CR' => 'Costa Rica',
                                                                'CI' => 'Cote d\'Ivoire',
                                                                'HR' => 'Croatia',
                                                                'CU' => 'Cuba',
                                                                'CY' => 'Cyprus',
                                                                'CZ' => 'Czech Republic',
                                                                'DK' => 'Denmark',
                                                                'DJ' => 'Djibouti',
                                                                'DM' => 'Dominica',
                                                                'DO' => 'Dominican Republic',
                                                                'EC' => 'Ecuador',
                                                                'EG' => 'Egypt',
                                                                'SV' => 'El Salvador',
                                                                'GQ' => 'Equatorial Guinea',
                                                                'ER' => 'Eritrea',
                                                                'EE' => 'Estonia',
                                                                'ET' => 'Ethiopia',
                                                                'FO' => 'Faroe Islands',
                                                                'FK' => 'Falkland Islands (Malvinas)',
                                                                'FJ' => 'Fiji the Fiji Islands',
                                                                'FI' => 'Finland',
                                                                'FR' => 'France, French Republic',
                                                                'GF' => 'French Guiana',
                                                                'PF' => 'French Polynesia',
                                                                'TF' => 'French Southern Territories',
                                                                'GA' => 'Gabon',
                                                                'GM' => 'Gambia the',
                                                                'GE' => 'Georgia',
                                                                'DE' => 'Germany',
                                                                'GH' => 'Ghana',
                                                                'GI' => 'Gibraltar',
                                                                'GR' => 'Greece',
                                                                'GL' => 'Greenland',
                                                                'GD' => 'Grenada',
                                                                'GP' => 'Guadeloupe',
                                                                'GU' => 'Guam',
                                                                'GT' => 'Guatemala',
                                                                'GG' => 'Guernsey',
                                                                'GN' => 'Guinea',
                                                                'GW' => 'Guinea-Bissau',
                                                                'GY' => 'Guyana',
                                                                'HT' => 'Haiti',
                                                                'HM' => 'Heard Island and McDonald Islands',
                                                                'VA' => 'Holy See (Vatican City State)',
                                                                'HN' => 'Honduras',
                                                                'HK' => 'Hong Kong',
                                                                'HU' => 'Hungary',
                                                                'IS' => 'Iceland',
                                                                'IN' => 'India',
                                                                'ID' => 'Indonesia',
                                                                'IR' => 'Iran',
                                                                'IQ' => 'Iraq',
                                                                'IE' => 'Ireland',
                                                                'IM' => 'Isle of Man',
                                                                'IL' => 'Israel',
                                                                'IT' => 'Italy',
                                                                'JM' => 'Jamaica',
                                                                'JP' => 'Japan',
                                                                'JE' => 'Jersey',
                                                                'JO' => 'Jordan',
                                                                'KZ' => 'Kazakhstan',
                                                                'KE' => 'Kenya',
                                                                'KI' => 'Kiribati',
                                                                'KP' => 'Korea',
                                                                'KR' => 'Korea',
                                                                'KW' => 'Kuwait',
                                                                'KG' => 'Kyrgyz Republic',
                                                                'LA' => 'Lao',
                                                                'LV' => 'Latvia',
                                                                'LB' => 'Lebanon',
                                                                'LS' => 'Lesotho',
                                                                'LR' => 'Liberia',
                                                                'LY' => 'Libyan Arab Jamahiriya',
                                                                'LI' => 'Liechtenstein',
                                                                'LT' => 'Lithuania',
                                                                'LU' => 'Luxembourg',
                                                                'MO' => 'Macao',
                                                                'MK' => 'Macedonia',
                                                                'MG' => 'Madagascar',
                                                                'MW' => 'Malawi',
                                                                'MY' => 'Malaysia',
                                                                'MV' => 'Maldives',
                                                                'ML' => 'Mali',
                                                                'MT' => 'Malta',
                                                                'MH' => 'Marshall Islands',
                                                                'MQ' => 'Martinique',
                                                                'MR' => 'Mauritania',
                                                                'MU' => 'Mauritius',
                                                                'YT' => 'Mayotte',
                                                                'MX' => 'Mexico',
                                                                'FM' => 'Micronesia',
                                                                'MD' => 'Moldova',
                                                                'MC' => 'Monaco',
                                                                'MN' => 'Mongolia',
                                                                'ME' => 'Montenegro',
                                                                'MS' => 'Montserrat',
                                                                'MA' => 'Morocco',
                                                                'MZ' => 'Mozambique',
                                                                'MM' => 'Myanmar',
                                                                'NA' => 'Namibia',
                                                                'NR' => 'Nauru',
                                                                'NP' => 'Nepal',
                                                                'AN' => 'Netherlands Antilles',
                                                                'NL' => 'Netherlands the',
                                                                'NC' => 'New Caledonia',
                                                                'NZ' => 'New Zealand',
                                                                'NI' => 'Nicaragua',
                                                                'NE' => 'Niger',
                                                                'NG' => 'Nigeria',
                                                                'NU' => 'Niue',
                                                                'NF' => 'Norfolk Island',
                                                                'MP' => 'Northern Mariana Islands',
                                                                'NO' => 'Norway',
                                                                'OM' => 'Oman',
                                                                'PK' => 'Pakistan',
                                                                'PW' => 'Palau',
                                                                'PS' => 'Palestinian Territory',
                                                                'PA' => 'Panama',
                                                                'PG' => 'Papua New Guinea',
                                                                'PY' => 'Paraguay',
                                                                'PE' => 'Peru',
                                                                'PH' => 'Philippines',
                                                                'PN' => 'Pitcairn Islands',
                                                                'PL' => 'Poland',
                                                                'PT' => 'Portugal, Portuguese Republic',
                                                                'PR' => 'Puerto Rico',
                                                                'QA' => 'Qatar',
                                                                'RE' => 'Reunion',
                                                                'RO' => 'Romania',
                                                                'RU' => 'Russian Federation',
                                                                'RW' => 'Rwanda',
                                                                'BL' => 'Saint Barthelemy',
                                                                'SH' => 'Saint Helena',
                                                                'KN' => 'Saint Kitts and Nevis',
                                                                'LC' => 'Saint Lucia',
                                                                'MF' => 'Saint Martin',
                                                                'PM' => 'Saint Pierre and Miquelon',
                                                                'VC' => 'Saint Vincent and the Grenadines',
                                                                'WS' => 'Samoa',
                                                                'SM' => 'San Marino',
                                                                'ST' => 'Sao Tome and Principe',
                                                                'SA' => 'Saudi Arabia',
                                                                'SN' => 'Senegal',
                                                                'RS' => 'Serbia',
                                                                'SC' => 'Seychelles',
                                                                'SL' => 'Sierra Leone',
                                                                'SG' => 'Singapore',
                                                                'SK' => 'Slovakia (Slovak Republic)',
                                                                'SI' => 'Slovenia',
                                                                'SB' => 'Solomon Islands',
                                                                'SO' => 'Somalia, Somali Republic',
                                                                'ZA' => 'South Africa',
                                                                'GS' => 'South Georgia and the South Sandwich Islands',
                                                                'ES' => 'Spain',
                                                                'LK' => 'Sri Lanka',
                                                                'SD' => 'Sudan',
                                                                'SR' => 'Suriname',
                                                                'SJ' => 'Svalbard & Jan Mayen Islands',
                                                                'SZ' => 'Swaziland',
                                                                'SE' => 'Sweden',
                                                                'CH' => 'Switzerland, Swiss Confederation',
                                                                'SY' => 'Syrian Arab Republic',
                                                                'TW' => 'Taiwan',
                                                                'TJ' => 'Tajikistan',
                                                                'TZ' => 'Tanzania',
                                                                'TH' => 'Thailand',
                                                                'TL' => 'Timor-Leste',
                                                                'TG' => 'Togo',
                                                                'TK' => 'Tokelau',
                                                                'TO' => 'Tonga',
                                                                'TT' => 'Trinidad and Tobago',
                                                                'TN' => 'Tunisia',
                                                                'TR' => 'Turkey',
                                                                'TM' => 'Turkmenistan',
                                                                'TC' => 'Turks and Caicos Islands',
                                                                'TV' => 'Tuvalu',
                                                                'UG' => 'Uganda',
                                                                'UA' => 'Ukraine',
                                                                'AE' => 'United Arab Emirates',
                                                                'GB' => 'United Kingdom',
                                                                'US' => 'United States of America',
                                                                'UM' => 'United States Minor Outlying Islands',
                                                                'VI' => 'United States Virgin Islands',
                                                                'UY' => 'Uruguay, Eastern Republic of',
                                                                'UZ' => 'Uzbekistan',
                                                                'VU' => 'Vanuatu',
                                                                'VE' => 'Venezuela',
                                                                'VN' => 'Vietnam',
                                                                'WF' => 'Wallis and Futuna',
                                                                'EH' => 'Western Sahara',
                                                                'YE' => 'Yemen',
                                                                'ZM' => 'Zambia',
                                                                'ZW' => 'Zimbabwe'
                                                            );

                                                            if( !$countryList[$code] ) return $code;
                                                            else return $countryList[$code];
                                                        }

                                                        function renderEmailLineAdminNewOrder($label,$para){
                                                            if($para!=null && $para!='') {
                                                                echo '<p><strong>'.$label.': </strong>'.$para.'</p>';
                                                            } else echo '';
                                                        }

                                                        $billing_salutation = get_post_meta( $order_id, 'billing_salutation', true ) ?? '';
                                                        $billing_title = get_post_meta( $order_id, 'billing_title', true ) ?? '';
                                                        $billing_first_name = $order->get_billing_first_name() ?? '';
                                                        $billing_last_name = $order->get_billing_last_name() ?? '';
                                                        $billing_company = $order->get_billing_company() ?? '';
                                                        $billing_division = get_post_meta( $order_id, 'billing_division', true ) ?? '';
                                                        $billing_address_1 = $order->get_billing_address_1() ?? '';
                                                        $billing_postcode = $order->get_billing_postcode() ?? '';
                                                        $billing_city = $order->get_billing_city() ?? '';
                                                        $billing_country = code_to_country_admin_new_order($order->get_billing_country()) ?? '';
                                                        $billing_phone = $order->get_billing_phone() ?? '';
                                                        $billing_fax = get_post_meta( $order_id, 'billing_fax', true ) ?? '';
                                                        $billing_email = $order->get_billing_email() ?? '';
                                                        $billing_coupon_code = get_post_meta( $order_id, 'billing_coupon_code', true ) ?? '';
                                                        $billing_vat_number = get_post_meta( $order_id, 'billing_vat_number', true ) ?? '';
                                                        $billing_order_number = get_post_meta( $order_id, 'billing_order_number', true ) ?? '';
                                                        $billing_message = get_post_meta( $order_id, 'billing_message', true ) ?? '';

                                                        $salutationLabel = __('Salutation');
                                                        $titleLabel = __('Title');
                                                        $firstNameLabel = __('First name');
                                                        $lastNameLabel = __('Last name');
                                                        $companyLabel = __('Company');
                                                        $divisionLabel = __('Division');
                                                        $addressLabel = __('Address');
                                                        $postalCodeLabel = __('Postal code');
                                                        $cityLabel = __('City');
                                                        $countryLabel = __('Country');
                                                        $phoneLabel = __('Phone');
                                                        $faxLabel = __('Fax');
                                                        $emailLabel = __('Email');
                                                        $couponCodeLabel = __('Coupon code');
                                                        $VATNumberLabel = __('VAT number');
                                                        $orderNumberLabel = __('Order number');
                                                        $messageLabel = __('Message');

                                                        renderEmailLineAdminNewOrder($salutationLabel,$billing_salutation);
                                                        renderEmailLineAdminNewOrder($titleLabel,$billing_title);
                                                        renderEmailLineAdminNewOrder($firstNameLabel,$billing_first_name);
                                                        renderEmailLineAdminNewOrder($lastNameLabel,$billing_last_name);
                                                        renderEmailLineAdminNewOrder($companyLabel,$billing_company);
                                                        renderEmailLineAdminNewOrder($divisionLabel,$billing_division);
                                                        renderEmailLineAdminNewOrder($addressLabel,$billing_address_1);
                                                        renderEmailLineAdminNewOrder($postalCodeLabel,$billing_postcode);
                                                        renderEmailLineAdminNewOrder($cityLabel,$billing_city);
                                                        renderEmailLineAdminNewOrder($countryLabel,$billing_country);
                                                        renderEmailLineAdminNewOrder($phoneLabel,$billing_phone);
                                                        renderEmailLineAdminNewOrder($faxLabel,$billing_fax);
                                                        renderEmailLineAdminNewOrder($emailLabel,$billing_email);
                                                        renderEmailLineAdminNewOrder($couponCodeLabel,$billing_coupon_code);
                                                        renderEmailLineAdminNewOrder($VATNumberLabel,$billing_vat_number);
                                                        renderEmailLineAdminNewOrder($orderNumberLabel,$billing_order_number);
                                                        renderEmailLineAdminNewOrder($messageLabel,$billing_message);

                                                        if ( $order->has_shipping_address()  && get_post_meta($order_id,'order_custom_ship_to_different_address',true)==1) {
                                                            echo '<h3>Billing address</h3>';
                                                            $shipping_salutation = get_post_meta( $order_id, 'shipping_salutation', true ) ?? '';
                                                            $shipping_title = get_post_meta( $order_id, 'shipping_title', true ) ?? '';
                                                            $shipping_first_name = $order->get_shipping_first_name() ?? '';
                                                            $shipping_last_name = $order->get_shipping_last_name() ?? '';
                                                            $shipping_company = $order->get_shipping_company() ?? '';
                                                            $shipping_division = get_post_meta( $order_id, 'shipping_division', true ) ?? '';
                                                            $shipping_address_1 = $order->get_shipping_address_1() ?? '';
                                                            $shipping_postcode = $order->get_shipping_postcode() ?? '';
                                                            $shipping_city = $order->get_shipping_city() ?? '';
                                                            $shipping_country = code_to_country_admin_new_order($order->get_shipping_country()) ?? '';
                                                            $shipping_phone = get_post_meta( $order_id, 'shipping_phone', true ) ?? '';
                                                            $shipping_fax = get_post_meta( $order_id, 'shipping_fax', true ) ?? '';
                                                            $shipping_email = get_post_meta( $order_id, 'shipping_email', true ) ?? '';
                                                            $shipping_coupon_code = get_post_meta( $order_id, 'shipping_coupon_code', true ) ?? '';
                                                            $shipping_vat_number = get_post_meta( $order_id, 'shipping_vat_number', true ) ?? '';
                                                            $shipping_order_number = get_post_meta( $order_id, 'shipping_order_number', true ) ?? '';
                                                            $shipping_message = get_post_meta( $order_id, 'shipping_message', true ) ?? '';

                                                            renderEmailLineAdminNewOrder($salutationLabel,$shipping_salutation);
                                                            renderEmailLineAdminNewOrder($titleLabel,$shipping_title);
                                                            renderEmailLineAdminNewOrder($firstNameLabel,$shipping_first_name);
                                                            renderEmailLineAdminNewOrder($lastNameLabel,$shipping_last_name);
                                                            renderEmailLineAdminNewOrder($companyLabel,$shipping_company);
                                                            renderEmailLineAdminNewOrder($divisionLabel,$shipping_division);
                                                            renderEmailLineAdminNewOrder($addressLabel,$shipping_address_1);
                                                            renderEmailLineAdminNewOrder($postalCodeLabel,$shipping_postcode);
                                                            renderEmailLineAdminNewOrder($cityLabel,$shipping_city);
                                                            renderEmailLineAdminNewOrder($countryLabel,$shipping_country);
                                                            renderEmailLineAdminNewOrder($phoneLabel,$shipping_phone);
                                                            renderEmailLineAdminNewOrder($faxLabel,$shipping_fax);
                                                            renderEmailLineAdminNewOrder($emailLabel,$shipping_email);
                                                            renderEmailLineAdminNewOrder($couponCodeLabel,$shipping_coupon_code);
                                                            renderEmailLineAdminNewOrder($VATNumberLabel,$shipping_vat_number);
                                                            renderEmailLineAdminNewOrder($orderNumberLabel,$shipping_order_number);
                                                            renderEmailLineAdminNewOrder($messageLabel,$shipping_message);
                                                        }

                                                        $room_reservation = get_post_meta( $order_id, 'room_reservation', true );
                                                        echo '<br>';
                                                        echo '<p><strong>'.__('In house training').':</strong> ' . (get_post_meta( $order_id, 'in_house_training', true )?"yes":"no") . '</p>';
                                                        echo '<p><strong>'.__('Room Reservation').':</strong> ' . ($room_reservation?"yes":"no") . '</p>';
                                                        if ($room_reservation) {
                                                            echo '<p><strong>'.__('Arrival date').':</strong> ' . get_post_meta( $order_id, 'arrival_date', true ) . '</p>';
                                                            echo '<p><strong>'.__('Departure date').':</strong> ' . get_post_meta( $order_id, 'departure_date', true ) . '</p>';
                                                        }
                                                        echo '<br>';
                                                        ?>

                                                        <p><strong>I've confirmed the terms and conditions.</strong></p>
                                                        <p><strong>I've confirmed the privacy policy.</strong></p>

                                                        <div>
                                                            <div style="padding:20px 10px;font-size:13px;color:#5c5c5c;text-align:center"> <?php echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ); ?> </div>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>