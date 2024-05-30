<?php

require_once 'src/CheckoutSystem/PricingRules.php';
require_once 'src/CheckoutSystem/Promotions.php';
require_once 'src/CheckoutSystem/Checkout.php';
require_once 'src/CheckoutSystem/PromotionType.php';

use CheckoutSystem\PricingRules;
use CheckoutSystem\Promotions;
use CheckoutSystem\Checkout;
use CheckoutSystem\MultiPriced;
use CheckoutSystem\BuyNGetFreeN;
use CheckoutSystem\MealDeal;

// Example input
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

$pricingRules = new PricingRules($pricingRules);
$promotions = new Promotions([]);

foreach ($promotionsData as $promotionData) {
    switch ($promotionData['type']) {
        case 'multipriced':
            $promotions->addPromotion(new MultiPriced($promotionData['item'],$promotionData['quantity'], $promotionData['price']));
            break;
        case 'buy_get_free':
            $promotions->addPromotion(new BuyNGetFreeN($promotionData['item'],$promotionData['quantity']));
            break;
        case 'meal_deal':
            $promotions->addPromotion(new MealDeal($promotionData['items'], $promotionData['price']));
            break;
    }
}

$checkout = new Checkout($pricingRules, $promotions);
// print_r($checkouts);
// add to cart items

$checkout->addToCart('E');
$checkout->addToCart('D');
// $checkout->addToCart('A');

 
$checkout->addToCart('C');
$checkout->addToCart('C');
$checkout->addToCart('C');
$checkout->addToCart('C');

// $checkout->addToCart('E');
// $checkout->addToCart('E');
// $checkout->addToCart('E');
// $checkout->addToCart('E');

// Get the total price
$totalPrice = $checkout->cartTotal();
echo "Total Price: $totalPrice pence"; // Output: Total Price: 1275 pence
