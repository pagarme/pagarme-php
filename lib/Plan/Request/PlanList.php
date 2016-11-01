<?php

namespace PagarMe\Sdk\Plan\Request;

use PagarMe\Sdk\Request;

class PlanList implements Request
{

    /**
    * @var int
    **/
    private $page;

    /**
    * @var int
    **/
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
            'count' => $this->count
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return 'plans';
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }
}
