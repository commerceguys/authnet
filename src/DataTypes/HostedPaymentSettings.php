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

    /**
     * Removes setting from the hosted payment configuration.
     *
     * @param string $name
     */
    public function removeSetting(string $name): void
    {
        foreach ($this->properties as $key => $property) {
            if ($property['setting']['settingName'] == $name) {
                unset($this->properties[$key]);
            }
        }
    }
}
