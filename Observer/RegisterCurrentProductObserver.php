<?php declare(strict_types=1);

namespace VinaiKopp\CurrentProductExample\Observer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;
use VinaiKopp\CurrentProductExample\Registry\CurrentProduct;

class RegisterCurrentProductObserver implements ObserverInterface
{
    /**
     * @var CurrentProduct
     */
    private $currentProduct;

    public function __construct(CurrentProduct $currentProduct)
    {
        $this->currentProduct = $currentProduct;
    }

    public function execute(Event $event)
    {
        /** @var ProductInterface $product */
        $product = $event->getData('product');
        $this->currentProduct->set($product);
    }
}
