<?php

namespace App\Enums;

enum CalendarStatusEnum: int
{
    case TODO = 1;
    case DOING = 2;
    CASE IN_REVISION = 3;
    CASE APPROVED = 4;
    CASE REPROVED = 5;

    public function getName(): string
    {
        return match($this) {
            self::TODO => __('To do'),
            self::DOING => __('Doing'),
            self::IN_REVISION => __('In revision'),
            self::APPROVED => __('Approved'),
            self::REPROVED => __('Reproved'),
        };
    }
}
