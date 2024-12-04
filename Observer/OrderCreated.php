<?php

namespace Connectstuff\OrderNotifier\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class OrderCreated implements ObserverInterface
{
    protected $curl;
    protected $logger;

    public function __construct(Curl $curl, LoggerInterface $logger)
    {
        $this->curl = $curl;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        try {
            // Get the order object
            $order = $observer->getEvent()->getOrder();

            $key = 'ZKzU^_AP2n51?a)qFQ*-8h{debk]?}@Ou_U%<//ScuZBpjO0<BYI4M.&fT3)k'; // 
            $url = 'https://magento-integ-7.hoststuff.nl/api/order'; // 

            // Prepare data for HTTP request
            $data = [
                'key' => $key,
                'order_id' => $order->getIncrementId(),
                'status' => $order->getStatus(),
                'status_label' => $order->getStatusLabel(),
                'created_at' => $order->getCreatedAt(),
                'subtotal' => $order->getSubtotal(),
                'base_grand_total' => $order->getBaseGrandTotal(),
                'grand_total' => $order->getGrandTotal(),
                'customer_id' => $order->getCustomerId(),
                'base_currency_code' => $order->getBaseCurrencyCode(),
                'global_currency_code' => $order->getGlobalCurrencyCode(),
                'order_currency_code' => $order->getOrderCurrencyCode(),
                'payment_method' => $result->getPayment()->getMethod(),
            ];

            // Make HTTP POST request
            $this->curl->post($url, json_encode($data));

            // Log the response
            $response = $this->curl->getBody();
        } catch (\Exception $e) {
            $this->logger->error('Order Notifier Error: ' . $e->getMessage());
        }
    }
}
