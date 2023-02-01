<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ApiResource()]
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

    /**
     * @param Answer $answer
     * @return QuestionSuggestion
     */
    public function getSuggestionByAnswer(Answer $answer): QuestionSuggestion
    {
        $suggestion = $this->questionSuggestions->filter(function (QuestionSuggestion $suggestion) use ($answer) {
            return $suggestion->getAnswer()->getId() === $answer->getId();
        })->first();

        if ($suggestion) {
            return $suggestion;
        }
        throw new LogicException('Each answer should have a related question');
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

    /**
     * @return ReadableCollection
     */
    public function getCorrectAnswer(): ReadableCollection
    {
        return $this->getQuestionSuggestions()->filter(function (QuestionSuggestion $questionSuggestion) {
            return $questionSuggestion->isIsCorrect() === true;
        });
    }
}