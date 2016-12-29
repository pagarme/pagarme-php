<?php

namespace PagarMe\Sdk\AntifraudAnalyses;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Transaction\AbstractTransaction;
use PagarMe\Sdk\AntifraudAnalyses\Request\AntifraudAnalysesList;

class AntifraudAnalysesHandler extends AbstractHandler
{
    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction
     * @return array
     */
    public function getList(AbstractTransaction $transaction)
    {
        $request = new AntifraudAnalysesList($transaction);

        $response = $this->client->send($request);
        $antifraudAnalyses = [];

        foreach ($response as $antifraudAnalysisData) {
            $antifraudAnalysisData->date_created = new \DateTime(
                $antifraudAnalysisData->date_created
            );
            $antifraudAnalysisData->date_updated = new \DateTime(
                $antifraudAnalysisData->date_updated
            );

            $antifraudAnalyses[] = new AntifraudAnalysis(
                $antifraudAnalysisData
            );
        }

        return $antifraudAnalyses;
    }
}
