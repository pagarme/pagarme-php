<?php

namespace PagarMe\Sdk\AntifraudAnalyses;

use PagarMe\Sdk\AbstractHandler;
use PagarMe\Sdk\Transaction\AbstractTransaction;
use PagarMe\Sdk\AntifraudAnalyses\Request\AntifraudAnalysesList;
use PagarMe\Sdk\AntifraudAnalyses\Request\AntifraudAnalysesGet;

class AntifraudAnalysesHandler extends AbstractHandler
{
    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction $transaction
     * @return array
     */
    public function getList(AbstractTransaction $transaction)
    {
        $request = new AntifraudAnalysesList($transaction);

        $response = $this->client->send($request);
        $antifraudAnalyses = [];

        foreach ($response as $antifraudAnalysisData) {
            $antifraudAnalyses[] = $this->buildAntifraudAnalysis(
                $antifraudAnalysisData
            );
        }

        return $antifraudAnalyses;
    }

    /**
     * @param PagarMe\Sdk\Transaction\AbstractTransaction transaction
     * @param int $antifraudId
     * @return AntifraudAnalysis
     */
    public function get(AbstractTransaction $transaction, $antifraudId)
    {
        $request = new AntifraudAnalysesGet($transaction, $antifraudId);

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
