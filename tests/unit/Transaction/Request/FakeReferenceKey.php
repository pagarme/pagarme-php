<?php
namespace PagarMe\SdkTest\Transaction\Request;

/**
 * Trait used to generate a fake reference key
 */
trait FakeReferenceKey
{
    /**
     * @return string
     */
    public function getFakeReferenceKey()
    {
        return md5('my-reference-key');
    }
}
