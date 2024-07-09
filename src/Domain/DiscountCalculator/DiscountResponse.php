<?php

namespace App\Domain\DiscountCalculator;

class DiscountResponse {
    private float $basePrice;
    private float $finalPrice;
    private float $discountedPrice = 0;
    private float $discountPercent = 0;

    /**
     * @var array<Discount> $discounts
     */
    private array $discounts = [];

    public function __construct(float $basePrice,) {
        $this->basePrice = $basePrice;
        $this->finalPrice = $basePrice;
    }

    public function addDiscount(Discount $discount): void {
        $discountedPrice = $discount->calcDiscountedPrice($this->basePrice);
        $this->discountPercent += $discount->percent;
        $this->discountedPrice += $discountedPrice;
        $this->finalPrice -= $discountedPrice;

        $this->discounts[] = $discount;
    }

    /**
     * @return array<Discount>
     */
    public function getDiscounts(): array {
        return $this->discounts;
    }

    public function getFinalPrice(): float {
        return $this->finalPrice;
    }

    public function getDiscountedPrice(): float {
        return $this->discountedPrice;
    }

    public function getDiscountPercent(): float {
        return $this->discountPercent;
    }

    public function getBasePrice(): float {
        return $this->basePrice;
    }
}
