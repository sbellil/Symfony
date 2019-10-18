<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $depart = new Departement();
        $depart ->setNomDepartement('Direction');
        $depart ->setNomResponsable('Dupont');
        $depart ->setPrenomResponsable('Xavier');
        $depart ->setEmailResponsable('zina.bellil@hotmail.fr');
        $manager->persist($depart);

        $depart1 = new Departement();
        $depart1 ->setNomDepartement('RH');
        $depart1 ->setNomResponsable('Bellil');
        $depart1 ->setPrenomResponsable('Zaina');
        $depart1 ->setEmailResponsable('zina.bellil@hotmail.fr');
        $manager->persist($depart1);

        $depart2 = new Departement();
        $depart2 ->setNomDepartement('Developpement');
        $depart2 ->setNomResponsable('Deslandes');
        $depart2 ->setPrenomResponsable('Guillaume');
        $depart2 ->setEmailResponsable('zina.bellil@hotmail.fr');
        $manager->persist($depart2);

        $depart3 = new Departement();
        $depart3 ->setNomDepartement('Communication');
        $depart3 ->setNomResponsable('Roder');
        $depart3 ->setPrenomResponsable('Jean');
        $depart3 ->setEmailResponsable('zina.bellil@hotmail.fr');
        $manager->persist($depart3);


        $manager->flush();
    }
}
