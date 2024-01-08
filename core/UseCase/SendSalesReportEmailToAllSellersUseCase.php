<?php

namespace Core\UseCase;

use Core\Contracts\DateHelper;
use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\Services\SalesReportMailService;
use Core\Contracts\UseCase;
use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Order;
use Core\Exceptions\InvalidTimeToSendReport;

class SendSalesReportEmailToAllSellersUseCase implements UseCase
{
    public function __construct(
        private SalesReportMailService $mailService,
        private SellerRepository $sellerRepo,
        private OrderRepository $orderRepo,
        private DateHelper $date,
    ) {}

    public function execute($input = null): mixed
    {
        $result = [];

        if (!$this->date->isEndOfTheDay())
            throw new InvalidTimeToSendReport();

        $allSellers = $this->sellerRepo->all();

        foreach ($allSellers as $seller)
        {
            $sellerOrders = $this->orderRepo->findByFilters([
                'seller_id' => $seller->getId(),
                'order_date_between' => [
                    $this->date->todayAtTheStart(),
                    $this->date->todayAtTheEnd()
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

            $sentReport = $this->mailService->sendMail(
                new SellerSalesReport(
                    (int) round($totalSold),
                    (int) round($totalCommission)
                )
            );

            array_push($result, $sentReport);
        }

        return $result;
    }
}
