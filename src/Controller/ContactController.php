<?php


namespace App\Controller;

//use App\Form\ContactType;
//use App\Entity\Contact;
//use App\Notification\NotificationEmail;
use App\Entity\Contact;
use App\Form\ContactType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Departement;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations as Rest;
class ContactController extends abstractController
{
    /**
     * @Rest\View()
     * @Rest\Get("/departements")
     */
    public function getDepartementsAction(Request $request)
    {
        $departements = $this->getDoctrine()
            ->getRepository('App:Departement')
            ->findAll();
        /* @var $departements Departement[] */

        $formatted = [];
        foreach ($departements as $departement) {
            $formatted[] = [
                'nom_departement' => $departement->getNomDepartement(),
                'nom_responsable' => $departement->getNomResponsable(),
                'prenom_responsable' => $departement->getPrenomResponsable(),
                'email_responsable' => $departement->getEmailResponsable(),
            ];
        }

        return new JsonResponse($formatted);
    }

        /**
         * @Rest\View(statusCode=Response::HTTP_CREATED)
         * @Rest\Post("/contact")
         * @return View
         */
        public function postContactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->submit($request->request->all());




        if ($form-> isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($contact);
            $em->flush();
            return $contact;

            //récupération des données
            $departement = $contact->getDepartement();
            $email_responsable = $departement->getEmailResponsable();
            $nom = $contact->getNom();
            $prenom = $contact ->getPrenom();
            $msg = $contact ->getMessage();
            $mail = $contact ->getMail();
            //envoyer un le mail
            $notification->sendEmail($email_responsable,$msg,$nom,$prenom,$mail);


        } else {
            return $form;
        }

    }




}
