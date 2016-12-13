<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\Order;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;
use CommerceGuys\AuthNet\Tests\TestBase;

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

}
