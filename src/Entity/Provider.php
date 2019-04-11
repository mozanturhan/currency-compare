<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity
 */
class Provider
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var ExchangeRate[] $exchangeRates
     * @ORM\OneToMany(targetEntity="App\Entity\ExchangeRate", mappedBy="provider")
     * @ORM\JoinColumn(referencedColumnName="provider_id", nullable=true)
     */
    private $exchangeRates;

    public function __construct()
    {
        $this->exchangeRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ExchangeRate[]
     */
    public function getExchangeRates(): Collection
    {
        return $this->exchangeRates;
    }

    public function addExchangeRate(ExchangeRate $exchangeRate): self
    {
        if (!$this->exchangeRates->contains($exchangeRate)) {
            $this->exchangeRates[] = $exchangeRate;
            $exchangeRate->setProvider($this);
        }

        return $this;
    }

    public function removeExchangeRate(ExchangeRate $exchangeRate): self
    {
        if ($this->exchangeRates->contains($exchangeRate)) {
            $this->exchangeRates->removeElement($exchangeRate);
            // set the owning side to null (unless already changed)
            if ($exchangeRate->getProvider() === $this) {
                $exchangeRate->setProvider(null);
            }
        }

        return $this;
    }

}
