<?php

namespace App\Tests\Domain\DiscountCalculator;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\DiscountStrategyInterface;

readonly class TestDiscountStrategy implements DiscountStrategyInterface {
    public function __construct(
        private float $percent,
        private float $maxDiscountedPrice = 0,
    ) {}

    public function buildDiscount(DiscountRequest $request): ?Discount {
        return new Discount($this->percent, $this->maxDiscountedPrice);
    }
}
