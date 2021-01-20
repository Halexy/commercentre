<?php

namespace App\Notification;

use App\Entity\Pin;
use App\Entity\User;
use Twig\Environment;
use App\Entity\Contact;
use App\Entity\UserMerchant;
use App\Repository\PinRepository;
use Symfony\Component\Mime\Email;
use App\Repository\UserMerchantRepository;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification {

    private $mailer;
    private $renderer;

    public function __construct(MailerInterface $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact, UserRepository $user) {

        $userMerchantsId = $_GET['id'];

        $pinsUserMerchants = $user->findOneBy([
            'id' => $userMerchantsId,
        ]);

        $emailMerchant = $pinsUserMerchants->getEmail();
        
        $message = (new Email())
            ->from('commercentre.ne.pas.repondre@gmail.com')
            ->to($emailMerchant)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($contact->getEmail())
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Un client vous a contacté !')
            ->html($this->renderer->render('emails/registration/contact.html.twig', compact('contact')));

            $this->mailer->send($message);
    }
}
