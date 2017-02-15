<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NewStoryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="new_story")
     */
    public function indexAction()
    {
        $story = new Story();

        $story->setUsers(array($this->getUser()->getUsername()));
        $story->setBody("");
        $story->setUrlID(base64_encode(random_bytes(6)));
        $dt = new \DateTime('now');
        $story->setCreationDate($dt);
        $story->setCompletionDate(new \DateTime('now'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($story);
        $em->flush();

        //redirect to the edit page
        return $this->redirectToRoute('edit_story', array('id' => $story->getId()));
    }


}
