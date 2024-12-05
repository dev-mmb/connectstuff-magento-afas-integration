<?php

namespace Connectstuff\MagentoAfasIntegration\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\DeploymentConfig;

class OrderCreated implements ObserverInterface
{
    protected $curl;
    protected $logger;
    private $deploymentConfig;
    
    public function __construct(Curl $curl, LoggerInterface $logger, DeploymentConfig $deploymentConfig)
    {
        $this->curl = $curl;
        $this->logger = $logger;
        $this->deploymentConfig = $deploymentConfig;
    }

    public function execute(Observer $observer)
    {
        try {
            // Get the order object
            $order = $observer->getEvent()->getOrder();

            $key = $this->deploymentConfig->get('CONNECTSTUFF_KEY') ?? '';
            $url = $this->deploymentConfig->get('CONNECTSTUFF_URL') ?? '';

            $payment = $order->getPayment();
            // Prepare data for HTTP request
            $data = [
                'key' => $key,
                'data' => get_mangled_object_vars($order),
                'payment' => get_mangled_object_vars($order->getPayment())
            ];
            $this->curl->setHeaders([
                'Content-Type' => 'application/json'
            ]);
            // Make HTTP POST request
            $this->curl->post($url, json_encode($data));

            // Log the response
            $response = $this->curl->getBody();
        } catch (\Exception $e) {
            $this->logger->error('Order Notifier Error: ' . $e->getMessage());
        }
    }
}
