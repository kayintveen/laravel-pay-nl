<?php

namespace Kayintveen\LaravelPayNL\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Paynl\Transaction\Start startTransaction(array $options)
 * @method static \Paynl\Transaction\Info getTransaction(string $transactionId)
 * @method static \Paynl\Transaction\Status getTransactionStatus(string $transactionId)
 * @method static \Paynl\Transaction\Approve approveTransaction(string $transactionId)
 * @method static \Paynl\Transaction\Decline declineTransaction(string $transactionId)
 * @method static \Paynl\Transaction\Void voidTransaction(string $transactionId)
 * @method static \Paynl\Transaction\Capture captureTransaction(string $transactionId, array|null $options = null)
 * @method static array getPaymentMethods()
 * @method static \Paynl\Refund\Add refundTransaction(string $transactionId, int|null $amount = null, string|null $description = null, array|null $options = null)
 * @method static \Paynl\Refund\Info getRefund(string $refundId)
 * @method static \Paynl\Transaction\GetQr getQrCode(string $transactionId, array $options = [])
 * @method static string getServiceId()
 * @method static bool isTestMode()
 *
 * @see \Kayintveen\LaravelPayNL\PayNLClient
 */
class PayNL extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'paynl';
    }
}
