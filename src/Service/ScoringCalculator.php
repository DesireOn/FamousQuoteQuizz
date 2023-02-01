<?php

namespace App\Service;

use App\Entity\Visitor;
use App\Entity\VisitorHistory;
use App\Model\Scoring;

class ScoringCalculator
{
    private int $correctAnswers = 0;
    private int $wrongAnswers = 0;

    /**
     * @param Scoring $scoring
     * @return void
     */
    public function calculate(Scoring $scoring): void
    {

        $visitor = $scoring->getVisitor();
        $history = $visitor->getVisitorHistory();
        foreach ($history as $item) {
            $this->processAnswer($item);
        }

        $scoring->setNumberOfCorrectAnswers($this->correctAnswers);
        $scoring->setNumberOfWrongAnswers($this->wrongAnswers);

        $this->processSuccessRate($scoring);
    }

    /**
     * @param VisitorHistory $item
     * @return void
     */
    private function processAnswer(VisitorHistory $item): void
    {
        $question = $item->getQuestion();
        $answer = $item->getAnswer();
        $suggestion = $question->getSuggestionByAnswer($answer);

        if ($suggestion->isIsCorrect()) {
            $this->correctAnswers++;
        } else {
            $this->wrongAnswers++;
        }
    }

    /**
     * @param Scoring $scoring
     * @return void
     */
    private function processSuccessRate(Scoring $scoring): void
    {
        $totalAnswers = $this->correctAnswers + $this->wrongAnswers;
        $successRate = ($this->correctAnswers / $totalAnswers) * 100;
        $scoring->setSuccessRate(number_format($successRate, 2, '.', ''));
    }
}