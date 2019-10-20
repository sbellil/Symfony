<?php


namespace App\Controller;

use App\Form\ContactType;
use App\Entity\Contact;
use App\Notification\NotificationEmail;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends abstractController
{


    public function new(Request $request,NotificationEmail$notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $contact = $form->getData();

            //enregistrer les informations dans la base de données 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            // récupérer les données
            $departement = $contact->getDepartement();
            $email_responsable = $departement->getEmailResponsable();
            $nom = $contact->getNom();
            $prenom = $contact ->getPrenom();
            $msg = $contact ->getMessage();
            $mail = $contact ->getMail();

            //envoyer un le mail
            $notification->sendEmail($email_responsable,$msg,$nom,$prenom,$mail);


            return $this->redirectToRoute('succes-formulaire');
        }

        return $this->render('Contact/new.html.twig', [
            'form' => $form->createView(),
            ]);

    }
    public function success()
    {
        $content = "Votre demande est bien enregistrée!";


    return new Response($content);
  }

}
