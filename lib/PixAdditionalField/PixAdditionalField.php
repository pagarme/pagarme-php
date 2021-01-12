<?php

namespace PagarMe\Sdk\PixAdditionalField;

class PixAdditionalField
{

    use \PagarMe\Sdk\Fillable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    public function __construct($pixAdditionalFieldData)
    {
        $this->fill($pixAdditionalFieldData);
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     * @codeCoverageIgnore
     */
    public function getValue()
    {
        return $this->value;
    }
}
