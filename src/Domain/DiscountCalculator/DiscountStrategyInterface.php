<?php

namespace App\Domain\DiscountCalculator;

interface DiscountStrategyInterface {
    public function buildDiscount(DiscountRequest $request): ?Discount;
}
