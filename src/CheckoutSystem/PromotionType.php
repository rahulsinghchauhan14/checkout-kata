<?php

namespace CheckoutSystem;

interface PromotionType {
    public function calculatePrice($price, $quantity, &$remainingItems);
    public function getItem();
}

class MultiPriced implements PromotionType {

    private $item;
    private $quantity;
    private $promotionalPrice;

    public function __construct($item, $quantity, $promotionalPrice){
        $this->item = $item;
        $this->quantity = $quantity;
        $this->promotionalPrice = $promotionalPrice;
    }

    public function calculatePrice($price, $quantity,  &$remainingItems){
        return floor($quantity / $this->quantity) * $this->promotionalPrice + ($quantity % $this->quantity) * $price;
    }

    public function getItem() {
        return $this->item;
    }

}

class BuyNGetFreeN implements PromotionType {

    private $item;
    private $quantity;

    public function __construct($item,$quantity){
        $this->item = $item;
        $this->quantity = $quantity;
    }

    public function calculatePrice($price, $quantity,  &$remainingItems){
        return ($quantity - floor($quantity / ($this->quantity + 1))) * $price;
    }

    public function getItem() {
        return $this->item;
    }

}

class MealDeal implements PromotionType {
    
    private $items;
    private $promotionalPrice;

    public function __construct(array $items, $promotionalPrice){
        $this->items = $items;
        $this->promotionalPrice = $promotionalPrice;
    }

    public function calculatePrice($prices, $quantities, &$remainingItems) {
        $minSets = min(array_map(fn($item) => $remainingItems[$item] ?? 0, $this->items));
        $total = $minSets * $this->promotionalPrice;

        // Reduce quantities for items in the deal
        foreach ($this->items as $item) {
            if(isset($remainingItems[$item])){
                $remainingItems[$item] -= $minSets;
            }
        }

        return $total;
    }


    public function getItem() {
        return $this->items;
    }
}