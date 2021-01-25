<?php
/*
 * *****************************************************************************
 *   This file is part of the QvaPay package.
 *
 *   (c) Rafael Santos <raf.rsr@gmail.com>
 *
 *   For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 * ****************************************************************************
 */

/**
 * Plugin Name: QvaPay for WooCommerce
 * Plugin URI: https://github.com/rafrsr/qvapay-wc-gateway
 * Description: Use your QvaPay account to accept payments
 * Version: 1.0
 * Author: Rafael Santos
 * Author URI: https://github.com/rafrsr
 * Requires at least: 4.3
 * Requires PHP:      5.6
 * WC requires at least: 3.4
 * WC tested up to: 4.9
 * Text Domain: qvapay
 * Domain Path: /languages
 **/

if (!defined('ABSPATH')) {
    exit;
}

// verify WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action(
        'admin_notices',
        function () {

            $message = sprintf(
                __('QvaPay gateway for WooCommerce is <strong>Enabled</strong> but require %1$s to works. Please ensure you have %1$s installed and enabled.'),
                '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>'
            );
            $notice = <<<HTML
    <div class="notice notice-error is-dismissible">
        <p>$message</p>
    </div>
HTML;
            echo $notice;

        }
    );

    return;
}

add_action(
    'plugins_loaded',
    static function () {
        load_plugin_textdomain('qvapay', false, basename(__DIR__).'/languages/');

        // verify WooCommerce version
        if (!version_compare(WooCommerce::instance()->version, '3.4', '>=')) {
            add_action(
                'admin_notices',
                static function () {
                    $version = WooCommerce::instance()->version;
                    $message = sprintf(
                        __('QvaPay extension requires %1$s version 3.4 or greater. Your current version (%2$s) is not compatible.'),
                        '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>',
                        $version
                    );
                    $notice = <<<HTML
        <div class="notice notice-error is-dismissible">
            $message
        </div>
HTML;
                    echo $notice;

                }
            );

            return;
        }

        include __DIR__.DIRECTORY_SEPARATOR.'WC_Gateway_QvaPay.php';

        // show "View details" link in plugin list
        add_filter(
            'plugin_row_meta',
            static function ($metas, $file, $plugin_data) {
                if ($file === plugin_basename(__FILE__)) {
                    $haveDetails = false;
                    foreach ($metas as $meta) {
                        if (strpos($meta, 'plugin-information') !== false) {
                            $haveDetails = true;
                        }
                    }

                    if (!$haveDetails) {
                        $metas[] = sprintf(
                            '<a href="%s" class="thickbox open-plugin-details-modal" aria-label="%s" data-title="%s">%s</a>',
                            esc_url(network_admin_url('plugin-install.php?tab=plugin-information&amp;plugin=qvapay&amp;TB_iframe=true')),
                            esc_attr(sprintf(__('More information about %s', 'qvapay'), $plugin_data['Name'])),
                            esc_attr($plugin_data['Name']),
                            __('View details', 'qvapay')
                        );
                    }
                }

                return $metas;
            },
            10,
            3
        );

        add_filter(
            'plugin_action_links_'.plugin_basename(__FILE__),
            static function ($links) {
                $settings = [
                    '<a href="'.admin_url('admin.php?page=wc-settings&tab=checkout&section=qvapay').'">'.__('Settings', 'qvapay').'</a>',
                ];

                return array_merge($settings, $links);
            }
        );

        // register gateway
        add_filter(
            'woocommerce_payment_gateways',
            static function ($gateways) {
                $gateways[] = 'WC_Gateway_QvaPay';

                return $gateways;
            }
        );
    }
);