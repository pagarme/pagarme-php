<?php
class PagarMe_TransactionCommon extends PagarMe_Model 
{
	protected $id, $amount, $card_number, $card_holder_name, $card_expiration_month, $card_expiration_year, $card_cvv, $card_hash, $postback_url, $payment_method, $status, $date_created;
	protected $name, $document_number, $document_type, $email, $sex, $born_at, $customer; 
	protected $street, $city, $state, $neighborhood, $zipcode, $complementary, $street_number, $country;
	protected $type, $ddi, $ddd, $number, $phone_id, $gender;
	protected $resfuse_reason, $antifraud_score, $boleto_url, $boleto_barcode;
	protected $card_brand;
	protected $metadata;

	public function generateCardHash() 
	{
		$request = new PagarMe_Request('/transactions/card_hash_key','GET');
		$response = $request->run();
		$key = openssl_get_publickey($response['public_key']);
		$params = $this->cardDataParameters();
		$str = "";
		foreach($params as $k => $v) {
			$str .= $k . "=" . $v . "&";	
		}
		$str = substr($str, 0, -1);
		openssl_public_encrypt($str,$encrypt, $key);
		return $response['id'].'_'.base64_encode($encrypt);
	}


	protected function validateCreditCard($number) {
		// Strip any non-digits (useful for credit card numbers with spaces and hyphens)
		$number=preg_replace('/\D/', '', $number);

		// Set the string length and parity
		$number_length=strlen($number);
		$parity=$number_length % 2;

		// Loop through each digit and do the maths
		$total=0;
		for ($i=0; $i<$number_length; $i++) {
			$digit=$number[$i];
			// Multiply alternate digits by two
			if ($i % 2 == $parity) {
				$digit*=2;
				// If the sum is two digits, add them together (in effect)
				if ($digit > 9) {
					$digit-=9;
				}
			}
			// Total up the digits
			$total+=$digit;
		}

		// If the total mod 10 equals 0, the number is valid
		return ($total % 10 == 0) ? true : false;
	}

	//TODO Validate address and phone info
	protected function errorInTransaction() 
	{
		if($this->payment_method == 'credit_card') { 
			if(strlen($this->card_number) > 20 || !$this->validateCreditCard($this->card_number)) {
				return new PagarMe_Error(array('message' => "Número de cartão inválido.", 'parameter_name' => 'card_number', 'type' => "invalid_parameter"));
			}

			else if(strlen($this->card_holder_name) == 0) {
				return new PagarMe_Error(array('message' => " Nome do portador do cartão inválido", 'parameter_name' => 'card_holder_name', 'type' => "invalid_parameter"));
			}

			else if($this->card_expiration_month <= 0 || $this->card_expiration_month > 12) {
				return new PagarMe_Error(array('message' => "Mês de expiração do cartão inválido", 'parameter_name' => 'card_expiration_date', 'type' => "invalid_parameter"));
			}

			else if($this->card_expiration_year <= 0) {
				return new PagarMe_Error(array('message' => "Ano de expiração do cartão inválido", 'parameter_name' => 'card_expiration_date', 'type' => "invalid_parameter"));
			}

			else if($this->card_expiration_year < substr(date('Y'),-2)) {
				return new PagarMe_Error(array('message' => "Cartão expirado", 'parameter_name' => 'card_expiration_date', 'type' => "invalid_parameter"));
			}

			else if(strlen($this->card_cvv) < 3  || strlen($this->card_cvv) > 4) {
				return new PagarMe_Error(array('message' => "Código de segurança inválido", 'parameter_name' => 'card_cvv', 'type' => "invalid_parameter"));
			}

			else {
				return null;
			}
		}
		if($this->amount <= 0) {
			return new PagarMe_Error(array('message' => "Valor inválido", 'parameter_name' => 'amount', 'type' => "invalid_parameter"));
		}

		return null;
	}

	protected function checkAddress() {
		if(isset($this->zipcode) || isset($this->street_number) || isset($this->street) || isset($this->complementary) || isset($this->neighborhood)) {
			return true;
		} else {
			return false;
		}
	}

	protected function checkPhone() {
		return (isset($this->ddd) || isset($this->number));
	}

	protected function checkCustomerInformation() {
		if($this->checkAddress() || $this->checkPhone() || $this->name || $this->document_number || $this->email || $this->gender || $this->born_at) {
			return true;
		} else {
			return false;
		}

	}

