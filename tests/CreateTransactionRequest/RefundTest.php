<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class RefundTest extends CreateTransactionRequestTestBase {

  /**
   * Not tested, because the transaction needs to be settled.
   *
   * Here for documentation purposes.
   */
  public function testRefundTransaction()
  {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();


    $request = $this->xmlRequestFactory->createTransactionRequest();
    $request->setTransactionRequest(new TransactionRequest([
      'transactionType' => TransactionRequest::REFUND,
      'amount' => 5.00,
      'refTransId' => $response->transactionResponse->transId
    ]));
    $transactionRequest->addPayment(new CreditCard([
      'cardNumber' => '1111',
      'expirationDate' => '1230',
    ]));

//        $response = $request->execute();
//        $this->assertTrue(isset($response->transactionResponse));
//        $this->assertEquals('I00001', $response->getMessages()[0]->code);
//        $this->assertEquals('Successful.', $response->getMessages()[0]->text);
//        $this->assertEquals('Ok', $response->getResultCode());
  }
}

