<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\Tests\TestBase;
use CommerceGuys\AuthNet\DataTypes\Order;
use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\BankAccount;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

abstract class CreateTransactionRequestTestBase extends TestBase {

  /**
   * @param $type
   * @param $cardNum
   * @param $expDate
   * @param $cvv
   * @return \CommerceGuys\AuthNet\DataTypes\TransactionRequest
   */
  protected function createChargableTransactionRequest($type, $cardNum = '4111111111111111', $expDate = '1230', $cvv = '123')
  {
    $transactionRequest = new TransactionRequest([
      'transactionType' => $type,
      'amount' => 5.00,
    ]);
    $transactionRequest->addPayment(new CreditCard([
      'cardNumber' => $cardNum,
      'expirationDate' => $expDate,
      'cardCode' => $cvv,
    ]));
    $transactionRequest->addOrder(new Order([
      'invoiceNumber' => 'INV-' . rand(10, 100),
    ]));

    return $transactionRequest;
  }

  /**
   * @param $type
   * @param $accountNumber
   * @param $routeingNumber
   * @return \CommerceGuys\AuthNet\DataTypes\TransactionRequest
   */
  protected function createChargableBankAccountTransactionRequest($type, $accountNumber = '0987654321', $routingNumber = '325070760')
  {
    $transactionRequest = new TransactionRequest([
      'transactionType' => $type,
      'amount' => 5.00,
    ]);
    $transactionRequest->addPayment(new BankAccount([
        'accountType' => 'checking',
        'routingNumber' => $routingNumber,
        'accountNumber' => $accountNumber,
        'nameOnAccount' => 'Dwayne Johnson',
        'bankName' => 'Bank of America'
    ]));
    $transactionRequest->addOrder(new Order([
      'invoiceNumber' => 'INV-' . rand(10, 100),
    ]));

    return $transactionRequest;
  }
}
