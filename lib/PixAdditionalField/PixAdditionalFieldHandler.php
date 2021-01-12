<?php

namespace PagarMe\Sdk\PixAdditionalField;

class PixAdditionalFieldHandler
{
    /**
     * @param string $name
     * @param string $value
     * @return PixAdditionalField
     */
    public function additionalPixField(
        $name,
        $value
    ) {
        return new PixAdditionalField(
            [
                'name'  => $name,
                'value' => $value,
            ]
        );
    }
}
