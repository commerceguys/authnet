<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class AuthCaptureTest extends CreateTransactionRequestTestBase
{
  public function testAuthCaptureTransaction()
  {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);

    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
      $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');

    // Use a new number, otherwise a duplicate transaction is flagged.
    $transactionRequest = $this->createChargableTransactionRequest(
      TransactionRequest::AUTH_CAPTURE,
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

  public function testBankAccountAuthCaptureTransaction()
  {
    $transactionRequest = $this->createChargableBankAccountTransactionRequest(TransactionRequest::AUTH_CAPTURE);

    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();

    $this->assertTrue(isset($response->transactionResponse));
      $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');

    // Use a new number, otherwise a duplicate transaction is flagged.
    $transactionRequest = $this->createChargableBankAccountTransactionRequest(
      TransactionRequest::AUTH_CAPTURE,
      '0123456789'
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
