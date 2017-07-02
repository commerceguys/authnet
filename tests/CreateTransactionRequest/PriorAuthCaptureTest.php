<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class PriorAuthCaptureTest extends CreateTransactionRequestTestBase {
  public function testPriorAuthCaptureTransaction()
  {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);

    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();

    // This randomly fails. Maybe because we try to capture too soon?
    // Try sleeping for a little bit.
    sleep(3);

    // XML
    $request = $this->xmlRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest(new TransactionRequest([
        'transactionType' => TransactionRequest::PRIOR_AUTH_CAPTURE,
        'refTransId' => $response->transactionResponse->transId,
        'amount' => 5.00,
      ]));
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());

    // Use a new number, otherwise a duplicate transaction is flagged.
    $transactionRequest = $this->createChargableTransactionRequest(
      TransactionRequest::AUTH_ONLY,
      '4222222222222'
    );

    // JSON
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();

    // This randomly fails. Maybe because we try to capture too soon?
    // Try sleeping for a little bit.
    sleep(3);

    // JSON
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest(new TransactionRequest([
        'transactionType' => TransactionRequest::PRIOR_AUTH_CAPTURE,
        'refTransId' => $response->transactionResponse->transId,
        'amount' => 5.00,
      ]));
    $response = $request->execute();
    $this->assertTrue(isset($response->transactionResponse));
    $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
    $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
    $this->assertEquals('Ok', $response->getResultCode());
  }

  public function testDuplicateCaptureAttempt() {
    $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_ONLY);
    // JSON
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest($transactionRequest);
    $response = $request->execute();

    // This randomly fails. Maybe because we try to capture too soon?
    // Try sleeping for a little bit.
    sleep(3);

    // JSON
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest(new TransactionRequest([
        'transactionType' => TransactionRequest::PRIOR_AUTH_CAPTURE,
        'refTransId' => $response->transactionResponse->transId,
        'amount' => 5.00,
      ]));
    $response = $request->execute();
    $this->assertEquals('Ok', $response->getResultCode());

    sleep(3);
    $request = $this->jsonRequestFactory
      ->createTransactionRequest()
      ->setTransactionRequest(new TransactionRequest([
        'transactionType' => TransactionRequest::PRIOR_AUTH_CAPTURE,
        'refTransId' => $response->transactionResponse->transId,
        'amount' => 5.00,
      ]));
    $response = $request->execute();
    $this->assertEmpty($response->getErrors());
    $this->assertEquals(311, $response->transactionResponse->messages[0]->code);
    $this->assertEquals('This transaction has already been captured.', $response->transactionResponse->messages[0]->description);
    $this->assertEquals('Ok', $response->getResultCode());

  }
}
