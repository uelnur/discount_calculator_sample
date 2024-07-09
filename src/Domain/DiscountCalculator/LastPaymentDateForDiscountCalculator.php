<?php

namespace App\Domain\DiscountCalculator;

class LastPaymentDateForDiscountCalculator {
    /** Получить конечную дату оплаты, когда можно получить скидку, по дате старта путешествия */
    public function calculateByTripStartDate(\DateTimeImmutable $tripStartDate): \DateTimeImmutable {
        $monthAndDay = $tripStartDate->format('m-d');
        $year        = (int)$tripStartDate->format('Y');

        return match (true) {
            $monthAndDay >= '04-01' && $monthAndDay <= '09-30' => $tripStartDate->setDate($year, 1, 31),
            $monthAndDay >= '10-01'                            => $tripStartDate->setDate($year, 5, 31),
            $monthAndDay <= '01-14'                            => $tripStartDate->setDate($year - 1, 5, 31),
            default                                            => $tripStartDate->setDate($year - 1, 10, 31),
        };
    }
}
