<?php

namespace App\Entity;


use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PropertyRepository;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[UniqueEntity('title', message: 'Ce titre existe déjà.')]
class Property
{
    const HEAT = [
        0 => 'Electrique',
        1 => 'Gaz'
    ];

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/i',
        message: "Le titre contient des caractères non acceptable."
    )]
    #[Assert\Length(
        min: 8,
        max: 25,
        minMessage: 'Le nombre de caractères minimum est de : {{ limit }}',
        maxMessage: 'Le nombre de caractères maximum est de : {{ limit }}',
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(
        min: 20,
        max: 1000,
        minMessage: 'Le nombre de caractères minimum est de : {{ limit }}',
        maxMessage: 'Le nombre de caractères maximum est de : {{ limit }}',
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 10,
        max: 400,
        notInRangeMessage: "La surface doit être comprise entre {{min}}m2 et {{max}} m2."
    )]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $rooms = null;

    #[ORM\Column]
    private ?int $bedrooms = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/i',
        message: "Le prix n'est pas correct"
    )]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $heat = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[0-9]{5}+$/i',
        message: "Le code postal contient des caractères non acceptable."
    )]
    private ?string $postal_code = null;

    #[ORM\Column(type: Types::BOOLEAN, nullable: true)]
    private ?bool $sold = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

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

    public function getSlug(): ?string
    {
        return (new Slugify())->slugify($this->title);
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

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
    //Methode pour formater le prix
    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }
    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function setHeat(?int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getHeatType(): string
    {
        return self::HEAT[$this->heat];
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    // initialisé dans le constructeur 
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
