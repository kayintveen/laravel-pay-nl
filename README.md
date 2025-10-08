# Laravel Pay.nl Wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kayintveen/laravel-paynl.svg?style=flat-square)](https://packagist.org/packages/kayintveen/laravel-paynl)
[![Total Downloads](https://img.shields.io/packagist/dt/kayintveen/laravel-paynl.svg?style=flat-square)](https://packagist.org/packages/kayintveen/laravel-paynl)
[![License](https://img.shields.io/packagist/l/kayintveen/laravel-paynl.svg?style=flat-square)](https://packagist.org/packages/kayintveen/laravel-paynl)

A clean, modern, and professional Laravel wrapper for the [Pay.nl](https://www.pay.nl) payment gateway. This package provides a fluent interface for integrating Pay.nl payments into your Laravel 11 and Laravel 12 applications.

## Features

- ✅ **Laravel 11 & 12 Compatible** - Full support for the latest Laravel versions
- 🚀 **Easy Installation** - Auto-discovery for seamless integration
- 🎯 **Fluent API** - Clean and intuitive method chaining
- 🔒 **Type-Safe** - Full PHP 8.1+ type hints and return types
- 🧪 **Test Mode Support** - Easy testing without real transactions
- 📦 **Comprehensive Coverage** - Transactions, refunds, payment methods, and QR codes
- 🎨 **Laravel Pint Ready** - Code formatted to Laravel standards
- 🛡️ **Exception Handling** - Clear error messages for debugging

## Requirements

- PHP 8.1 or higher
- Laravel 11.0 or 12.0
- Pay.nl account with API credentials

## Installation

Install the package via Composer:

```bash
composer require kayintveen/laravel-paynl
```

The service provider and facade are automatically registered via Laravel's package auto-discovery.

### Configuration

Publish the configuration file (optional):

```bash
php artisan vendor:publish --tag=paynl-config
```

Add your Pay.nl credentials to your `.env` file:

```env
PAYNL_TOKEN_CODE=your-token-code
PAYNL_API_TOKEN=your-api-token
PAYNL_SERVICE_ID=your-service-id
PAYNL_TESTMODE=false
```

You can find your API credentials in your [Pay.nl dashboard](https://admin.pay.nl) under Settings > API tokens.

## Usage

### Starting a Transaction

```php
use Kayintveen\LaravelPayNL\Facades\PayNL;

$transaction = PayNL::startTransaction([
    'amount' => 10.00,
    'returnUrl' => route('payment.return'),
    'exchangeUrl' => route('payment.webhook'),
    'description' => 'Order #12345',
    'enduser' => [
        'emailAddress' => 'customer@example.com',
        'initials' => 'J',
        'lastName' => 'Doe',
    ],
]);

// Redirect to payment URL
return redirect($transaction->getRedirectUrl());
```

### Getting Transaction Info

```php
$transaction = PayNL::getTransaction('1234567890X12ab34');

echo $transaction->isPaid() ? 'Paid' : 'Not paid';
```

### Checking Transaction Status

```php
$status = PayNL::getTransactionStatus('1234567890X12ab34');

if ($status->isPaid()) {
    // Payment successful
}
```

### Refunding a Transaction

```php
// Full refund
$refund = PayNL::refundTransaction('1234567890X12ab34');

// Partial refund (amount in cents)
$refund = PayNL::refundTransaction(
    transactionId: '1234567890X12ab34',
    amount: 500, // €5.00
    description: 'Partial refund for order #12345'
);
```

### Getting Available Payment Methods

```php
$paymentMethods = PayNL::getPaymentMethods();

foreach ($paymentMethods as $method) {
    echo $method['name'];
}
```

### Managing Transactions

```php
// Approve a transaction
PayNL::approveTransaction('1234567890X12ab34');

// Decline a transaction
PayNL::declineTransaction('1234567890X12ab34');

// Void a transaction
PayNL::voidTransaction('1234567890X12ab34');

// Capture a transaction
PayNL::captureTransaction('1234567890X12ab34');
```

### Getting QR Code

```php
$qr = PayNL::getQrCode('1234567890X12ab34');

echo $qr->getQrUrl(); // URL to QR code image
```

### Using Dependency Injection

Instead of the facade, you can also inject the `PayNLClient` directly:

```php
use Kayintveen\LaravelPayNL\PayNLClient;

class PaymentController extends Controller
{
    public function __construct(
        protected PayNLClient $payNL
    ) {}

    public function createPayment()
    {
        $transaction = $this->payNL->startTransaction([
            'amount' => 10.00,
            // ...
        ]);

        return redirect($transaction->getRedirectUrl());
    }
}
```

## Available Methods

### Transaction Methods

| Method | Description |
|--------|-------------|
| `startTransaction(array $options)` | Start a new payment transaction |
| `getTransaction(string $transactionId)` | Get transaction details |
| `getTransactionStatus(string $transactionId)` | Get transaction status |
| `approveTransaction(string $transactionId)` | Approve a transaction |
| `declineTransaction(string $transactionId)` | Decline a transaction |
| `voidTransaction(string $transactionId)` | Void a transaction |
| `captureTransaction(string $transactionId, ?array $options)` | Capture a transaction |

### Refund Methods

| Method | Description |
|--------|-------------|
| `refundTransaction(string $transactionId, ?int $amount, ?string $description, ?array $options)` | Refund a transaction |
| `getRefund(string $refundId)` | Get refund details |

### Payment Methods

| Method | Description |
|--------|-------------|
| `getPaymentMethods()` | Get available payment methods |

### QR Code Methods

| Method | Description |
|--------|-------------|
| `getQrCode(string $transactionId, array $options)` | Get QR code for transaction |

### Utility Methods

| Method | Description |
|--------|-------------|
| `getServiceId()` | Get configured service ID |
| `isTestMode()` | Check if test mode is enabled |

## Testing

Enable test mode in your `.env`:

```env
PAYNL_TESTMODE=true
```

In test mode, no real transactions will be processed.

## Exception Handling

The package throws `PayNLException` when operations fail:

```php
use Kayintveen\LaravelPayNL\Exceptions\PayNLException;

try {
    $transaction = PayNL::startTransaction($options);
} catch (PayNLException $e) {
    Log::error('Payment failed: ' . $e->getMessage());

    return back()->with('error', 'Payment could not be processed');
}
```

## Code Quality

This package follows Laravel coding standards and is formatted with [Laravel Pint](https://laravel.com/docs/pint):

```bash
composer require laravel/pint --dev
./vendor/bin/pint
```

## Security

If you discover any security-related issues, please email k.veen@microdesign.nl instead of using the issue tracker.

## Credits

- [Kay in 't Veen](https://github.com/kayintveen)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## About Pay.nl

[Pay.nl](https://www.pay.nl) is a payment service provider that offers various payment methods including iDEAL, credit cards, PayPal, and many more. This package provides a Laravel-friendly wrapper around their PHP SDK.

## Support

- [Documentation](https://github.com/kayintveen/laravel-paynl)
- [Pay.nl Documentation](https://docs.pay.nl)
- [Issue Tracker](https://github.com/kayintveen/laravel-paynl/issues)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for recent changes.
