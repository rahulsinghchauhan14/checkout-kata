<?php

namespace CheckoutSystem;

class PricingRules {

    private $prices = [];

    public function __construct(array $pricingRules){
        $this->updatePrices($pricingRules);
    }

    public function getPrice($item) {
        return $this->prices[$item] ?? null;
    }

    public function updatePrices(array $pricingRules) {
        $this->prices = [];

        foreach ($pricingRules as $rule) {
            $this->prices[$rule['item']] = $rule['price'];
        }
    }

}