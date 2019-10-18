<?php


namespace App\Notification;


use http\Message\Body;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\templates\Notification;


class NotificationEmail
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * NotificationEmail constructor.
     * @param \Swift_Mailer $mailer
     */

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer=$mailer;
   }

    public function sendEmail($destinataire,$message,$nom,$prenom,$contactadd)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('zina.bellil@hotmail.fr')
            ->setTo($destinataire)
            ->setBody("<h1>$message,<br/> Envoyé par:$nom' ' $prenom, <br/>email:$contactadd ",'text/html')
        ;

        $this->mailer->send($message);
    }

}