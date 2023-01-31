<?php

namespace App\Controller\ApiPlatform;
use App\Entity\Visitor;
use App\Entity\VisitorHistory;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GenerateNextQuestion extends AbstractController
{
    public function __construct(private QuestionRepository $questionRepository)
    {
    }

    /**
     * @param Visitor $visitor
     * @return Visitor
     */
    public function __invoke(Visitor $visitor): Visitor
    {
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