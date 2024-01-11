<?php

// src/Entity/Task.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $dueDate = null;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate($dueDate): self
    {
        if (is_string($dueDate)) {
            $date = \DateTime::createFromFormat('d-m-Y', $dueDate);
            if ($date) {
                $this->dueDate = $date;
            } else {
                // Handle the error, maybe throw an exception or log an error
            }
        } elseif ($dueDate instanceof \DateTimeInterface) {
            $this->dueDate = $dueDate;
        }
    
        return $this;
    }
    
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'dueDate' => $this->getDueDate() ? $this->getDueDate()->format('d-m-Y') : null,
        ];
    }
}