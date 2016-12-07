<?php

namespace PagarMe\Sdk\Company\Request;

use PagarMe\Sdk\Request;

class CompanyInfo implements Request
{
    public function getPayload()
    {
        return [];
    }

    public function getPath()
    {
        return 'company';
    }

    public function getMethod()
    {
        return 'GET';
    }
}
