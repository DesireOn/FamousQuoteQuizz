<?php

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\VisitorHistory;
use App\Model\Scoring;
use App\Repository\QuestionRepository;
use App\Repository\VisitorRepository;
use App\Service\ScoringCalculator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenerateNextQuestionProvider implements ProviderInterface
{
    public function __construct(
        private readonly VisitorRepository $visitorRepository,
        private readonly QuestionRepository $questionRepository
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $visitor = $this->visitorRepository->findOneBy(['session' => $uriVariables['session']]);
        if (is_null($visitor)) {
            throw new NotFoundHttpException();
        }
        $answeredQuestions = $visitor->getVisitorHistory();
        $ids = $answeredQuestions->map(function (VisitorHistory $answeredQuestion) {
            return $answeredQuestion->getQuestion()->getId();
        });

        $unansweredQuestions = $this->questionRepository->findUnansweredQuestions($ids->toArray());
        if (count($unansweredQuestions) > 0) {
            $key = array_rand($unansweredQuestions);
            $visitor->setNextQuestion($unansweredQuestions[$key]);
        }

        return $visitor;
    }
}