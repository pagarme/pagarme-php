<?php
namespace Pagarme;

/**
 * Class Util
 * @package Pagarme
 */
class Util
{

    /**
     * @param $str
     * @return string
     */
    public static function fromCamelCase($str)
    {
        $matches = null;
        if (preg_match_all('/(^|[A-Z])+([a-z]|$)*/', $str, $matches)):
            $words       = $matches[0];
            $words_clean = array();
            foreach ($words as $key => $word)
                if (strlen($word) > 0)
                    $words_clean[] = strtolower($word);


            return implode('_', $words_clean);

        else:
            return strtolower($str);
        endif;
    }

    /**
     * @param $arr
     * @return bool
     */
    public static function isList($arr)
    {
        if (! is_array($arr)) {
            return false;
        }

        foreach (array_keys($arr) as $k) {
            if (! is_numeric($k))
                return false;
        }

        return true;
    }

    /**
     * @param $object
     * @return array
     */
    public static function convertPagarMeObjectToArray($object)
    {
        $output = Array();
        foreach ($object as $key => $value)
            if ($value instanceof Object)
                $output[$key] = $value->__toArray(true);
            else if (is_array($value))
                $output[$key] = self::convertPagarMeObjectToArray($value);
            else
                $output[$key] = $value;


        return $output;
    }

    /**
     * @param $response
     * @return array
     */
    public
    static function convertToPagarMeObject($response)
    {
        $types = array(
            'transaction'  => "Pagarme\\Transaction\\Transaction",
            'plan'         => "Pagarme\\Plan",
            'customer'     => "Pagarme\\Customer",
            'address'      => "Pagarme\\Address",
            'phone'        => "Pagarme\\Phone",
            'subscription' => "Pagarme\\Subscription",
        );

        if (self::isList($response)) {
            $output = array();
            foreach ($response as $j)
                array_push($output, self::convertToPagarMeObject($j));


            return $output;
        } else if (is_array($response)) {
            if (isset($response['object']) && is_string($response['object']) && isset($types[$response['object']]))
                $class = $types[$response['object']];
            else
                $class = "Pagarme\\Object";


            return Object::build($response, $class);
        } else {
            return $response;
        }
    }

}
