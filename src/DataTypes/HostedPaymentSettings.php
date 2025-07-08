<?php

namespace CommerceGuys\AuthNet\DataTypes;

/**
 * Collection of hosted payment settings.
 */
class HostedPaymentSettings extends BaseDataType
{

    /**
     * Adds a setting to the hosted payment configuration.
     *
     * @param Setting $setting
     */
    public function addSetting(Setting $setting): void
    {
        $this->properties[] = ['setting' => $setting->toArray()];
    }
}
