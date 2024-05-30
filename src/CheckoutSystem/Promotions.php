<?php

namespace CheckoutSystem;

class Promotions
{

    private $promotions = [];

    public function __construct(array $promotions)
    {
        foreach ($promotions as $promotion) {
            $this->addPromotion($promotion);
        }
    }

    public function addPromotion($promotion)
    {
        // $item = $promotion->getItem();
        $items = (array) $promotion->getItem();
        foreach ($items as $item) {
            $this->promotions[$item][] = $promotion;
        }
    }

    public function getPromotions($items){
        $promotions = [];
        foreach ((array) $items as $item) {
            $promotions[$item] = $this->promotions[$item][0] ?? null;
        }
        return $promotions;
    }

    public function removeSpecial($item)
    {
        unset($this->promotoins[$item]);
    }

}
