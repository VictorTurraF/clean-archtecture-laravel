# Comandos uteis para testar no Laravel Tinker

Teste de envio do relatório de vendas do vendedor.

```php
$seller = new Core\Entity\Seller([
    'name' => 'Victor',
    'email' => 'viflorencio23@gmail.com'
]);

$report = new Core\Entity\Dto\SellerSalesReport(
    $seller,
    "2024-02-04T00:00",
    100000,
    8000
);

$service = new App\External\Service\SymfonyMaillerSalesReportMailService();
$service->sendMail($report);
```
