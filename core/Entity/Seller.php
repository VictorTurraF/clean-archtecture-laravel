<?php

namespace Core\Entity;

use Core\Entity\Dto\SellerProps;

class Seller {
    private SellerProps $props;
    private string|null $id;

    public function __construct(array $props, string $id = null)
    {
        $this->props = new SellerProps(
            $props['name'] ?? "",
            $props['email'] ?? ""
        );
        $this->id = $id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->props->name,
            'email' => $this->props->email
        ];
    }
}
