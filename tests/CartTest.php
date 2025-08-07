<?php

use PHPUnit\Framework\TestCase;
use Sales\Cart;
use Sales\Discount\FifthProductFreeDiscount;
use Sales\Discount\TenPercentDiscount;
use Sales\DiscountType;
use Sales\Product;

class CartTest extends TestCase
{
    public function testFifthProductFreeDiscount(): void
    {
        $cart = new Cart();
        $product = new Product('candy', 10.0);
        for ($i = 0; $i < 5; $i++) {
            $cart->add($product);
        }

        $offer = $cart->checkout([
            new FifthProductFreeDiscount(),
            new TenPercentDiscount()
        ]);

        $this->assertEquals(50.0, $offer->getTotalBeforeDiscount());
        $this->assertEquals(40.0, $offer->getTotalAfterDiscount());
        $this->assertEquals(DiscountType::FIFTH_PRODUCT_FREE, $offer->getAppliedDiscount());
    }

    public function testTenPercentDiscount(): void
    {
        $cart = new Cart();
        $product = new Product('book', 51.0);
        for ($i = 0; $i < 2; $i++) {
            $cart->add($product);
        }

        $offer = $cart->checkout([
            new FifthProductFreeDiscount(),
            new TenPercentDiscount()
        ]);

        $this->assertEquals(102.0, $offer->getTotalBeforeDiscount());
        $this->assertEquals(91.8, $offer->getTotalAfterDiscount());
        $this->assertEquals(DiscountType::TEN_PERCENT_OFF_OVER_100, $offer->getAppliedDiscount());
    }

    public function testNoDiscount(): void
    {
        $cart = new Cart();
        $cart->add(new Product('pencil', 5.0));

        $offer = $cart->checkout([
            new FifthProductFreeDiscount(),
            new TenPercentDiscount()
        ]);

        $this->assertEquals(5.0, $offer->getTotalBeforeDiscount());
        $this->assertEquals(5.0, $offer->getTotalAfterDiscount());
        $this->assertEquals(DiscountType::NO_DISCOUNT, $offer->getAppliedDiscount());
    }

    public function testDiscountsDoNotStack(): void
    {
        $cart = new Cart();
        $product = new Product('item', 25.0);
        for ($i = 0; $i < 5; $i++) {
            $cart->add($product);
        }

        $offer = $cart->checkout([
            new FifthProductFreeDiscount(),
            new TenPercentDiscount()
        ]);

        $this->assertEquals(125.0, $offer->getTotalBeforeDiscount());
        $this->assertEquals(100.0, $offer->getTotalAfterDiscount());
        $this->assertEquals(DiscountType::FIFTH_PRODUCT_FREE, $offer->getAppliedDiscount());
    }
}
