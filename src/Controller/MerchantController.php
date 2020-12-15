<?php

namespace App\Controller;

use App\Entity\UserMerchant;
use App\Form\MerchantRegister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/merchant")
 */
class MerchantController extends AbstractController
{
    /**
     * @Route("", name="app_merchant")
     */
    public function index(): Response
    {
        return $this->render('user_merchant/show.html.twig');
    }

    /**
     * @Route("/register", name="app_merchant_register")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $userMerchant = new UserMerchant();
        $form = $this->createForm(MerchantRegister::class, $userMerchant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($userMerchant);
            $em->flush();

            $this->addFlash('success', 'Votre compte commerçant a bien été créé.');

            return $this->redirectToRoute('app_home');
        };

        return $this->render('user_merchant/merchant_register.html.twig', [
            'formMerchant' => $form->createView()
        ]);

    }
}
