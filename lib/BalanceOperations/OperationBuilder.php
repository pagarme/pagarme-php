<?php

namespace PagarMe\Sdk\BalanceOperations;

trait OperationBuilder
{
    use \PagarMe\Sdk\Payable\PayableBuilder;
    use \PagarMe\Sdk\Transfer\TransferBuilder;

    /**
     * @param array $operationData
     * @return Operation
     */
    private function buildOperation($operationData)
    {
        $operationData->movement = $this->buildMovement(
            $operationData->movement_object
        );
        $operationData->date_created = new \DateTime(
            $operationData->date_created
        );
        return new Operation(get_object_vars($operationData));
    }

    /**
     * @param array $movementData
     * @return \PagarMe\Sdk\Payable\Payable | \PagarMe\Sdk\Transfer\Transfer
     */
    private function buildMovement($movementData)
    {
        if ($movementData->object == 'payable') {
            return $this->buildPayable($movementData);
        }

        if ($movementData->object == 'transfer') {
            return $this->buildTransfer($movementData);
        }

        throw new \Exception(
            sprintf(
                "Unknow movement type supplied: %s",
                $movementData->object
            ),
            1
        );
    }
}
