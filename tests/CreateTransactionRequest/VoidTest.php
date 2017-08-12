<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class VoidTest extends CreateTransactionRequestTestBase
{
    public function testVoidTransaction()
    {
        $transactionRequest = $this->createChargableTransactionRequest(TransactionRequest::AUTH_CAPTURE);
        $request = $this->xmlRequestFactory
          ->createTransactionRequest()
          ->setTransactionRequest($transactionRequest);
        $response = $request->execute();

        // This randomly fails. Maybe because we try to void too soon?
        // Try sleeping for a little bit.
        sleep(2);

        $request = $this->xmlRequestFactory
          ->createTransactionRequest();
        $request->setTransactionRequest(new TransactionRequest([
          'transactionType' => TransactionRequest::VOID,
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
            TransactionRequest::AUTH_CAPTURE,
            '4007000000027'
        );

        $request = $this->jsonRequestFactory
          ->createTransactionRequest()
          ->setTransactionRequest($transactionRequest);
        $response = $request->execute();

        // This randomly fails. Maybe because we try to void too soon?
        // Try sleeping for a little bit.
        sleep(2);

        $request = $this->jsonRequestFactory
          ->createTransactionRequest();
        $request->setTransactionRequest(new TransactionRequest([
          'transactionType' => TransactionRequest::VOID,
          'refTransId' => $response->transactionResponse->transId,
          'amount' => 5.00,
        ]));

        $response = $request->execute();
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
    }
}
