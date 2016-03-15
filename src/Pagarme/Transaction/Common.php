<?php
namespace Pagarme\Transaction;

use Pagarme\Card\HashCommon as CardHashCommon,
    Pagarme\Request as PagarmeRequest;

/**
 * Class Common
 * @package Pagarme\Transaction
 */
class Common extends CardHashCommon
{


    /**
     * @param array $response
     */
    public function __construct($response = array())
    {
        parent::__construct($response);
        if (! isset($this->payment_method))
            $this->payment_method = 'credit_card';

        if (! isset($this->status))
            $this->status = 'local';
    }

    /**
     * @return $this
     */
    protected function checkCard()
    {
        if ($this->card):
            if (! $this->hasUnsavedCardAttributes()):
                if ($this->card->id):
                    $this->card_id = $this->card->id;
                else:
                    $this->card_number           = $this->card->card_number;
                    $this->card_holder_name      = $this->card->card_holder_name;
                    $this->card_expiration_month = $this->card->card_expiration_month;
                    $this->card_expiration_year  = $this->card->card_expiration_year;
                    $this->card_cvv              = $this->card->card_cvv;
                endif;
            endif;

            unset($this->card);
        endif;

        return $this;
    }


    public function create()
    {
        $this->checkCard();
        parent::create();
    }

    public function save()
    {
        $this->checkCard();
        parent::save();
    }

    /**
     * @param $amount
     * @param $interest_rate
     * @param $max_installments
     * @return mixed
     * @throws \Pagarme\Exception
     */
    public static function calculateInstallmentsAmount($amount, $interest_rate, $max_installments)
    {
        $request = new PagarmeRequest(self::getUrl() . '/calculate_installments_amount', 'GET');
        $params  = array('amount' => $amount, 'interest_rate' => $interest_rate, 'max_installments' => $max_installments);
        $request->setParameters($params);
        $response = $request->run();

        return $response;
    }

    protected function shouldGenerateCardHash()
    {
        return $this->payment_method == 'credit_card' && ! $this->card_id;
    }

    protected function hasUnsavedCardAttributes()
    {
        $hasUnsavedCardAttrbutes = $this->_unsavedAttributes->includes('card_number');

        return $hasUnsavedCardAttrbutes;
    }
}
