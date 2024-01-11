<?php

namespace Core\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\Services\SalesReportMailService;
use Core\Contracts\UseCase;
use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Order;
use Core\Exceptions\SellerNotFoundError;

class SendSalesReportToSellerUseCase implements UseCase {
    public function __construct(
        private SellerRepository $sellerRepo,
        private OrderRepository $orderRepo,
        private SalesReportMailService $mailService,
    ) {}

    public function execute($input): mixed
    {
        if (!$this->sellerRepo->existsById($input['seller_id']))
            throw new SellerNotFoundError();

        $sellerOrders = $this->orderRepo->findByFilters([
            'seller_id' => $input['seller_id'],
            'order_date_between' => [
                $input['date']."T00:00:00",
                $input['date']."T23:59:59"
            ]
        ]);

        $totalSold = array_reduce(
            $sellerOrders,
            fn ($carry, Order $order) => $carry + $order->getPriceInCents(),
            0
        );

        $totalCommission = array_reduce(
            $sellerOrders,
            fn ($carry, Order $order) => $carry + ($order->getPriceInCents() * 0.08),
            0
        );

        $result = $this->mailService->sendMail(
            new SellerSalesReport(
                (int) round($totalSold),
                (int) round($totalCommission)
            )
        );

        return $result->toArray();
    }
}
