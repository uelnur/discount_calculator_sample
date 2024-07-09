<?php

namespace App\Domain\Utils;

class DateUtils {
    public static function decrementMonth(\DateTimeImmutable $date): \DateTimeImmutable {
        return (clone $date)
            ->modify('first day of this month')
            ->modify('-1 month')
            ->modify('last day of this month')
        ;
    }
}
