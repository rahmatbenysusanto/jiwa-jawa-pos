<?php

namespace App\Services;

use Xendit\BalanceAndTransaction\Balance;
use Xendit\BalanceAndTransaction\BalanceApi;
use Xendit\Configuration;
use Xendit\XenditSdkException;

class XenditService
{
    public function init(): void
    {
        Configuration::setXenditKey("YOUR_API_KEY_HERE");
    }

    /**
     * @throws XenditSdkException
     */
    public function getBalance(): void
    {
        $apiInstance = new BalanceApi();

        $balance = $apiInstance->getBalance('CASH');
    }
}