<?php declare(strict_types=1);

namespace VinaiKopp\CurrentProductExample\Registry;

use Magento\Catalog\Api\Data\ProductInterface;

class CurrentProduct
{
    /**
     * @var ProductInterface
     */
    private $product;

    public function set(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function get(): ?ProductInterface
    {
        return $this->product;
    }
}
