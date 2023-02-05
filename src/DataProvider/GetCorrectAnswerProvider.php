<?php

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\QuestionSuggestionRepository;
use App\Repository\VisitorHistoryRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetCorrectAnswerProvider implements ProviderInterface
{
    public function __construct(
        private readonly VisitorHistoryRepository $visitorHistory,
        private readonly QuestionSuggestionRepository $questionSuggestionRepository
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $visitorHistory = $this->visitorHistory->find($uriVariables['id']);
        if (is_null($visitorHistory)) {
            throw new NotFoundHttpException();
        }

        $question = $visitorHistory->getQuestion();
        $answer = $visitorHistory->getAnswer();
        $questionSuggestion = $this->questionSuggestionRepository->findSuggestionByQuestionAndAnswer(
            $question, $answer
        );
        if ($questionSuggestion) {
            $visitorHistory->setIsCorrect(true);
        } else {
            $visitorHistory->setIsCorrect(false);
        }

        return $visitorHistory;
    }
}