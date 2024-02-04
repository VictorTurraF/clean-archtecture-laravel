<?php

namespace Tests\Feature;

use App\External\Service\SymfonyMaillerSalesReportMailService;
use App\Mail\DailySellerSalesReportMail;
use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Seller;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DailySellerSalesReportMailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testSalesReportMailable(): void
    {
        $seller = new Seller(['name' => 'Jhon', 'email' => 'jhon@example.com']);

        $salesReport = new SellerSalesReport(
            seller: $seller,
            date: '2024-02-10T00:00',
            totalSold: 10000,
            totalCommission: 800
        );

        $seller = $salesReport->seller->toArray();

        $mailable = new DailySellerSalesReportMail(
            sellerName: $seller['name'],
            sellerEmail: $seller['email'],
            reportDate: (string) $salesReport->date,
            totalSold: (string) $salesReport->totalSold,
            totalCommission: (string) $salesReport->totalCommission
        );

        $mailable->assertFrom('laravel.cleanarch@example.com');
        $mailable->to('jhon@example.com');
        $mailable->assertHasSubject('Daily Seller Sales Report Mail');

        $mailable->assertSeeInHtml('Jhon');
        $mailable->assertSeeInHtml('10/02/2024');
        $mailable->assertSeeInHtml('R$ 100,00');
        $mailable->assertSeeInHtml('R$ 8,00');
    }

    public function testSendSalesReportMail()
    {
        Mail::fake();

        $seller = new Seller([
            'name' => 'Jhon',
            'email' => 'seller@example.com'
        ]);

        $salesReport = new SellerSalesReport(
            seller: $seller,
            date: '2024-02-10T00:00',
            totalSold: 10000,
            totalCommission: 800
        );

        $service = new SymfonyMaillerSalesReportMailService();
        $service->sendMail($salesReport);

        Mail::assertQueued(DailySellerSalesReportMail::class, function ($mail) {
            // Assert that the mail was sent to the correct seller
            return $mail->sellerEmail === 'seller@example.com' &&
                $mail->hasSubject('Daily Seller Sales Report Mail') &&
                $mail->hasFrom('laravel.cleanarch@example.com', 'Laravel Clean Arch Project');
        });

        Mail::assertQueuedCount(1);
    }
}
