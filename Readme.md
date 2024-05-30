# SuperMarket Checkout System

This is a simple checkout system implemented in PHP. It allows you to scan items, apply promotions, and calculate the total price based on the pricing rules and promotions.

## prerequisite 
``
PHP 8.0 or Local PHP server
``

## Getting Started

1. clone the repository to your local machine:

```bash
git clone git@github.com:rahulsinghchauhan14/checkout-kata.git
```

2. Navigate to the project directory:

```bash
cd checkout-kata
```

3. You can add or modify the pricing rules and promotions within the index.php file.

```php
$pricingRules = [
    ['item' => 'A', 'price' => 50],
    ['item' => 'B', 'price' => 75],
    ['item' => 'C', 'price' => 25],
    ['item' => 'D', 'price' => 150],
    ['item' => 'E', 'price' => 200],
];

$promotionsData = [
    ['type' => 'multipriced', 'item' => 'B', 'quantity' => 2, 'price' => 125],
    ['type' => 'buy_get_free', 'item' => 'C', 'quantity' => 3],
    ['type' => 'meal_deal','item' => 'D', 'items' => ['D', 'E'], 'price' => 300],
    ['type' => 'meal_deal', 'item' => 'E', 'items' => ['D', 'E'], 'price' => 300],
    ['type' => 'buy_get_free', 'item' => 'A', 'quantity' => 4],
];
```

4. AddToCart

```php
$checkout->addToCart('E');
$checkout->addToCart('D');
$checkout->addToCart('A');
$checkout->addToCart('C');
$checkout->addToCart('C');
$checkout->addToCart('C');
$checkout->addToCart('C');
```

5. get the total price

```php
$totalPrice = $checkout->cartTotal();
echo "Total Price: $totalPrice pence";
```

6. to see the response run the below command into the terminal

```bash
php {path to the project directory}/index.php
```

or

```html
You can directly open the file into your browser
url: {localserver url}/{project path}/index.php
```