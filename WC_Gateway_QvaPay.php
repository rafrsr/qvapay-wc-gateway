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
 * QvaPay Payment Gateway for WooCommerce
 */
class WC_Gateway_QvaPay extends WC_Payment_Gateway_CC
{
    const QVAPAY_LOGO = "data:image/jpg;base64,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";

    /**
     * Whether or not logging is enabled
     *
     * @var bool
     */
    public static $logEnabled = false;

    /**
     * Logger instance
     *
     * @var WC_Logger
     */
    public static $log = false;

    public function __construct()
    {
        $this->id = 'qvapay';
        $this->has_fields = false;
        $this->method_title = __('QvaPay', 'qvapay');
        $this->method_description = __('Use your QvaPay account to accept payments', 'qvapay');
        $this->supports = [
            'products',
        ];

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables.
        $this->title = 'QvaPay';
        $logo = self::QVAPAY_LOGO;
        $this->description = "<img src=\"$logo\" alt=\"QvaPay\"/>";

        self::$logEnabled = 'yes' === $this->get_option('debug', 'no');

        add_action('woocommerce_update_options_payment_gateways_'.$this->id, [$this, 'process_admin_options']);
        add_action('woocommerce_api_'.$this->getWebhookName(), [$this, 'webHookHandler']);
    }

    /**
     * Gateway settings
     */
    function admin_options()
    {
        parent::admin_options();

        $url = wc()->api_request_url($this->getWebhookName());

        $message = __('Remember to setup this url in your application settings within QvaPay in order to receive the webhook event every time a payment is processed.', 'qvapay');

        echo <<<HTML
<h2>WebHook</h2>
<a target="_blank" href="$url">$url</a>
<br>
<p class="marketplace_suggestions-description">
$message
</p>
HTML;

    }

    /**
     * Initialise Gateway Settings Form Fields.
     */
    public function init_form_fields()
    {
        $this->form_fields = include __DIR__.DIRECTORY_SEPARATOR.'settings.php';
    }

    /**
     * Payment information
     */
    public function form()
    {
        $description = $this->get_description();
        if ($description) {
            echo wpautop(wptexturize($description));
        }
    }

    /**
     * Process the payment using QvaPay API and return the result.
     *
     * @param int $order_id Order ID.
     *
     * @return array
     */
    public function process_payment($order_id)
    {
        /** @var WC_Order $order */
        $order = wc_get_order($order_id);
        $description = sprintf(__('Order: #%2$s', 'qvapay'), get_bloginfo('name'), $order->get_id());
        $query = http_build_query(
            [
                'app_id' => $this->get_option('app_id'),
                'app_secret' => $this->get_option('app_secret'),
                'amount' => number_format($order->get_total(), 2, '.', ''),
                'description' => $description,
                'remote_id' => $order->get_id(),
                'signed' => "1",
            ]
        );

        $apiCall = sprintf('https://qvapay.com/api/v1/create_invoice?%s', $query);

        self::log(sprintf(__('Preparing invoice for order #%1$s: %2$s', 'qvapay'), $order_id, $apiCall));

        $response = wp_remote_get($apiCall);

        if (isset($response['body'])) {
            $data = @json_decode($response['body'], true);
            if (isset($data['signedUrl'])) {

                self::log(sprintf(__('Invoice url created successfully: %1$s', 'qvapay'), $data['signedUrl']));

                // Remove cart.
                if ( isset( WC()->cart ) ) {
                    WC()->cart->empty_cart();
                }

                return [
                    'result' => 'success',
                    'redirect' => $data['signedUrl'],
                ];
            }
        }

        $error = 'Unknown error';
        if ($response instanceof WP_Error) {
            $error = $response->get_error_message();
        }

        self::log(sprintf(__('Error creating the invoice: #%1$s', 'qvapay'), $error), 'error');

        wc_add_notice(__('Payment error:', 'woothemes').$error, 'error');

        return null;
    }

    /**
     * Handler to process webhook event and mark the order as paid
     *
     * @return void
     */
    public function webHookHandler()
    {
        if (!isset($_SERVER['QUERY_STRING'])) {
            self::log('WebHook received without valid arguments', 'error');
            wp_die('Not found', null, ['response' => 400]);
        }

        parse_str($_SERVER['QUERY_STRING'], $result);

        /** @var WC_Order $order */
        if (!isset($result['remote_id'], $result['id'])
            || !$result['remote_id']
            || !$result['id']
            || !$order = wc_get_order($result['remote_id'])) {
            self::log('WebHook received without valid order number', 'error');
            wp_die('Not found', null, ['response' => 406]);
        }

        if ($order->is_paid()) {
            self::log('Duplicate webhook event', 'warning');
            wp_die('This payment has already been completed', null, ['response' => 409]);
        }

        self::log(sprintf('Payment webhook received, the order %1$s has been marked as completed', $order->get_id()));

        $order->add_order_note(__('QvaPay payment completed', 'qvapay'));
        $order->payment_complete($result['id']);
    }

    /**
     * Resolver webhook name from settings or resolve default using site url
     *
     * @return string
     */
    protected function getWebhookName()
    {
        $hash = $this->get_option('webhook_hash', md5(get_site_url()));

        return sprintf('qvapay-%s', $hash);
    }

    /**
     * Logging method.
     *
     * @param string $message Log message.
     * @param string $level   Optional. Default 'info'. Possible values:
     *                        emergency|alert|critical|error|warning|notice|info|debug.
     */
    protected static function log($message, $level = 'info')
    {
        if (self::$logEnabled) {
            if (empty(self::$log)) {
                self::$log = wc_get_logger();
            }
            self::$log->log($level, $message, ['source' => 'qvapay']);
        }
    }
}