<?php

namespace Core\UseCase;

use Core\Contracts\DateHelper;
use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Services\AdminDailySalesReportMailService;
use Core\Contracts\UseCase;
use Core\Entity\Dto\AdminDailySalesReport;
use Core\Entity\Order;
use Core\Exceptions\AdminEmailIsARequiredInputError;

class SendAdminDailySalesReportUseCase implements UseCase
{
    public function __construct(
        private OrderRepository $orderRepo,
        private AdminDailySalesReportMailService $mailService,
        private DateHelper $date,
    ) {}

    public function execute(mixed $input): mixed
    {
        if (!isset($input['admin_email']))
            throw new AdminEmailIsARequiredInputError();

        $allOrdersOfTheDay = $this->orderRepo->findByFilters([
            'order_date_between' => [
                $this->date->todayAtTheStart(),
                $this->date->todayAtTheEnd()
            ]
        ]);

        $totalSold = array_reduce(
            $allOrdersOfTheDay,
            fn ($carry, Order $order) => $carry + $order->getPriceInCents(),
            0
        );

        $result = $this->mailService
            ->sendMail(
                new AdminDailySalesReport(
                    $totalSold,
                    $input['admin_email'],
                )
            );

        return $result->toArray();
    }
}
