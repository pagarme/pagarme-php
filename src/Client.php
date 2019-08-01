<?php

namespace PagarMe;

use PagarMe\RequestHandler;
use PagarMe\ResponseHandler;
use PagarMe\Endpoints\BankAccounts;
use PagarMe\Endpoints\BulkAnticipations;
use PagarMe\Endpoints\Transactions;
use PagarMe\Endpoints\Customers;
use PagarMe\Endpoints\Cards;
use PagarMe\Endpoints\Recipients;
use PagarMe\Endpoints\PaymentLinks;
use PagarMe\Endpoints\Plans;
use PagarMe\Endpoints\Transfers;
use PagarMe\Endpoints\Subscriptions;
use PagarMe\Endpoints\Refunds;
use PagarMe\Endpoints\Postbacks;
use PagarMe\Endpoints\Balances;
use PagarMe\Endpoints\Payables;
use PagarMe\Endpoints\BalanceOperations;
use PagarMe\Endpoints\Chargebacks;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException as ClientException;
use PagarMe\Exceptions\InvalidJsonException;

class Client
{
    /**
     * @var string
     */
    const BASE_URI = 'https://api.pagar.me:443/1/';

    /**
     * @var string header used to identify application's requests
     */
    const PAGARME_USER_AGENT_HEADER = 'X-PagarMe-User-Agent';

    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \PagarMe\Endpoints\Transactions
     */
    private $transactions;

    /**
     * @var \PagarMe\Endpoints\Customers
     */
    private $customers;

    /**
     * @var \PagarMe\Endpoints\Cards
     */
    private $cards;

    /**
     * @var \PagarMe\Endpoints\Recipients
     */
    private $recipients;

    /**
     * @var \PagarMe\Endpoints\BankAccounts
     */
    private $bankAccounts;

    /**
     * @var \PagarMe\Endpoints\Plans
     */
    private $plans;

    /**
     * @var \PagarMe\Endpoints\BulkAnticipations
     */
    private $bulkAnticipations;

    /**
     * @var \PagarMe\Endpoints\PaymentLinks
     */
    private $paymentLinks;

    /**
     * @var \PagarMe\Endpoints\Transfers
     */
    private $transfers;

    /**
     * @var \PagarMe\Endpoints\Subscriptions
     */
    private $subscriptions;

    /**
     * @var \PagarMe\Endpoints\Refunds
     */
    private $refunds;

    /**
     * @var \PagarMe\Endpoints\Postbacks
     */
    private $postbacks;

    /**
     * @var \PagarMe\Endpoints\Balances
     */
    private $balances;

    /**
     * @var \PagarMe\Endpoints\Payables
     */
    private $payables;

    /**
     * @var \PagarMe\Endpoints\BalanceOperations
     */
    private $balanceOperations;

    /**
     * @var \PagarMe\Endpoints\Chargebacks
     */
    private $chargebacks;

    /**
     * @param string $apiKey
     * @param array|null $extras
     */
    public function __construct($apiKey, array $extras = null)
    {
        $this->apiKey = $apiKey;

        $options = ['base_uri' => self::BASE_URI];

        if (!is_null($extras)) {
            $options = array_merge($options, $extras);
        }

        $userAgent = isset($options['headers']['User-Agent']) ?
            $options['headers']['User-Agent'] :
            '';

        $options['headers'] = $this->addUserAgentHeaders($userAgent);

        $this->http = new HttpClient($options);

        $this->transactions = new Transactions($this);
        $this->customers = new Customers($this);
        $this->cards = new Cards($this);
        $this->recipients = new Recipients($this);
        $this->bankAccounts = new BankAccounts($this);
        $this->plans = new Plans($this);
        $this->bulkAnticipations = new BulkAnticipations($this);
        $this->paymentLinks = new PaymentLinks($this);
        $this->transfers = new Transfers($this);
        $this->subscriptions = new Subscriptions($this);
        $this->refunds = new Refunds($this);
        $this->postbacks = new Postbacks($this);
        $this->balances = new Balances($this);
        $this->payables = new Payables($this);
        $this->balanceOperations = new BalanceOperations($this);
        $this->chargebacks = new Chargebacks($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \PagarMe\Exceptions\PagarMeException
     * @return \ArrayObject
     *
     * @psalm-suppress InvalidNullableReturnType
     */
    public function request($method, $uri, $options = [])
    {
        try {
            $response = $this->http->request(
                $method,
                $uri,
                RequestHandler::bindApiKeyToQueryString(
                    $options,
                    $this->apiKey
                )
            );

            return ResponseHandler::success((string)$response->getBody());
        } catch (InvalidJsonException $exception) {
            throw $exception;
        } catch (ClientException $exception) {
            ResponseHandler::failure($exception);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Build an user-agent string to be informed on requests
     *
     * @param string $customUserAgent
     *
     * @return string
     */
    private function buildUserAgent($customUserAgent = '')
    {
        return trim(sprintf(
            '%s PHP/%s',
            $customUserAgent,
            phpversion()
        ));
    }

    /**
     * Append new keys (the default and pagarme) related to user-agent
     *
     * @param string $customUserAgent
     * @return array
     */
    private function addUserAgentHeaders($customUserAgent = '')
    {
        return [
            'User-Agent' => $this->buildUserAgent($customUserAgent),
            self::PAGARME_USER_AGENT_HEADER => $this->buildUserAgent(
                $customUserAgent
            )
        ];
    }

    /**
     * @return \PagarMe\Endpoints\Transactions
     */
    public function transactions()
    {
        return $this->transactions;
    }

    /**
     * @return \PagarMe\Endpoints\Customers
     */
    public function customers()
    {
        return $this->customers;
    }

    /**
     * @return \PagarMe\Endpoints\Cards
     */
    public function cards()
    {
        return $this->cards;
    }

    /**
     * @return \PagarMe\Endpoints\Recipients
     */
    public function recipients()
    {
        return $this->recipients;
    }

    /**
     * @return \PagarMe\Endpoints\BankAccounts
     */
    public function bankAccounts()
    {
        return $this->bankAccounts;
    }

    /**
     * @return \PagarMe\Endpoints\Plans
     */
    public function plans()
    {
        return $this->plans;
    }

    /**
     * @return \PagarMe\Endpoints\BulkAnticipations
     */
    public function bulkAnticipations()
    {
        return $this->bulkAnticipations;
    }

    /**
     * @return \PagarMe\Endpoints\PaymentLinks
     */
    public function paymentLinks()
    {
        return $this->paymentLinks;
    }

    /**
     * @return \PagarMe\Endpoints\Transfers
     */
    public function transfers()
    {
        return $this->transfers;
    }

    /**
     * @return \PagarMe\Endpoints\Subscriptions
     */
    public function subscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @return \PagarMe\Endpoints\Refunds
     */
    public function refunds()
    {
        return $this->refunds;
    }

    /**
     * @return \PagarMe\Endpoints\Postbacks
     */
    public function postbacks()
    {
        return $this->postbacks;
    }

    /**
     * @return \PagarMe\Endpoints\Balances
     */
    public function balances()
    {
        return $this->balances;
    }

    /**
     * @return \PagarMe\Endpoints\Payables
     */
    public function payables()
    {
        return $this->payables;
    }

    /**
     * @return \PagarMe\Endpoints\BalanceOperations
     */
    public function balanceOperations()
    {
        return $this->balanceOperations;
    }

    /**
     * @return \PagarMe\Endpoints\Chargebacks
     */
    public function chargebacks()
    {
        return $this->chargebacks;
    }
}
