<?php

namespace Pagarme;

class CardHashCommon extends Model
{
    public function generateCardHash() 
    {
        $request = new Request();
        $response = $request->send('/transactions/card_hash_key', 'GET');
        $key = openssl_get_publickey($response['public_key']);
        $params = array(
            "card_number" => $this->card_number,
            "card_holder_name" => $this->card_holder_name,
            "card_expiration_date" => $this->card_expiration_month . $this->card_expiration_year,
            "card_cvv" => $this->card_cvv
        );

        openssl_public_encrypt(
            http_build_query($params),
            $encrypt,
            $key
        );

        return $response['id'] . '_' . base64_encode($encrypt);
    }

    protected function shouldGenerateCardHash()
    {
        return true;
    }

    public function create()
    {
        $this->generateCardHashIfNecessary();
        parent::create();
    }

    public function save()
    {
        $this->generateCardHashIfNecessary();
        parent::save();
    }

    private function generateCardHashIfNecessary()
    {
        if (!$this->card_hash && $this->shouldGenerateCardHash()) {
            $this->card_hash = $this->generateCardHash();
        } 

        if ($this->card_hash) {
            unset($this->card_holder_name);
            unset($this->card_number);
            unset($this->card_expiration_month);
            unset($this->card_expiration_year);
            unset($this->card_cvv);
        }
    }
}
