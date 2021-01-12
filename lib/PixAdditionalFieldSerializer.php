<?php

namespace PagarMe\Sdk;

use PagarMe\Sdk\PixAdditionalField\PixAdditionalFieldCollection;

trait PixAdditionalFieldSerializer
{

    /**
     * @param \PagarMe\Sdk\PixAdditionalField\PixAdditionalFieldCollection $pixAdditionalFields
     * @return array
     */
    public function getPixAdditionalFieldsInfo(PixAdditionalFieldCollection $pixAdditionalFields)
    {
        $fields = [];

        foreach ($pixAdditionalFields as $key => $pixAdditionalField) {
            $field = [
                'name'  => $pixAdditionalField->getName(),
                'value' => $pixAdditionalField->getValue()
            ];

            $fields[$key] = $field;
        }

        return $fields;
    }
}
