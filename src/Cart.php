<?php

declare(strict_types=1);

namespace Sales;

use InvalidArgumentException;
use Sales\Discount\DiscountInterface;
use Sales\Discount\FifthProductFreeDiscount;
use Sales\Discount\TenPercentDiscount;

class Cart
{
    private array $products = [];
    private array $discounts = [];

    public function __construct(array $discounts = [new FifthProductFreeDiscount(), new TenPercentDiscount()])
    {
        foreach ($discounts as $discount) {
            if (!$discount instanceof DiscountInterface) {
               throw new InvalidArgumentException('Discount must be an instance of DiscountInterface');
            }

            if (!in_array($discount, $this->discounts, true)) {
                $this->discounts[] = $discount;
            }
        }
    }

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function checkout(): Offer
    {
        $bestOffer = new Offer($this->products, 0, DiscountType::NO_DISCOUNT);

        foreach ($this->discounts as $discount) {
            $offer = $discount->apply($this->products);
            if ($offer->getDiscountAmount() > $bestOffer->getDiscountAmount()) {
                $bestOffer = $offer;
            }
        }

        return $bestOffer;
    }
}
