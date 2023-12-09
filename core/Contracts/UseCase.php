<?php

namespace Core\Contracts;

interface UseCase {

    public function execute(mixed $input): mixed;

}
