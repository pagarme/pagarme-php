<?php

namespace PagarMe\Sdk;

class RequestHeaders
{
    /**
     * @param array $headers
     *
     * @return array
     */
    public function getSdkHeaders($headers)
    {
        $headerWithUserAgent = $this->addUserAgentHeader($headers);
        $headerWithPagarMeUserAgent = $this->addPagarMeUserAgentHeader(
            $headerWithUserAgent
        );

        return $headerWithPagarMeUserAgent;
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function addPagarMeUserAgentHeader($headers)
    {
        if (isset($headers['X-PagarMe-User-Agent'])) {
            $headers['X-PagarMe-User-Agent'] .= ' ' . $this->getDefaultHeaders();

            return $headers;
        }

        $headers['X-PagarMe-User-Agent'] = $this->getDefaultHeaders();

        return $headers;
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function addUserAgentHeader($headers)
    {
        if (isset($headers['User-Agent'])) {
            $headers['User-Agent'] .= ' ' . $this->getDefaultHeaders();

            return $headers;
        }

        $headers['User-Agent'] = $this->getDefaultHeaders();

        return $headers;
    }

    /**
     * @return string
     */
    private function getDefaultHeaders()
    {
        return 'pagarme-php/' . PagarMe::VERSION;
    }
}
