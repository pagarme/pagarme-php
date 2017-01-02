<?php

namespace PagarMe\Sdk\Search\Request;

use PagarMe\Sdk\Request;

class SearchGet implements Request
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $queryParams;

    /**
     * @param string $type
     * @param array $queryParams
     */
    public function __construct($type, $queryParams)
    {
        $this->type        = $type;
        $this->queryParams = $queryParams;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'type' => $this->type,
            'query' => $this->queryParams
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'search';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_GET;
    }
}
