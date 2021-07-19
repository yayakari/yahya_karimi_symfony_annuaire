<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'email' => 'rh@humanbooster.com',
                'password' => 'rh123@',
                'nom' => 'test',
                'prenom' => 'test',
                'photo' => 'test',
                'secteur' => 'RH',
                'contrat' => 'CDI',
                'sortie' => '',
                'isAdmin'  => true
            ]
            ];
            foreach($users as $user) {
                $object = new User();
                $object->setEmail($user['email']);
                $object->setNom($user['nom']);
                $object->setPrenom($user['prenom']);
                $object->setPhoto($user['photo']);
                $object->setSecteur($user['secteur']);
                $object->setContrat($user['contrat']);
                $object->setContrat($user['sortie']);
                $object->setPassword($this->encoder->hashPassword($object, $user['password']));
                if ($user['isAdmin']) {
                    $object->setRoles(['ROLE_ADMIN']);
                }
    
                $this->addReference('user_'.$user['email'], $object);
    
                $manager->persist($object);
            }

        $manager->flush();
    }
}
