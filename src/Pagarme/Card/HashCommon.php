<?php
namespace Pagarme\Card;

use Pagarme\Model,
    Pagarme\Request as PagarmeRequest;

/**
 * Class HashCommon
 * @package Pagarme\Card
 */
class HashCommon extends Model
{
    /**
     * @return string
     * @throws \Pagarme\Exception
     */
    public function generateCardHash()
    {
        $request  = new PagarmeRequest('/transactions/card_hash_key', 'GET');
        $response = $request->run();
        $key      = openssl_get_publickey($response['public_key']);
        $params   = array(
            "card_number"          => $this->card_number,
            "card_holder_name"     => $this->card_holder_name,
            "card_expiration_date" => $this->card_expiration_month . $this->card_expiration_year,
            "card_cvv"             => $this->card_cvv
        );
        $str      = "";

        foreach ($params as $k => $v)
            $str .= $k . "=" . $v . "&";


        $str = substr($str, 0, -1);
        openssl_public_encrypt($str, $encrypt, $key);

        return $response['id'] . '_' . base64_encode($encrypt);
    }

    /**
     * @return bool
     */
    protected function shouldGenerateCardHash()
    {
        return true;
    }

    /**
     * @throws \Pagarme\Exception
     */
    public function create()
    {
        $this->generateCardHashIfNecessary();
        parent::create();
    }

    /**
     * @throws \Pagarme\Exception
     */
    public function save()
    {
        $this->generateCardHashIfNecessary();
        parent::save();
    }

    /**
     * @return $this
     */
    private function generateCardHashIfNecessary()
    {
        if (! $this->card_hash && $this->shouldGenerateCardHash())
            $this->card_hash = $this->generateCardHash();


        if ($this->card_hash):
            unset($this->card_holder_name);
            unset($this->card_number);
            unset($this->card_expiration_month);
            unset($this->card_expiration_year);
            unset($this->card_cvv);
        endif;

        return $this;
    }
}
