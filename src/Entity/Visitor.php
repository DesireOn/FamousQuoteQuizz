<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
#[ApiResource]
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

    #[ORM\OneToMany(mappedBy: 'visitor', targetEntity: VisitorHistory::class)]
    private Collection $visitorHistories;

    public function __construct()
    {
        $this->visitorHistories = new ArrayCollection();
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
     * @return Collection<int, VisitorHistory>
     */
    public function getVisitorHistories(): Collection
    {
        return $this->visitorHistories;
    }

    public function addVisitorHistory(VisitorHistory $visitorHistory): self
    {
        if (!$this->visitorHistories->contains($visitorHistory)) {
            $this->visitorHistories->add($visitorHistory);
            $visitorHistory->setVisitor($this);
        }

        return $this;
    }

    public function removeVisitorHistory(VisitorHistory $visitorHistory): self
    {
        if ($this->visitorHistories->removeElement($visitorHistory)) {
            // set the owning side to null (unless already changed)
            if ($visitorHistory->getVisitor() === $this) {
                $visitorHistory->setVisitor(null);
            }
        }

        return $this;
    }
}
