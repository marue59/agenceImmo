<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    // Iµnjection du repo dans le construct car besoin sur plusieurs methodes
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/acheter', name: 'property.index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*
        // Test insertion bdd
        $entityManager = $doctrine->getManager();
        $property = new Property;

        $property->setTitle('Mon premier bien')
            ->setCity('Calais')
            ->setAdress('10 rue verte')
            ->setPostalCode('62100')
            ->setRooms(5)
            ->setBedrooms(3)
            ->setDescription('une petite description')
            ->setSurface(100)
            ->setHeat(1)
            ->setPrice(200000)
            ->setSold(1);


        $entityManager->persist($property);
        $entityManager->flush();
       
        $property = $this->repository->findAllVisible();
        */
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }
}
