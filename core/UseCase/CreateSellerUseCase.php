<?php

namespace Core\UseCase;

use Core\Contracts\SellerRepository;
use Core\Contracts\UseCase;
use Core\Entity\Seller;
use Core\Exceptions\SellerAlreadyExistsError;

class CreateSellerUseCase implements UseCase
{
    public function __construct(
        private SellerRepository $sellerRepo
    ) {}

    public function execute($input): mixed
    {
        if ($this->sellerRepo->existsByEmail($input['email']))
            throw new SellerAlreadyExistsError();


        $createdSeller = $this->sellerRepo->save(
            new Seller([
                "name" => $input['name'],
                "email" => $input['email'],
            ])
        );

        return $createdSeller->toArray();
    }
}
