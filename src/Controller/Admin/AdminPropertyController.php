<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
class AdminPropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $propertyRepository;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(PropertyRepository $propertyRepository, ManagerRegistry $doctrine)
    {
        $this->propertyRepository = $propertyRepository;
        $this->em = $doctrine;
    }

    #[Route('/', name: 'admin.property.index')]
    public function index(): Response
    {
        $properties = $this->propertyRepository->findAll();

        return $this->render('admin/property/index.html.twig', compact('properties'));
    }


    #[Route('/property/create', name: 'admin.property.new')]
    public function new(Request $request)
    {
        $entityManager = $this->em->getManager();
        $property = new Property;

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', 'Bien créer avec succès ! ');


            return $this->redirectToRoute('admin.property.index');
        }
        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    #[Route('/property/{id}', name: 'admin.property.edit')]
    public function edit(Property $property, Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        if (null === $property = $entityManager->getRepository(Property::class)->find($id)) {
            throw $this->createNotFoundException('pas de proprieté trouvée avec l id ' . $id);
        }
        // ajout des options/tags
        $option = new Option();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($property->getOptions() as $option) {
            $option->addProperty($property);
        }

        // creation du formulaire
        $form = $this->createForm(PropertyType::class, $property);
        // traitement de la requete
        $form->handleRequest($request);


        // verification des données et flush en bdd
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($option as $option) {
                if (false === $property->getTags()->contains($option)) {
                    // remove the Task from the Tag
                    $option->getTasks()->removeElement($property);
                    $entityManager->persist($option);
                }
            }
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', 'Bien modifié avec succès ! ');
            return $this->redirectToRoute('admin.property.index', ['id' => $id]);
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    #[Route('/property/suppression/{id}', name: 'admin.property.delete', methods: ["POST"])]
    public function delete(Property $property, Request $request, EntityManagerInterface $manager): Response
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $submittedToken)) {

            $manager->remove($property);
            $manager->flush();

            $this->addFlash('success', 'Supprimer avec succès ! ');
        }
        return $this->redirectToRoute('admin.property.index');
    }
}
