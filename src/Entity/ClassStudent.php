<?php

namespace App\Entity;

use App\Repository\ClassStudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassStudentRepository::class)]
class ClassStudent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idLesson = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $idUsers = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLesson(): ?int
    {
        return $this->idLesson;
    }

    public function setIdLesson(int $idLesson): static
    {
        $this->idLesson = $idLesson;

        return $this;
    }

    public function getIdUsers(): array
    {
        return $this->idUsers;
    }

    public function setIdUsers(array $idUsers): static
    {
        $this->idUsers = $idUsers;

        return $this;
    }
}
