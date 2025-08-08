Simple library to calculate discounts. Possible to write own discounts by implementing DiscountInterface and passing
them via constructor injection to Cart.

Usage (default discounts):

```php
$cart = new Cart();
$cart = new Cart();

$product = new Product('item1', 25.0);
$product = new Product('item2', 50.0);

$offer = $cart->checkout();

$totalAfterDiscount = $offer->getTotalAfterDiscount();
```
