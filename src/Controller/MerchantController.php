<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserMerchant;
use App\Form\MerchantRegister;
use App\Form\SearchMerchantZip;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserMerchantRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MerchantController extends AbstractController
{
    

    /**
     * @Route("/", name="app_home")
     */
    public function home(UserMerchantRepository $userMerchantRepository, Request $request, PaginatorInterface $paginator, Session $session): Response
    {        
        $searchMerchantZip = $this->createForm(SearchMerchantZip::class);

        $searchMerchantZip->handleRequest($request);

        if($searchMerchantZip->isSubmitted() && $searchMerchantZip->isValid()) {
            $criteria = $searchMerchantZip->getData();
            $session->set('zipCode', $criteria['zipCode']);
        }
        
        if ($session->has('zipCode')) {
            $criteria = $session->get('zipCode');
            $merchant = $userMerchantRepository->searchMerchant($criteria);
        } else {
            $merchant = [];
        }


        $userMerchantsPages = $paginator->paginate(
        $merchant, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        3// Nombre de résultats par page
        );

        $resultMerchant = $userMerchantsPages->getItems();
            
        return $this->render('user_merchant/index.html.twig', [
            'formMerchantZip' => $searchMerchantZip->createView(),
            'resultMerchants' => $resultMerchant,
            'userMerchantsPages' => $userMerchantsPages,
        ]);
    }

    /**
     * @Route("merchant/register", name="app_merchant_register")
     */
    public function create(Request $request, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $userMerchant = new UserMerchant();

        $form = $this->createForm(MerchantRegister::class, $userMerchant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUser()->setIsMerchant(true);
            $userMerchant->setUser($this->getUser());
            $em->persist($userMerchant);
            $em->flush();

            $this->addFlash('success', 'Votre compte commerçant a bien été créé.');

            return $this->redirectToRoute('app_home');
        };

        return $this->render('user_merchant/merchant_register.html.twig', [
            'formMerchant' => $form->createView(),
        ]);

    }

        /**
     * @Route("merchant/account/edit", name="app_merchant_account_edit", methods={"GET", "PUT"})
     */
    public function edit(Request $request, EntityManagerInterface $em): Response
    {

        $userMerchant = $this->getUser()->getUserMerchant();
        $userIsMerchant = $this->getUser()->getIsMerchant();

        if($userIsMerchant == true) {

        $form = $this->createForm(MerchantRegister::class, $userMerchant, [
            'method' => 'PUT'
        ]);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
            $em->flush();

            $this->addFlash('success', 'Les modifications ont bien été effectuées');

            return $this->redirectToRoute('app_account');
            }

        } else {
            $this->addFlash('error', 'Vous n\'avez pas de compte commerçant à modifier');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('user_merchant/edit.html.twig', [
            'userMerchant' => $userMerchant,
            'formMerchant' => $form->createView()
        ]);
    }
}
