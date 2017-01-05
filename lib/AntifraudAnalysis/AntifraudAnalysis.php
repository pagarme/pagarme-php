<?php

namespace PagarMe\Sdk\AntifraudAnalysis;

class AntifraudAnalysis
{
    use \PagarMe\Sdk\Fillable;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $cost;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \DateTime
     */
    private $dateUpdated;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $score;

    /**
     * @var string
     */
    private $status;

    /**
     * @param array $antifraudAnalysisData
     */
    public function __construct($antifraudAnalysisData)
    {
        $this->fill($antifraudAnalysisData);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
