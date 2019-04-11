<?php


namespace App\Service;


use App\Entity\Currency;
use App\Entity\ExchangeRate;
use App\Entity\Provider;
use App\Provider\API\ProviderAPI;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ProviderService
{
    private $currencyCodes = [
        "USD",
        "EUR",
        "GBP",
    ];

    /**
     * @var ProviderAPI[]
     */
    private $providers = [];

    /**
     * @var ClientService
     */
    private $client;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ApiProviderService constructor.
     * @param ClientService $client
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     */
    public function __construct(ClientService $client, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->em = $em;
    }

    public function addProvider($provider) {

        $this->providers[] = $provider;
    }

    /**
     * @return ProviderAPI[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    public function providerFix() {
        $providers = new ArrayCollection($this->em->getRepository("App:Provider")->findAll());

        foreach ($providers as $provider) {
            $isAvailable = false;
           foreach($this->providers as $activeProvider) {
               if ($activeProvider->getName() == $provider->getName()) $isAvailable = true;
           }

           if (!$isAvailable) {
               $this->em->remove($provider);
               $this->em->flush();
           }
        }
    }

    public function pullData(SymfonyStyle $io) {
        $this->providerFix();
        $currencyList = $this->generateCurrencies();
        foreach ($this->providers as $provider) {

            $providerAdapter = $provider->parseJSON($this->serializer, $this->client->call($provider->getUrl()));
            $providerEntity = $this->generateProvider($provider->getName());

            $io->note("Connecting " . $provider->getName() . " API: " . $provider->getUrl());

            foreach ($providerAdapter as $adapter) {
                $criteria = Criteria::create()->where(Criteria::expr()->eq("code", $adapter->getCode()));
                $filteredCurrency = $currencyList->matching($criteria);

                $isInserted = $this->generateExchangeRate($adapter->getExchangeRate(), $providerEntity, $filteredCurrency->first());

                if ($isInserted) {
                    $io->note($provider->getName() . " API, " . $adapter->getCode() . ": " .  $adapter->getExchangeRate() . " successfully received.");
                }
            }
        }
    }

    private function generateExchangeRate($amount, $provider, $currency) {
        if (!$currency) return false;
        $exchangeRate = $this->em->getRepository("App:ExchangeRate")->findOneBy([
            "provider"=> $provider,
            "currency"=>$currency,
        ]);

        if (is_null($exchangeRate)) {
            $exchangeRate = new ExchangeRate();
            $exchangeRate
                ->setAmount($amount)
                ->setProvider($provider)
                ->setCurrency($currency);
        } else {
            $exchangeRate->setAmount($amount);
        }

        $this->em->persist($exchangeRate);
        $this->em->flush();

        return true;
    }

    /**
     * @param $name
     * @return Provider|null
     */
    private function generateProvider($name) {
        $provider = $this->em->getRepository("App:Provider")->findOneBy(["name" => $name]);

        if (is_null($provider)) {
            $provider = new Provider();
            $provider->setName($name);

            $this->em->persist($provider);
            $this->em->flush();
        }

        return $provider;
    }

    /**
     * @return ArrayCollection<Currency>
     */
    private function generateCurrencies() {
        $currencyList = new ArrayCollection($this->em->getRepository("App:Currency")->findAll());

        if (count($currencyList) == 0) {
            foreach ($this->currencyCodes as $code) {
                $currency = new Currency();
                $currency->setCode($code);
                $this->em->persist($currency);
                $this->em->flush();
            }
        } else {
            foreach ($currencyList as $currency) {
                if (!in_array($currency->getCode(), $this->currencyCodes)) {
                    $this->em->remove($currency);
                    $this->em->flush();
                }
            }

            foreach ($this->currencyCodes as $code) {
                $criteria = Criteria::create()->where(Criteria::expr()->eq("code", $code));
                $filter = $currencyList->matching($criteria);
                if ($filter->count() == 0) {
                    $currency = new Currency();
                    $currency->setCode($code);
                    $this->em->persist($currency);
                    $this->em->flush();
                }
            }

        }

        return new ArrayCollection($this->em->getRepository("App:Currency")->findAll());
    }
}
