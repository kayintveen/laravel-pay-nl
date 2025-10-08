<?php

namespace Kayintveen\LaravelPayNL;

use Kayintveen\LaravelPayNL\Exceptions\PayNLException;
use Paynl\Config;
use Paynl\Paymentmethods;
use Paynl\Refund;
use Paynl\Transaction;

class PayNLClient
{
    protected bool $initialized = false;

    public function __construct(
        protected string $tokenCode,
        protected string $apiToken,
        protected string $serviceId,
        protected bool $testMode = false
    ) {
        $this->initialize();
    }

    protected function initialize(): void
    {
        if ($this->initialized) {
            return;
        }

        Config::setTokenCode($this->tokenCode);
        Config::setApiToken($this->apiToken);
        Config::setServiceId($this->serviceId);

        if ($this->testMode) {
            Config::setTestMode(true);
        }

        $this->initialized = true;
    }

    /**
     * Start a new transaction
     *
     * @param  array<string, mixed>  $options
     */
    public function startTransaction(array $options): Transaction\Start
    {
        try {
            return Transaction::start($options);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to start transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Get transaction info
     */
    public function getTransaction(string $transactionId): Transaction\Info
    {
        try {
            return Transaction::get($transactionId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to get transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Get transaction status
     */
    public function getTransactionStatus(string $transactionId): Transaction\Status
    {
        try {
            return Transaction::status($transactionId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to get transaction status: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Approve a transaction
     */
    public function approveTransaction(string $transactionId): Transaction\Approve
    {
        try {
            return Transaction::approve($transactionId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to approve transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Decline a transaction
     */
    public function declineTransaction(string $transactionId): Transaction\Decline
    {
        try {
            return Transaction::decline($transactionId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to decline transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Void a transaction
     */
    public function voidTransaction(string $transactionId): Transaction\Void
    {
        try {
            return Transaction::void($transactionId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to void transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Capture a transaction
     *
     * @param  array<string, mixed>|null  $options
     */
    public function captureTransaction(string $transactionId, ?array $options = null): Transaction\Capture
    {
        try {
            return Transaction::capture($transactionId, $options);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to capture transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Get available payment methods
     *
     * @return array<int, mixed>
     */
    public function getPaymentMethods(): array
    {
        try {
            $result = Paymentmethods::getList();

            return $result->getList();
        } catch (\Exception $e) {
            throw new PayNLException('Failed to get payment methods: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Refund a transaction
     *
     * @param  array<string, mixed>|null  $options
     */
    public function refundTransaction(string $transactionId, ?int $amount = null, ?string $description = null, ?array $options = null): Refund\Add
    {
        try {
            $refundOptions = $options ?? [];

            if ($amount !== null) {
                $refundOptions['amount'] = $amount;
            }

            if ($description !== null) {
                $refundOptions['description'] = $description;
            }

            return Refund::transaction($transactionId, $refundOptions);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to refund transaction: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Get refund info
     */
    public function getRefund(string $refundId): Refund\Info
    {
        try {
            return Refund::get($refundId);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to get refund: '.$e->getMessage(), 0, $e);
        }
    }

    /**
     * Get QR code for transaction
     *
     * @param  array<string, mixed>  $options
     */
    public function getQrCode(string $transactionId, array $options = []): Transaction\GetQr
    {
        try {
            return Transaction::getQr($transactionId, $options);
        } catch (\Exception $e) {
            throw new PayNLException('Failed to get QR code: '.$e->getMessage(), 0, $e);
        }
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function isTestMode(): bool
    {
        return $this->testMode;
    }
}
