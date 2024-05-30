<?php

namespace CheckoutSystem;

class Checkout
{

    private $pricingRules;
    private $promotions;
    private $cart = [];

    public function __construct(PricingRules $pricingRules, Promotions $promotions)
    {
        $this->pricingRules = $pricingRules;
        $this->promotions = $promotions;
    }

    public function addToCart($item)
    {

        if (!$this->pricingRules->getPrice($item)) {
            return false;
        }

        /*
        add item into cart if not present,
        else increase the item count
         */
        if (!isset($this->cart[$item])) {
            $this->cart[$item] = 1;
        } else {
            $this->cart[$item]++;
        }

        return true;

    }

    public function cartTotal()
    {
        $cartTotal = 0;
        $remainingItems = $this->cart;

         // Apply promotions
         foreach ($this->promotions->getPromotions(array_keys($remainingItems)) as $item => $promotion) {
            if ($promotion instanceof MealDeal) {
                $price = $this->pricingRules->getPrice($item);
                $quantity = $remainingItems[$item];
                $cartTotal += $promotion->calculatePrice($price, $quantity, $remainingItems);
            }
        }

        print_r($remainingItems);
        
        foreach ($remainingItems as $item => $quantity) {
            $price = $this->pricingRules->getPrice($item);
            $promotions = $this->promotions->getPromotions($item);

            if($promotions) {
                $bestPrice = $price * $quantity;

                foreach($promotions as $promotion){
                    $promotionalPrice = $promotion->calculatePrice($price, $quantity,  $remainingItems);
                    if($promotionalPrice > 0 && $promotionalPrice < $bestPrice){
                        $bestPrice = $promotionalPrice;
                    }
                }
                $cartTotal += $bestPrice;
            }else{
                $cartTotal += $price * $quantity;
            }

        }

        return $cartTotal;
    }

    public function updatePricingRules(array $pricingRules)
    {
        $this->pricingRules->updatePrices($pricingRules);
    }

    public function updatePromotions(array $promotions)
    {
        $this->promotions = new Promotions($promotions);
    }
}
