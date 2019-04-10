<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
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
     * @return ExchangeRate[]
     */
    public function getExchangeRates()
    {
        return $this->exchangeRates;
    }
}
