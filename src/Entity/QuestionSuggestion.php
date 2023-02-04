<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\QuestionSuggestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionSuggestionRepository::class)]
#[ApiResource]
class QuestionSuggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questionSuggestions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('visitor:read')]
    private ?Question $question = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('visitor:read')]
    private ?Answer $answer = null;

    #[ORM\Column]
    private ?bool $isCorrect = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(Answer $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function isIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): self
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }
}
