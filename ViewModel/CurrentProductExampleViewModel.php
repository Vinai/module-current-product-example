<?php declare(strict_types=1);

namespace VinaiKopp\CurrentProductExample\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use VinaiKopp\CurrentProductExample\Registry\CurrentProduct;

class CurrentProductExampleViewModel implements ArgumentInterface
{
    /**
     * @var CurrentProduct
     */
    private $currentProduct;

    public function __construct(CurrentProduct $currentProduct)
    {
        $this->currentProduct = $currentProduct;
    }

    public function getProductName(): string
    {
        return (string) $this->currentProduct->get()->getName();
    }

    public function getProductSku(): string
    {
        return (string) $this->currentProduct->get()->getSku();
    }
}
