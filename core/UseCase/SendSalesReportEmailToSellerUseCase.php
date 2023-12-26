<?php

namespace Core\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\UseCase;
use Core\Entity\Seller;
use Core\Exceptions\InvalidTimeToSendReport;
use DateTime;

class SendSalesReportEmailToSellerUseCase implements UseCase {
    public function __construct(
        private $mailService,
        private SellerRepository $sellerRepo,
        private OrderRepository $orderRepo,
    ) {}

    public function execute($input): mixed
    {
        // Check current time
        if (!$this->isEndOfTheDay())
            // It can be only send mail between 19h and 23h59
            throw new InvalidTimeToSendReport();


        // Retrive all seller via repository
        $allSellers = $this->sellerRepo->all();

        // For each seller
        foreach ($allSellers as $seller) {

            $sellerOrders = $this->orderRepo->findByFilters([
                'seller_id' => $seller->getId(),
                'order_date_between' => ''
            ]);

            // Sum

            // Send orders report to the seller
        }


    }

    private function isEndOfTheDay() {
        $currentTime = new date("H:i");
        return $currentTime >= "19:00" && $currentTime <= "23:00";
    }
}
