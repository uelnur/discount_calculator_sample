<?php

namespace App\Domain\DiscountCalculator;

readonly class DiscountRequest {
    public function __construct(
        public float $basePrice,
        public \DateTimeImmutable $birthday,
        public \DateTimeImmutable $tripStartDate,
        public ?\DateTimeImmutable $paymentDate = null,
    ) {

    }
}