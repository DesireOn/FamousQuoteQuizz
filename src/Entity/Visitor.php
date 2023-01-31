<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
class Visitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $session = null;

    #[ORM\Column]
    private array $settings = [];

    #[ORM\OneToMany(mappedBy: 'visitor', targetEntity: AnsweredQuestion::class)]
    private Collection $answeredQuestions;

    public function __construct()
    {
        $this->answeredQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    /**
     * @return Collection<int, AnsweredQuestion>
     */
    public function getAnsweredQuestions(): Collection
    {
        return $this->answeredQuestions;
    }

    public function addAnsweredQuestion(AnsweredQuestion $answeredQuestion): self
    {
        if (!$this->answeredQuestions->contains($answeredQuestion)) {
            $this->answeredQuestions->add($answeredQuestion);
            $answeredQuestion->setVisitor($this);
        }

        return $this;
    }

    public function removeAnsweredQuestion(AnsweredQuestion $answeredQuestion): self
    {
        if ($this->answeredQuestions->removeElement($answeredQuestion)) {
            // set the owning side to null (unless already changed)
            if ($answeredQuestion->getVisitor() === $this) {
                $answeredQuestion->setVisitor(null);
            }
        }

        return $this;
    }
}
