<?php

namespace Core\Contracts\Services;

use Core\Entity\Dto\SellerSalesReport;

interface SalesReportMailService {

    public function sendMail(SellerSalesReport $report): SellerSalesReport;

}
