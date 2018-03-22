<?php

namespace PagarMe\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;

class CardContext extends BasicContext
{
    private $createdCard;
    private $queryCard;

    private $number;
    private $holder;
    private $expiration;
    private $cvv;

    /**
     * @Given a card with :number, :holder, :expiration and :cvv
     */
    public function aCardWithAnd($number, $holder, $expiration, $cvv)
    {
        $this->number     = $number;
        $this->holder     = $holder;
        $this->expiration = $expiration;
        $this->cvv        = $cvv;
    }

    /**
     * @When register the card
     */
    public function registerTheCard()
    {
        $this->createdCard = self::getPagarMe()
            ->card()
            ->create(
                $this->number,
                $this->holder,
                $this->expiration,
                $this->cvv
            );
    }

    /**
     * @Then should have a card starting with :start, ending with :end, and has :expiration
     */
    public function iShouldHaveACardStartingWithAndEndingWith($start, $end, $expiration)
    {
        assertEquals($start, $this->createdCard->getFirstDigits());
        assertEquals($end, $this->createdCard->getLastDigits());
        assertEquals($expiration, $this->createdCard->getExpirationDate());
    }

    /**
     * @When query for the card
     */
    public function iQueryForCard()
    {
        $cardId = $this->createdCard->getId();

        $this->queryCard = self::getPagarMe()
            ->card()
            ->get($cardId);
    }

    /**
     * @Then should have the same card
     */
    public function iShouldHaveTheSameCard()
    {
        assertEquals($this->createdCard->getId(), $this->queryCard->getId());
    }

    /**
     * @And the card must be valid
     */
    public function theCardMustBeValid()
    {
        assertEquals($this->createdCard->getValid(), true);
    }
}
