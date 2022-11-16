<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use PharIo\Manifest\Requirement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    // Injection du repo dans le construct car besoin sur plusieurs methodes
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/biens', name: 'property.index')]
    public function index(): Response
    {

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    #[Route('/biens/{slug}_{id}', name: 'property.show')]
    public function show(Property $property, string $slug): Response
    {

        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}
