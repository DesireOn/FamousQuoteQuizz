<?php

namespace App\Controller\ApiPlatform;
use App\Entity\Visitor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class DeleteVisitorHistory extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Visitor $visitor
     * @return Visitor
     */
    public function __invoke(Visitor $visitor): Visitor
    {
        $visitorHistory = $visitor->getVisitorHistory();
        foreach ($visitorHistory as $item) {
            $this->entityManager->remove($item);
        }
        $this->entityManager->flush();

        return $visitor;
    }
}