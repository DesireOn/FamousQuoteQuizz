<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionSuggestion::class)]
    private Collection $questionSuggestions;

    public function __construct()
    {
        $this->questionSuggestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, QuestionSuggestion>
     */
    public function getQuestionSuggestions(): Collection
    {
        return $this->questionSuggestions;
    }

    public function addQuestionSuggestion(QuestionSuggestion $questionSuggestion): self
    {
        if (!$this->questionSuggestions->contains($questionSuggestion)) {
            $this->questionSuggestions->add($questionSuggestion);
            $questionSuggestion->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionSuggestion(QuestionSuggestion $questionSuggestion): self
    {
        if ($this->questionSuggestions->removeElement($questionSuggestion)) {
            // set the owning side to null (unless already changed)
            if ($questionSuggestion->getQuestion() === $this) {
                $questionSuggestion->setQuestion(null);
            }
        }

        return $this;
    }
}
