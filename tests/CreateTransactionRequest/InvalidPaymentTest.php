<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class InvalidPaymentTest extends CreateTransactionRequestTestBase
{
  public function testInvalidPayment()
  {
    // Expired
    $transactionRequest = $this->createChargableTransactionRequest(
      TransactionRequest::AUTH_ONLY,
      '4995949165814994',
      '1210'
    );
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
    $this->assertEquals('E00027', $response->getMessages()[0]->getCode());
    $this->assertEquals('The transaction was unsuccessful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Error', $response->getResultCode());
    $this->assertEquals('The credit card has expired.', $response->getErrors()[0]->getText());

    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertEquals('E00027', $response->getMessages()[0]->getCode());
    $this->assertEquals('The transaction was unsuccessful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Error', $response->getResultCode());
    $this->assertEquals('The credit card has expired.', $response->getErrors()[0]->getText());


    // Invalid number
    $transactionRequest = $this->createChargableTransactionRequest(
      TransactionRequest::AUTH_ONLY,
      '4995949165814995'
    );
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));

    $this->assertEquals('E00027', $response->getMessages()[0]->getCode());
    $this->assertEquals('The transaction was unsuccessful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Error', $response->getResultCode());
    $this->assertEquals('The credit card number is invalid.', $response->getErrors()[0]->getText());
  }
}
