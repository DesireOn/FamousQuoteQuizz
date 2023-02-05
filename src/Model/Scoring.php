<?php

namespace App\Model;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\DataProvider\ScoringDataProvider;
use App\Entity\Visitor;

#[ApiResource(
    shortName: "scoring",
    operations: [
        new Get(provider: ScoringDataProvider::class)
    ]
)]
class Scoring
{
    #[ApiProperty(identifier: true)]
    private string $session;

    private Visitor $visitor;

    private int $numberOfCorrectAnswers;

    private int $numberOfWrongAnswers;

    private float $successRate;

    /**
     * @return string
     */
    public function getSession(): string
    {
        return $this->session;
    }

    /**
     * @param string $session
     * @return Scoring
     */
    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @return Visitor
     */
    public function getVisitor(): Visitor
    {
        return $this->visitor;
    }

    /**
     * @param Visitor $visitor
     * @return Scoring
     */
    public function setVisitor(Visitor $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfCorrectAnswers(): int
    {
        return $this->numberOfCorrectAnswers;
    }

    /**
     * @param int $numberOfCorrectAnswers
     * @return Scoring
     */
    public function setNumberOfCorrectAnswers(int $numberOfCorrectAnswers): self
    {
        $this->numberOfCorrectAnswers = $numberOfCorrectAnswers;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfWrongAnswers(): int
    {
        return $this->numberOfWrongAnswers;
    }

    /**
     * @param int $numberOfWrongAnswers
     * @return Scoring
     */
    public function setNumberOfWrongAnswers(int $numberOfWrongAnswers): self
    {
        $this->numberOfWrongAnswers = $numberOfWrongAnswers;

        return $this;
    }

    /**
     * @return float
     */
    public function getSuccessRate(): float
    {
        return $this->successRate;
    }

    /**
     * @param float $successRate
     * @return Scoring
     */
    public function setSuccessRate(float $successRate): self
    {
        $this->successRate = $successRate;

        return $this;
    }
}