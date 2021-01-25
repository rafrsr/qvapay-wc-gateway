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

defined('ABSPATH') || exit;

return [
    'enabled' => [
        'title' => __('Enable/Disable', 'qvapay'),
        'type' => 'checkbox',
        'label' => __('Enable QvaPay', 'qvapay'),
        'default' => 'yes',
    ],
    'app_id' => [
        'title' => __('APP ID', 'qvapay'),
        'type' => 'text',
        'default' => '',
        'required' => true,
        'desc_tip' => true,
    ],
    'app_secret' => [
        'title' => __('APP Secret', 'qvapay'),
        'type' => 'text',
        'default' => '',
        'desc_tip' => true,
    ],
    'debug' => [
        'title' => __('Debug Errors', 'qvapay'),
        'type' => 'checkbox',
        'label' => __('Enable Logs', 'qvapay'),
        'default' => 'no',
        'description' => sprintf(__(
            'Save logs for all events during the payment process. <br/> May contains sensitive information and must be enabled only for debugging purposes <br/><br/> Can check your logs easily <a href="%1$s">here</a>',
            'qvapay'
        ),'/wp-admin/admin.php?page=wc-status&tab=logs'),
    ],
    'webhook_hash' => [
        'title' => __('WebHook Hash', 'qvapay'),
        'type' => 'string',
        'description' => __(
            'This hash is used to create a unique url for your webhook.<br/> Once configured in your QvaPay application should NOT BE modified <br/> otherwise your application will stop working. <br/> We suggest use a hard to guess url in order to avoid fake requests.',
            'qvapay'
        ),
        'default' => md5(get_site_url()),
        'desc_tip' => false,
    ],
];
