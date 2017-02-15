<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StoryController extends Controller
{
    /**
     * @Route("/s/{id}", name="story")
     * @ParamConverter("story", class="AppBundle:Story")
     * @Template("Story/story.html.twig")
     */
    public function loginAction(Story $story = null, $id)
    {
        if (!$story) {
            throw $this->createNotFoundException(
                'No story found for id '.$id
                // TODO: Change this error message
            );
        }
        $body = $story->getBody();

        //return $this->render('Story/story.html.twig', array('body' => $body));
        return array('body' => $body);
    }
}
