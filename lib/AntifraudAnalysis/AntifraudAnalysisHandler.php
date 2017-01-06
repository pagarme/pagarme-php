<?php

namespace PagarMe\Sdk\AntifraudAnalysis;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Transaction\AbstractTransaction;
use PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisList;
use PagarMe\Sdk\AntifraudAnalysis\Request\AntifraudAnalysisGet;

class AntifraudAnalysisHandler extends AbstractHandler
{
    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction $transaction
     * @return array
     */
    public function getList(AbstractTransaction $transaction)
    {
        $request = new AntifraudAnalysisList($transaction);

        $response = $this->client->send($request);
        $antifraudAnalysis = [];

        foreach ($response as $antifraudAnalysisData) {
            $antifraudAnalysis[] = $this->buildAntifraudAnalysis(
                $antifraudAnalysisData
            );
        }

        return $antifraudAnalysis;
    }

    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction transaction
     * @param int $antifraudId
     * @return AntifraudAnalysis
     */
    public function get(AbstractTransaction $transaction, $antifraudId)
    {
        $request = new AntifraudAnalysisGet($transaction, $antifraudId);

        $response = $this->client->send($request);

        return $this->buildAntifraudAnalysis($response);
    }

    /**
     * @param array antifraudAnalysisData
     * @return AntifraudAnalysis
     */
    private function buildAntifraudAnalysis($antifraudAnalysisData)
    {
        $antifraudAnalysisData->date_created = new \DateTime(
            $antifraudAnalysisData->date_created
        );
        $antifraudAnalysisData->date_updated = new \DateTime(
            $antifraudAnalysisData->date_updated
        );

        return new AntifraudAnalysis($antifraudAnalysisData);
    }
}
