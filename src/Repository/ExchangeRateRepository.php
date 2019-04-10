<?php


namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class ExchangeRateRepository extends EntityRepository
{
    public function findMinimumAmountByCurrency($currency) {
        return $this->createQueryBuilder("exchange_rate")
            ->leftJoin("App:Currency", "currency", "WITH", "currency = exchange_rate.currency")
            ->where("exchange_rate.currency = :currency")
            ->setParameter("currency", $currency)
            ->setMaxResults(1)
            ->orderBy("currency.id", "ASC")
            ->getQuery()
            ->execute();
    }
}