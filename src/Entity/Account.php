<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: self::NOT_BLANK_MESSAGE)]
    #[Assert\Length(min: 1, max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: self::NOT_BLANK_MESSAGE)]
    #[Assert\Length(
        min: 8,
        minMessage: 'Heslo neobsahuje alespoň {{ limit }} znaků.'
    )]
    #[Assert\Regex(
        pattern: '/[A-Z]/',
        message: 'Heslo neobsahuje alespoň jedno velké písmeno.'
    )]
    #[Assert\Regex(
        pattern: '/[0-9]/',
        message: 'Heslo neobsahuje alespoň jedno číslo.'
    )]
    private ?string $password = null;

    #[ORM\Column(enumType: EnumType::class)]
    #[Assert\NotBlank(message: self::NOT_BLANK_MESSAGE)]
    private ?EnumType $type = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expiration = null;

    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Employee $employee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getType(): ?EnumType
    {
        return $this->type;
    }

    public function setType(?EnumType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getExpiration(): ?\DateTimeImmutable
    {
        return $this->expiration;
    }

    public function setExpiration(?\DateTimeImmutable $expiration): static
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
