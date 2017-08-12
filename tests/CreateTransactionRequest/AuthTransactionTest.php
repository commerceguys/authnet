<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class AuthTransactionTest extends CreateTransactionRequestTestBase
{
  public function testAuthTransaction()
  {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);

    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
    $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');

    sleep(1);

    // Use a new number, otherwise a duplicate transaction is flagged.
    $transactionRequest = $this->createChargableTransactionRequest(
      TransactionRequest::AUTH_ONLY,
      '4007000000027'
    );

    // JSON
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
      $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
  }
}
