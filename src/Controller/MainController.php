<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $providers = $this->getDoctrine()->getRepository("App:Provider")->findAll();
        return $this->render('main/index.html.twig', [
            'providers' => $providers,
        ]);
    }

    /**
     * @Route("/compare", name="compare")
     */
    public function compare() {
        $currencyList = $this->getDoctrine()->getRepository("App:Currency")->findBy([], ["id"=>'ASC']);

        $exchangeRates = [];
        foreach($currencyList as $currency) {
            $exchangeRates[] = $this->getDoctrine()->getRepository("App:ExchangeRate")->findMinimumAmountByCurrency($currency);
        }

        return $this->render('main/compare.html.twig', [
            'exchangeRates' => $exchangeRates,
        ]);
    }
}
