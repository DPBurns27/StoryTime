<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class EditStoryController extends Controller
{
    /**
     * @Route("/e/{id}", name="edit_story")
     * @ParamConverter("story", class="AppBundle:Story")
     * @Template("default/index.html.twig")
     */
    public function indexAction(Story $story = null, $id, Request $request)
    {
        if (!$story) {
            throw $this->createNotFoundException(
                'No story found for id '.$id
            // TODO: Change this error message
            );
        }

        // TODO: Check if the story is still active before allowing editing

        if ($request->request->has('next_word')) {
            $input = $request->request->all();
            $story->addWord($input['next_word']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();
        }

        $body = $story->getBody();

        return array('body' => $body);
    }
}


