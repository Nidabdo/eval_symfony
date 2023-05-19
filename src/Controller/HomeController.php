<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entity): Response
    {   

        $repository = $entity->getRepository(Produit::class);
        $produits = $repository->findAll();


        $dataLength = count($produits) - 1;
        $arrayvalue = $dataLength - 5;
        
        $array = [$produits] ;

        while ($arrayvalue < $dataLength) {
            $array[$arrayvalue] = [
                $produits[$arrayvalue]
            ];
            $arrayvalue++;
        }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'produits' => 'produit'
        ]);
    }
}
