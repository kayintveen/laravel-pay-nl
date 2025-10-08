<?php

namespace Kayintveen\LaravelPayNL;

use Kayintveen\LaravelPayNL\Exceptions\PayNLException;
use Paynl\Config;
use Paynl\Error\Api;
use Paynl\Error\Error;
use Paynl\Error\Required\ApiToken;
use Paynl\Error\Required\ServiceId;
use Paynl\Paymentmethods;
use Paynl\Result\Transaction\Status;
use Paynl\Transaction;

class PayNL
{
    private bool $testMode;

    public function __construct()
    {
        Config::setTokenCode(config('paynl.token_code'));
        Config::setApiToken(config('paynl.api_token'));
        Config::setServiceId(config('paynl.service_id'));

        $this->testMode = config('paynl.test_mode');
    }

    public function setServiceId(string $serviceId): void
    {
        Config::setServiceId($serviceId);
    }

    public function getPaymentMethods(): array
    {
        return Paymentmethods::getList();
    }

    /**
     * @throws PayNLException
     */
    public function minimumTransaction(float $amount, string $returnUrl): array|string
    {
        $options = [
            'amount' => $amount,
            'returnUrl' => $returnUrl,
        ];

        return $this->startTransaction($options);
    }

    /**
     * @throws PayNLException
     */
    public function transaction(float $amount, string $returnUrl, array $options): array|string
    {
        $options['amount'] = $amount;
        $options['returnUrl'] = $returnUrl;

        return $this->startTransaction($options);
    }

    /**
     * @throws PayNLException
     */
    public function startTransaction(array $options): array|string
    {
        try {
            $options['testmode'] = $this->testMode;
            $transaction = Transaction::start($options);

            return [
                'transactionId' => $transaction->getTransactionId(),
                'redirectUrl' => $transaction->getRedirectUrl(),
            ];
        } catch (Error $e) {
            throw new PayNLException('Failed to start transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws ServiceId
     * @throws Api
     * @throws Error
     * @throws ApiToken
     */
    public function getStatus($transactionId): Status
    {
        return Transaction::status($transactionId);
    }
}