	protected function mergeCustomerInformation($transactionInfo) {
		if($this->checkPhone()) {
			$transactionInfo['customer']['phone']['ddd'] = $this->ddd;
			$transactionInfo['customer']['phone']['number'] = $this->number;
		}

		if($this->checkAddress()) {
			$transactionInfo['customer']['address']['street_number'] = $this->street_number;
			$transactionInfo['customer']['address']['street'] = $this->street;
			$transactionInfo['customer']['address']['neighborhood'] = $this->neighborhood;
			$transactionInfo['customer']['address']['zipcode'] = $this->zipcode;
			$transactionInfo['customer']['address']['complementary'] = $this->complementary;
		}
		$transactionInfo['customer']['document_number'] = $this->document_number;
		$transactionInfo['customer']['email'] = $this->email;
		$transactionInfo['customer']['sex'] = $this->sex;
		$transactionInfo['customer']['gender'] = $this->gender;
		$transactionInfo['customer']['born_at'] = $this->born_at;
		$transactionInfo['customer']['name'] = $this->name;
		return $transactionInfo;
	}

	protected function updateFieldsFromResponse($first_parameter)  
	{

		if(isset($first_parameter['amount'])) {
			$this->setAmount($first_parameter['amount']);
		}

		$this->status = (isset($first_parameter['status']) ? $first_parameter['status'] : 'local');
		$this->setCustomer(isset($first_parameter['customer']) ? $first_parameter['customer'] : 0);
		if(!isset($first_parameter['payment_method']) || $first_parameter['payment_method'] != 'boleto') { 
			if(!isset($first_parameter['card_hash'])) { 
				$this->card_number = (isset($first_parameter["card_number"])) ? $first_parameter['card_number']  : null;
				$this->card_holder_name = (isset($first_parameter["card_holder_name"])) ? $first_parameter['card_holder_name'] : null;
				$this->card_expiration_month = isset($first_parameter["card_expiration_month"]) ? str_pad($first_parameter['card_expiration_month'], 2, '0', STR_PAD_LEFT) : null;
				$this->card_expiration_year = isset($first_parameter["card_expiration_year"]) ? str_pad($first_parameter['card_expiration_year'], 2, '0', STR_PAD_LEFT) : null;
				if(strlen($this->card_expiration_year) >= '4') {
					$this->card_expiration_year = $this->card_expiration_year[2] . $this->card_expiration_year[3];
				}
				$this->card_cvv = isset($first_parameter["card_cvv"]) ? $first_parameter['card_cvv'] : null;
				$this->postback_url = isset($first_parameter['postback_url']) ? $first_parameter['postback_url'] : null;
			} elseif(isset($first_parameter['card_hash'])) {
				$this->card_hash = $first_parameter['card_hash'];
				$this->postback_url = isset($first_parameter['postback_url']) ? $first_parameter['postback_url'] : null;
			}
		}

		$this->installments = isset($first_parameter['installments']) ? $first_parameter["installments"] : null;
		$this->payment_method = isset($first_parameter['payment_method']) ? $first_parameter['payment_method'] : 'credit_card';
		$this->refuse_reason = isset($first_parameter['refuse_reason']) ? $first_parameter['refuse_reason'] : null;
		$this->street = isset($first_parameter['customer']['address']['street']) ? $first_parameter['customer']['address']['street'] : null;
		$this->city = isset($first_parameter['customer']['address']['city']) ? $first_parameter['customer']['address']['city'] : null;
		$this->state = isset($first_parameter['customer']['address']['state']) ? $first_parameter['customer']['address']['state'] : null;
		$this->neighborhood = isset($first_parameter['customer']['address']['neighborhood']) ? $first_parameter['customer']['address']['neighborhood'] : null;
		$this->zipcode = isset($first_parameter['customer']['address']['zipcode']) ? $first_parameter['customer']['address']['zipcode'] : null;
		$this->complementary = isset($first_parameter['customer']['address']['complementary']) ? $first_parameter['customer']['address']['complementary'] : null;
		$this->street_number = isset($first_parameter['customer']['address']['street_number']) ? $first_parameter['customer']['address']['street_number'] : null;
		$this->country = isset($first_parameter['customer']['address']['country']) ? $first_parameter['customer']['address']['country'] : null;
		$this->type = isset($first_parameter['customer']['phone']['type']) ? $first_parameter['customer']['phone']['type'] : null;
		$this->ddi = isset($first_parameter['customer']['phone']['ddi']) ? $first_parameter['customer']['phone']['ddi'] : null;
		$this->ddd = isset($first_parameter['customer']['phone']['ddd']) ? $first_parameter['customer']['phone']['ddd'] : null;
		$this->number = isset($first_parameter['customer']['phone']['number']) ? $first_parameter['customer']['phone']['number'] : null;
		$this->id = isset($first_parameter['id']) ? $first_parameter['id'] : null;
		$this->name = isset($first_parameter['customer']['name']) ? $first_parameter['customer']['name'] : null;
		$this->document_type = isset($first_parameter['customer']['document_type']) ? $first_parameter['customer']['document_type'] : null;
		$this->document_number = isset($first_parameter['customer']['document_number']) ? $first_parameter['customer']['document_number'] : null;
		$this->email = isset($first_parameter['customer']['email']) ? $first_parameter['customer']['email'] : null;
		$this->born_at = isset($first_parameter['customer']['born_at']) ? $first_parameter['customer']['born_at'] : null;
		$this->sex = isset($first_parameter['customer']['sex']) ? $first_parameter['customer']['sex'] : null;
		$this->gender = isset($first_parameter['customer']['gender']) ? $first_parameter['customer']['gender'] : null;
		$this->card_brand = isset($first_parameter['card_brand']) ? $first_parameter['card_brand'] : null;
		$this->boleto_url = isset($first_parameter['boleto_url']) ? $first_parameter['boleto_url'] : null;
		$this->metadata = isset($first_parameter['metadata']) ? $first_parameter['metadata'] : null;
		$this->date_created = isset($first_parameter['date_created']) ? $first_parameter['date_created'] : null;
	}

