<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 8/2/17
 * Time: 3:58 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ObjectManager
     */
    private $manager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        // test users
        $this->createUser('David','test');
        $this->createUser('Enid','test');
        $this->createUser('Roald','test');
        $this->createUser('Joanne','test');
        $this->createUser('Clive','test');


        $manager->flush();

    }

    public function createUser($username, $plainPassword)
    {
        $user = new User();
        $user->setUsername($username);

        // encode password
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);

        $this->manager->persist($user);

        $this->addReference($username, $user);
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}