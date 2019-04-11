<?php declare(strict_types=1);

namespace VinaiKopp\CurrentProductExample\Registry;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;

class CurrentProduct
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var ProductInterfaceFactory
     */
    private $productFactory;

    public function __construct(ProductInterfaceFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    public function set(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function get(): ProductInterface
    {
        return $this->product ?? $this->createNullProduct();
    }

    private function createNullProduct(): ProductInterface
    {
        return $this->productFactory->create();
    }
}
