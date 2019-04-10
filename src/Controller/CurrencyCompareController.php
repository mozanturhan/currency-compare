<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyCompareController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {


        $currencyRepository = $this->getDoctrine()->getRepository("App:Currency");
        $currencyList = $currencyRepository->findAll();
        foreach($currencyList as $currency) {
            $result = $this->getDoctrine()->getRepository("App:ExchangeRate")->findMinimumAmountByCurrency($currency);
            dump($result);
        }

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CurrencyCompareController.php',
        ]);
    }
}
