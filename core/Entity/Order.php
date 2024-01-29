<?php

namespace Core\Entity;

use Core\Entity\Dto\OrderProps;

class Order
{
    private $id;
    private OrderProps $props;

    public function __construct(array $props, string $id = null)
    {
        $this->props = new OrderProps(
            $props['seller_id'],
            $props['price_in_cents'],
            $props['payment_approved_at'],
        );

        $this->id = $id;
    }

    public function setId($newId)
    {
        $this->id = $newId;
    }

    public function getPriceInCents()
    {
        return $this->props->priceInCents->getInCents();
    }

    public function props()
    {
        return $this->props;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'seller_id' => $this->props->sellerId,
            'price' => [
                'in_cents' => $this->props->priceInCents->getInCents(),
                'formatted' => (string) $this->props->priceInCents
            ],
            'payment_approved_at' => [
                'iso_date' => $this->props->paymentApprovedAt->getIsoDate(),
                'formatted' => (string) $this->props->paymentApprovedAt
            ]
        ];
    }
}