	protected function cardDataParameters() 
	{
		return array(
			"card_number" => $this->card_number,
			"card_holder_name" => $this->card_holder_name,
			"card_expiration_date" => $this->card_expiration_month . $this->card_expiration_year,
			"card_cvv" => $this->card_cvv
		);
	}

	function setAmount($amount) { 
		if($amount) {
			$amount = str_ireplace(',', "", $amount);
			$amount = str_ireplace('.', "", $amount);
			$amount = str_ireplace('R$', "", $amount);		   
			$amount = trim($amount);
			$this->amount = $amount;
		}	

	}

	function getAmount() { return $this->amount; }
	function setCardNumber($card_number) { $this->card_number = $card_number; }
	function getCardNumber() { return $this->card_number; }
	function setCardHolderName($card_holder_name) { $this->card_holder_name = $card_holder_name; }
	function getCardHolderName() { return $this->card_holder_name; }
	function setCardExpirationMonth($card_expiration_month) { $this->card_expiration_month = $card_expiration_month; }
	function getCardExpirationMonth() { return $this->card_expiration_month; }
	function setCardExpirationYear($card_expiration_year) { $this->card_expiration_year = $card_expiration_year; }
	function getCardExpirationYear() { return $this->card_expiration_year; }
	function setCardCvv($card_cvv) { $this->card_cvv = $card_cvv; }
	function getCardCvv() { return $this->card_cvv; }
	function setLive($live) { $this->live = $live; }
	function getLive() { return $this->live; }
	function setCardHash($card_hash) { $this->card_hash = $card_hash; }
	function getCardHash() { return $this->card_hash; }
	function setInstallments($installments) { $this->installments = $installments; }
	function getInstallments() { return $this->installments; }
	function getStatus() { return $this->status; }
	function setStatus($status) { $this->status = $status;}
	function setPaymentMethod($payment_method) {$this->payment_method = $payment_method;}
	function getPaymentMethod(){return $this->payment_method;}
	function setDateCreated($date_created) { $this->date_created = $date_created;}
	function getDateCreated() { return $this->date_created;}
	function getId() { return $this->id; }
	function setId($id) {$this->id = $id;}
	function getCardBrand() { return $this->card_brand; }
	function setCardBrand($card_brand) {$this->card_brand = $card_brand;}
	function getMetadata() { return $this->metadata;}
	function setMetadata($metadata) { $this->metadata = $metadata; } 

	public function getPostbackUrl() { return $this->postback_url;}
	public function setPostbackUrl($postback_url) { $this->postback_url = $postback_url; }
	

	public function setCustomer($customer) {
		if($customer) { 
			$this->customer = new PagarMe_Customer($customer);
		}
	}

	public function getCustomer() {
		return $this->customer;
	}


	public function getBornAt() { return $this->born_at;}
	public function setBornAt($born_at) { $this->born_at = $born_at; }

	public function getRefuseReason() { return $this->refuse_reason;}

	public function getAntifraudeScore() { return $this->antifraud_score;}

	public function getBoletoUrl() { return $this->boleto_url;}

	public function getBoletoBarcode() { return $this->boleto_barcode;}
} 

?>
