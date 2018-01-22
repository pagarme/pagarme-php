<?php

namespace PagarMe\Sdk;

trait Fillable
{
    use CaseConverter;

    /**
     * @param $arrayData
     */
    private function fill($arrayData)
    {
        foreach ($arrayData as $key => $value) {
            $field = $this->snakeToLowerCamel($key);

            if (property_exists($this, $field)) {
                $this->$field = $value;
            }
        }
    }

    /*
    * @summary convert object to an array
    */
    public function toArray() {
        $json = array();
        foreach($this as $key => $value) {
            $json[$key] = is_object($value) ? (method_exists($value, 'toArray') ? $value->toArray() :  $value) : $value;
        }
        return $json;
    }

    /*
    * @summary convert object to an array
    */
    public function toJson() {
        return json_encode($this->toArray());
    }
}
