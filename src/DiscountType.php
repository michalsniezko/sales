<?php

declare(strict_types=1);

namespace Sales;

enum DiscountType
{
    case NO_DISCOUNT;
    case FIFTH_PRODUCT_FREE;
    case TEN_PERCENT_OFF_OVER_100;
}
