<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Entity\User;
use App\Form\PinType;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Entity\UserMerchant;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
use App\Repository\UserMerchantRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PinsController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/pins/merchant", name="app_pins_merchant", methods={"GET", "POST"})
     */
    public function index(PinRepository $pinRepository, PaginatorInterface $paginator,
     Request $request, ContactNotification $contactNotification, UserRepository $user): Response
    {        
        $userMerchantsId = $_GET['id'];

        $pinsUserMerchants = $pinRepository->findBy(['user' => $userMerchantsId]);

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $contactNotification->notify($contact, $user);

                $this->addFlash('success', 'Envoyé avec succès');

                return $this->redirectToRoute('app_home');
            }
                elseif($form->isSubmitted())
                {
                    $this->addFlash('error', 'Erreur dans le formulaire');
                }
                
            if($this->getUser())
            {
                $userId = $this->getUser()->getId();
            }
                else
                {
                    $userId = 0;
                }

        $pinsUserMerchantsPages = $paginator->paginate(
            $pinsUserMerchants, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            9 // Nombre de résultats par page
        );

        $pinsOfMerchant = $pinsUserMerchantsPages->getItems();

        return $this->render('pins/pins_merchant.html.twig', [
            'form' => $form->createView(),
            'userMerchantsId' => $userMerchantsId,
            'userId' => $userId,
            'pinsUserMerchantsPages' => $pinsUserMerchantsPages,
            'pinsOfMerchant' => $pinsOfMerchant,
        ]);
    }


    /**
     * @Route("/pins/create", name="app_pins_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $pin = new Pin;

        $form = $this->createForm(PinType::class, $pin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $pin->setUser($this->getUser());
            $this->em->persist($pin);
            $this->em->flush();

            $this->addFlash('success', 'Article ajouté avec succès');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/pins/{id<[0-9]+>}", name="app_pins_show")
     */
    public function show(Pin $pin, Request $request, ContactNotification $contactNotification, UserRepository $user): Response
    {
        if($this->getUser())
        {
            $userId = $this->getUser()->getId();
        } 
        else
        {
            $userId = 0;
        }

        return $this->render('pins/show.html.twig', [
            'pin' => $pin,
            'userId' => $userId,
        ]);
    }

    /**
     * @Route("/pins/{id<[0-9]+>}/edit", name="app_pins_edit", methods={"GET", "PUT"})
     */
    public function edit(Pin $pin, Request $request): Response
    {
        $form = $this->createForm(PinType::class, $pin, [
            'method' => 'PUT'
        ]);

        $pinUserId = $pin->getUser()->getId();
        $userId = $this->getUser()->getId();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $pinUserId == $userId)
        {
            $this->em->flush();

            $this->addFlash('success', 'Article modifié avec succès');

            return $this->redirectToRoute('app_home');
        }

        if ($form->isSubmitted() && $form->isValid() && $pinUserId != $userId)
        {
            $this->addFlash('error', 'Vous ne pouvez pas modifier un produit qui ne vous appartient pas');
        }

        return $this->render('pins/edit.html.twig', [
            'pin' => $pin,
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/pins/delete/{id<[0-9]+>}", name="app_pins_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pin $pin): Response
    {

        $pinUserId = $pin->getUser()->getId();
        $userId = $this->getUser()->getId();

        if ($this->isCsrfTokenValid('pin_deletion_' . $pin->getId(), $request->request->get('csrf_token') ) && $pinUserId == $userId)
        {
            $this->em->remove($pin);
            $this->em->flush();

            $this->addFlash('success', 'Article supprimé avec succès');
        }

        else 
        {
            $this->addFlash('error', 'Vous ne pouvez pas modifier un produit qui ne vous appartient pas');
        }

        return $this->redirectToRoute('app_home');
    }
}