<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ExchangeRateRepository extends EntityRepository
{
    public function findMinimumAmountByCurrency($currency) {
        return $this->createQueryBuilder("exchange_rate")
            ->where("exchange_rate.currency = :currency")
            ->setParameter("currency", $currency)
            ->setMaxResults(1)
            ->orderBy("exchange_rate.amount", "ASC")
            ->getQuery()
            ->getOneOrNullResult();
    }
}