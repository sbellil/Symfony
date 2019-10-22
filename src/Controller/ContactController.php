<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\NotificationEmail;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Departement;
use FOS\RestBundle\Controller\Annotations as Rest;

class ContactController extends AbstractFOSRestController implements ClassResourceInterface
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }
/**
 * @Rest\Post("/contact")
 */
    public function postAction(Request $request,NotificationEmail $notification)
    {
        $form = $this->createForm(ContactType::class,new Contact());

        $form->submit($request->request->all());

        if (false === $form->isValid()) {



            return $this->handleView(
                $this->view($form)
            );
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        $contact = $form->getData();
        $departement = $contact->getDepartement();
        $email_responsable = $departement->getEmailResponsable();
        $nom = $contact->getNom();
        $prenom = $contact ->getPrenom();
        $msg = $contact ->getMessage();
        $mail = $contact ->getMail();
        //envoyer un le mail
        $notification->sendEmail($email_responsable,$msg,$nom,$prenom,$mail);
        

        return $this->handleView(
            $this->view(
                [
                    'status' => 'ok',
                ],
                Response::HTTP_CREATED
            )
        );
    }




}
