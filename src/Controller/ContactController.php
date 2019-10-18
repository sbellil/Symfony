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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            // récupérer les données
            $nom = $form->get('nom')->getData();
            $prenom = $form->get('prenom')->getData();
            $msg = $form->get('message')->getData();
            $mail = $form->get('mail')->getData();

              //se connecter à la base de données
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=symfony;charset=utf8', 'root', '');
            }
            catch (Exception $e)
            {
                die('Erreur : '.$e->getMessage());
            }

            $responsecontact = $bdd->query('SELECT * From contact ');
            $reponsedepart = $bdd->query('SELECT * From departement');
            while($donnees = $reponsedepart->fetch())
            {
                while ($data=$responsecontact->fetch())
                {
                    if ($donnees['id']==$data['departement_id'])
                    {
                        //envoi du mail
                        $notification->sendEmail($donnees['email_responsable'],$msg,$nom,$prenom,$mail);

                    }

                }

            }

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
