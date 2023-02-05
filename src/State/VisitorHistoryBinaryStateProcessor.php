<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Answer;
use App\Entity\VisitorHistory;

class VisitorHistoryBinaryStateProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $persistProcessor)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof VisitorHistory) {
            $correctAnswer = $data->getQuestion()->getCorrectAnswer();
            if ($correctAnswer) {
                $this->checkIfAnswerIsCorrect($data, $correctAnswer);
            }
            return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
        }
        return $data;
    }

    private function checkIfAnswerIsCorrect(VisitorHistory $visitorHistory, Answer $correctAnswer)
    {
        $submittedAnswer = $visitorHistory->getAnswer();

        $visitorHistory->setIsCorrect(false);
        if ($visitorHistory->getBinaryValue() === 'y') {
            if ($submittedAnswer->getId() === $correctAnswer->getId()) {
                $visitorHistory->setIsCorrect(true);
            }
        } elseif ($visitorHistory->getBinaryValue() === 'n') {
            if ($submittedAnswer->getId() !== $correctAnswer->getId()) {
                $visitorHistory->setIsCorrect(true);
            }
        }
    }
}
