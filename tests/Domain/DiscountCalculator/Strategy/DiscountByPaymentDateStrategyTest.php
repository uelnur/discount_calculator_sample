<?php

namespace App\Tests\Domain\DiscountCalculator\Strategy;

use App\Domain\DiscountCalculator\Discount;
use App\Domain\DiscountCalculator\DiscountRequest;
use App\Domain\DiscountCalculator\LastPaymentDateForDiscountCalculator;
use App\Domain\DiscountCalculator\Strategy\DiscountByPaymentDateStrategy;
use PHPUnit\Framework\TestCase;

class DiscountByPaymentDateStrategyTest extends TestCase {
    public function testPaymentDateStrategy(): void {
        $this->testNull('2027-05-01', null);

        $this->test(7, '2027-05-01', '2026-11-30');
        $this->test(5, '2027-05-01', '2026-12-31');
        $this->test(3, '2027-05-01', '2027-01-31');
        $this->testNull('2027-05-01', '2027-02-01');

        $this->test(7, '2027-01-15', '2026-08-31');
        $this->test(5, '2027-01-15', '2026-09-30');
        $this->test(3, '2027-01-15', '2026-10-31');
        $this->testNull('2027-01-15', '2026-11-01');
    }

    private function test(float $expectedPercent, string $tripStartDate, string $paymentDate): void {
        $calculator = new LastPaymentDateForDiscountCalculator();
        $strategy = new DiscountByPaymentDateStrategy($calculator);

        $request = new DiscountRequest(0, new \DateTimeImmutable(), new \DateTimeImmutable($tripStartDate), new \DateTimeImmutable($paymentDate));
        $discount = $strategy->buildDiscount($request);
        $this->assertInstanceOf(Discount::class, $discount);
        $this->assertEquals($expectedPercent, $discount->percent);
        $this->assertEquals(1500, $discount->maxDiscountedPrice);
    }

    private function testNull(string $tripStartDate, ?string $paymentDate): void {
        $calculator = new LastPaymentDateForDiscountCalculator();
        $strategy = new DiscountByPaymentDateStrategy($calculator);

        $request = new DiscountRequest(0, new \DateTimeImmutable(), new \DateTimeImmutable($tripStartDate), $paymentDate ? new \DateTimeImmutable($paymentDate) : null);
        $discount = $strategy->buildDiscount($request);
        $this->assertNull($discount);
    }
}
