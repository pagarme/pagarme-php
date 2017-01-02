<?php

namespace PagarMe\Sdk\Customer\Request;

use PagarMe\Sdk\Request;

class CustomerList implements Request
{
    /**
     * @var int | Página da listagem
     */
    private $page;

    /**
     * @var int | Quantidades de itens a retornar
     */
    private $count;

    /**
     * @param int $page
     * @param int $count
     */
    public function __construct($page, $count)
    {
        $this->page  = $page;
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return [
            'page'  => $this->page,
            'count' => $this->count,
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'customers';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }
}
