<?php
class PagarMe_Transaction extends PagarMe_TransactionCommon {

	public function charge() 
	{
		$this->create();
	}

	public function capture($amount = false) {
		try {
			$request = new PagarMe_Request(self::getUrl().'/'.$this->id . '/capture', 'POST');
			if($amount) { 
				$request->setParameters(array('amount' => $amount));
			}
			$response = $request->run();
			$this->refresh($response);
		} catch(Exception $e) {
			throw new PagarMe_Exception($e->getMessage());
		}
	}

	public function refund() 
	{
		try {

			// verifica se a transacao e refente a um cartao de creditos
			if($this->payment_method != 'credit_card') {
				// levanta excecao
				throw new PagarMe_Exception(null, array('message' => "Boletos can't be refunded", 'type' => 'forbidden_action'));
			}

			// verifica se a transacao ja foi estornada
			if($this->status == 'refunded') {
				// levanta excecao
				throw new PagarMe_Exception(null, array('message' => "Transaction already refunded!", 'type' => 'forbidden_action'));
			}

			$request = new PagarMe_Request(self::getUrl().'/'.$this->id . '/refund', 'POST');
			$response = $request->run();
			$this->refresh($response);

		} catch(Exception $e) {
			throw new PagarMe_Exception($e->getMessage());
		}
	}
}