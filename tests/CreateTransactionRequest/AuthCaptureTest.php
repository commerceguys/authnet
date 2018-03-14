<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\Tax;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class AuthCaptureTest extends CreateTransactionRequestTestBase
{
  public function testAuthCaptureTransaction()
  {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);

     // Add tax information to the transaction request.
    $tax_data = new Tax([
      'amount' => 5.43,
      'name' => 'Tax',
      'description' => 'Testing tax',
    ]);
    $transactionRequest->addData('tax', $tax_data->toArray());
      
    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());

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
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());
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
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());

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
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());
  }
}
