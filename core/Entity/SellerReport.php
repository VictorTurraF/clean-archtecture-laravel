<?php

namespace Core\Entity;

use Core\Entity\Dto\SellerReportProps;

class SellerReport {
    private SellerReportProps $props;
    private string|null $id;

    public function __construct(array $props, string $id = null)
    {
        $this->props = new SellerReportProps(
            $props['date'] ?? "",
            $props['order_amount'] ?? 0,
            $props['commission_amount_in_cents'] ?? 0
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
