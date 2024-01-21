<?php

namespace App\External\Repository;

use Core\Contracts\Repository\SellerRepository;
use Core\Entity\Seller as CoreSeller;
use App\Models\Seller as SellerModel;

class EloquentSellerRepository implements SellerRepository
{
    public function create(CoreSeller $seller): CoreSeller
    {
        $sellerModel = SellerModel::create([
            'name' => $seller->props()->name,
            'email' => $seller->props()->email,
        ]);

        return $this->mapSellerModelToCoreEntity($sellerModel);
    }

    public function existsByEmail(string $sellerEmail): bool
    {
        return SellerModel::where('email', $sellerEmail)->exists();
    }

    public function existsById(string $sellerId): bool
    {
        return SellerModel::where('id', $sellerId)->exists();
    }

    public function all(): array
    {
        $sellerModels = SellerModel::all();

        $sellers = [];
        foreach ($sellerModels as $sellerModel) {
            $sellers[] = $this->mapSellerModelToCoreEntity($sellerModel);
        }

        return $sellers;
    }

    private function mapSellerModelToCoreEntity(SellerModel $sellerModel): CoreSeller
    {
        return new CoreSeller(
            [
                "name" => $sellerModel->name,
                "email" => $sellerModel->email
            ],
            $sellerModel->id,
        );
    }
}
