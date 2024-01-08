<?php

namespace Core\Utils;

use Core\Contracts\DateHelper;

class Date implements DateHelper {
    public function isEndOfTheDay(): bool
    {
        $currentTime = date("H:i");
        return $currentTime >= "19:00" && $currentTime <= "23:00";
    }

    public function todayAtTheStart(): string
    {
        $currentDate = date("Y-m-d");
        return "{$currentDate}T00:00";
    }

    public function todayAtTheEnd(): string
    {
        $currentDate = date("Y-m-d");
        return "{$currentDate}T23:59";
    }
}
