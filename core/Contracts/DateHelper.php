<?php

namespace Core\Contracts;

interface DateHelper {

    public function isEndOfTheDay(): bool;

    public function todayAtTheStart(): string;

    public function todayAtTheEnd(): string;

}
