<?php

namespace App\DataProvider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Model\Scoring;
use App\Repository\VisitorRepository;
use App\Service\ScoringCalculator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScoringDataProvider implements ProviderInterface
{
    public function __construct(
        private readonly VisitorRepository $visitorRepository,
        private readonly ScoringCalculator $calculator
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $visitor = $this->visitorRepository->findOneBy(['session' => $uriVariables['session']]);
        if (is_null($visitor)) {
            throw new NotFoundHttpException();
        }

        $scoring = new Scoring();
        $scoring->setSession($visitor->getSession());
        $scoring->setVisitor($visitor);

        $this->calculator->calculate($scoring);

        return $scoring;
    }
}