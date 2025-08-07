<?php

declare(strict_types=1);

namespace Sales\Discount;

use Sales\Offer;

interface DiscountInterface
{
    public function apply(array $products): Offer;
}
