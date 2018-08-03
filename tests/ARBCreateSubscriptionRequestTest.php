<?php

namespace CommerceGuys\AuthNet\Tests;

use CommerceGuys\AuthNet\ARBCancelSubscriptionRequest;
use CommerceGuys\AuthNet\ARBCreateSubscriptionRequest;
use CommerceGuys\AuthNet\ARBGetSubscriptionListRequest;
use CommerceGuys\AuthNet\ARBGetSubscriptionRequest;
use CommerceGuys\AuthNet\ARBGetSubscriptionStatusRequest;
use CommerceGuys\AuthNet\CreateCustomerProfileRequest;
use CommerceGuys\AuthNet\DataTypes\BillTo;
use CommerceGuys\AuthNet\DataTypes\CreditCard;
use CommerceGuys\AuthNet\DataTypes\CustomerProfileId;
use CommerceGuys\AuthNet\DataTypes\Interval;
use CommerceGuys\AuthNet\DataTypes\OpaqueData;
use CommerceGuys\AuthNet\DataTypes\Order;
use CommerceGuys\AuthNet\DataTypes\Paging;
use CommerceGuys\AuthNet\DataTypes\PaymentProfile;
use CommerceGuys\AuthNet\DataTypes\PaymentSchedule;
use CommerceGuys\AuthNet\DataTypes\Profile;
use CommerceGuys\AuthNet\DataTypes\Sorting;
use CommerceGuys\AuthNet\DataTypes\Subscription;
use CommerceGuys\AuthNet\DataTypes\SubscriptionRequest;
use CommerceGuys\AuthNet\DeleteCustomerProfileRequest;
use CommerceGuys\AuthNet\GetCustomerProfileIdsRequest;
use CommerceGuys\AuthNet\GetCustomerProfileRequest;
use CommerceGuys\AuthNet\UpdateCustomerProfileRequest;

class ARBCreateSubscriptionRequestTest extends TestBase
{
    public function testARBCreateSubscriptionRequestCRUD()
    {
        $interval = new Interval(['length' => 1, 'unit' => 'months']);
        $paymentSchedule = new PaymentSchedule([
            'startDate' => '2018-08-30',
            'totalOccurrences' => 9999,
        ]);
        $paymentSchedule->addInterval($interval);
        $profile = new CustomerProfileId([
            'customerProfileId' => '39931060',
            'customerPaymentProfileId' => '36223863',
        ]);
        $subscription = new Subscription(['amount' => '10.29']);
        $subscription->addPaymentSchedule($paymentSchedule);
        $subscription->addProfile($profile);
        $request = new ARBCreateSubscriptionRequest($this->configurationXml, $this->client, $subscription);
        $request->setSubscription($subscription);
        $response = $request->execute();
        $this->assertObjectHasAttribute('profile', $response->contents());
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        $subscriptionId = $response->contents()->subscriptionId;
        // Test Get.
        $get = new ARBGetSubscriptionRequest($this->configurationXml, $this->client, $subscriptionId);
        $response = $get->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        // Test get status.
        $status = new ARBGetSubscriptionStatusRequest($this->configurationXml, $this->client, $subscriptionId);
        $response = $status->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        // Remove subscription before finishing.
        $cancel = new ARBCancelSubscriptionRequest($this->configurationXml, $this->client, $subscriptionId);
        $response = $cancel->execute();
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        // Retrieve a list of subscriptions.
        $sorting = new Sorting([
            'orderBy' => 'id',
            'orderDescending' => false,
        ]);
        $paging = new Paging([
            'limit' => 100,
            'offset' => 1,
        ]);
        $request = new ARBGetSubscriptionListRequest($this->configurationXml, $this->client, 'subscriptionActive');
        $request->setSorting($sorting);
        $request->setPaging($paging);
        $response = $request->execute();
        $this->assertObjectHasAttribute('totalNumInResultSet', $response->contents());
        $this->assertResponse($response, 'I00001', 'Successful.', 'Ok');
        // If something has caused a lot of built-up subscriptions, remove them.
        if ($response->contents()->totalNumInResultSet > 100) {
            $this->cleanupSubscriptions();
        }
    }

    protected function cleanupSubscriptions()
    {
        $request = new ARBGetSubscriptionListRequest($this->configurationXml, $this->client, 'subscriptionActive');
        $response = $request->execute();
        $contents = $response->contents();
        while ($contents->totalNumInResultSet) {
            $subscriptions = $contents->subscriptionDetails->subscriptionDetail;
            if (!is_array($subscriptions)) {
                $subscriptions = [$contents->subscriptionDetails->subscriptionDetail];
            }
            foreach ($subscriptions as $subscription) {
                $cancel = new ARBCancelSubscriptionRequest($this->configurationXml, $this->client, $subscription->id);
                $response = $cancel->execute();
                $this->assertEquals('Ok', $response->getResultCode());
            }
            $response = $request->execute();
            $contents = $response->contents();
        }
    }
}
