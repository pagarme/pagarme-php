<?php

namespace PagarMe\Sdk\PixAdditionalField;

trait PixAdditionalFieldBuilder
{
    /**
     * @param array $pixAdditionalFieldData
     * @return PixAdditionalFieldCollection
     */
    private function buildPixAdditionalField($pixAdditionalFieldData)
    {
        $fields = new PixAdditionalFieldCollection();

        if (is_array($pixAdditionalFieldData)) {
            foreach ($pixAdditionalFieldData as $field) {
                $field->date_created = new \DateTime($field->date_created);
                $field->date_updated = new \DateTime($field->date_updated);
                $fields[] = new PixAdditionalField(get_object_vars($field));
            }
        }

        return $fields;
    }
}
