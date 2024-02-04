<?php

namespace App\External\Service;

use App\Mail\DailySellerSalesReportMail;
use Core\Contracts\Services\SalesReportMailService;
use Core\Entity\Dto\SellerSalesReport;
use Illuminate\Support\Facades\Mail;

class SymfonyMaillerSalesReportMailService implements SalesReportMailService
{
    public function sendMail(SellerSalesReport $report): SellerSalesReport
    {
        $seller = $report->seller->toArray();

        Mail::to($seller['email'])
            ->queue(new DailySellerSalesReportMail(
                sellerName: $seller['name'],
                sellerEmail: $seller['email'],
                reportDate: $report->date->getDateTime()->format('d/m/Y'),
                totalSold: (string) $report->totalSold,
                totalCommission: (string) $report->totalCommission
            ));

        return $report;
    }
}
