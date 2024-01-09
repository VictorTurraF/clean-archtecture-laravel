<?php

namespace Core\Contracts\Services;

use Core\Entity\Dto\AdminDailySalesReport;

interface AdminDailySalesReportMailService {

    public function sendMail(AdminDailySalesReport $report): AdminDailySalesReport;

}
