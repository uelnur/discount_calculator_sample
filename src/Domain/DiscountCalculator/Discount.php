<?php

namespace App\Domain\DiscountCalculator;

readonly class Discount {
    public function __construct(
        public float $percent,
        public float $maxDiscountedPrice = 0,
    ) {}

    public function calcDiscountedPrice(float $totalPrice): float {
        $discountedPrice = $totalPrice * ($this->percent/100);

        if ( $this->maxDiscountedPrice > 0 && $discountedPrice > $this->maxDiscountedPrice ) {
            return $this->maxDiscountedPrice;
        }

        return $discountedPrice;
    }
}
