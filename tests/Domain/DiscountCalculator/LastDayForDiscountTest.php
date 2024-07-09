<?php

namespace App\Tests\Domain\DiscountCalculator;

use App\Domain\DiscountCalculator\LastPaymentDateForDiscountCalculator;
use PHPUnit\Framework\TestCase;

class LastDayForDiscountTest extends TestCase {
    public function testLastDateForDiscount(): void {
        $this->lastDateTest('2024-01-31', '2024-04-01');
        $this->lastDateTest('2024-01-31', '2024-09-30');

        $this->lastDateTest('2024-05-31', '2024-10-01');
        $this->lastDateTest('2024-05-31', '2025-01-14');

        $this->lastDateTest('2023-10-31', '2024-01-15');
        $this->lastDateTest('2023-10-31', '2024-03-31');
    }

    private function lastDateTest(string $expected, string $tripDate): void {
        $calculator = new LastPaymentDateForDiscountCalculator();
        $this->assertEquals($expected, $calculator->calculateByTripStartDate(new \DateTimeImmutable($tripDate))->format('Y-m-d'));
    }
}
