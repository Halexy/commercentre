<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\UserMerchantRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserMerchantRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class UserMerchant
{
    use Timestampable;
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ du nom d'entreprise ne peut pas être vide")
     */
    private $brandName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ de description ne peut pas être vide")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{14}/")
     * @Assert\NotBlank(message="Le champ de numéro de siret ne peut pas être vide")
     */
    private $siretNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logoName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ d'adresse ne peut pas être vide")
     */
    private $addessLine;

    /**
     * @ORM\OneToMany(targetEntity=Pin::class, mappedBy="userMerchant", orphanRemoval=true)
     */
    private $pins;

    public function __construct()
    {
        $this->pins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public function setLogoName(string $logoName): self
    {
        $this->logoName = $logoName;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAddessLine(): ?string
    {
        return $this->addessLine;
    }

    public function setAddessLine(string $addessLine): self
    {
        $this->addessLine = $addessLine;

        return $this;
    }


}
