<?php

namespace CommerceGuys\AuthNet\DataTypes;

/**
 * Represents a single setting used in HostedPaymentSettings.
 *
 * @see \CommerceGuys\AuthNet\DataTypes\HostedPaymentSettings
 */
class Setting extends BaseDataType
{

    protected $propertyMap = [
        'settingName',
        'settingValue',
    ];

    /**
     * Constructs a new Setting object.
     *
     * @param string $name
     *   The name of the setting (e.g., hostedPaymentReturnOptions).
     * @param mixed $value
     *   The value, which will be JSON-encoded if it's an array.
     */
    public function __construct(string $name, $value)
    {
        parent::__construct();
        $this->properties['settingName'] = $name;
        // Encode the value.
        if (is_array($value)) {
            $value = json_encode($value, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
        }
        $this->properties['settingValue'] = $value;
    }

}
