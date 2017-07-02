<?php

namespace CommerceGuys\AuthNet\Tests\CreateTransactionRequest;

use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\TransactionRequest;

class RefundTest extends CreateTransactionRequestTestBase
{

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
            'refTransId' => $response->transactionResponse->transId,
            'amount' => 5.00,
        ]));
        $transactionRequest->addPayment(new CreditCard([
            'cardNumber' => 'XXXX1111',
            'expirationDate' => 'XXXX',
        ]));

        sleep(4);
        $this->assertTrue(isset($response->transactionResponse));
        $this->assertEquals('I00001', $response->getMessages()[0]->getCode());
        $this->assertEquals('Successful.', $response->getMessages()[0]->getText());
        $this->assertEquals('Ok', $response->getResultCode());
    }
}
