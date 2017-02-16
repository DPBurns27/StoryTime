<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class StoryController extends Controller
{
    /**
     * @Route("/e/{id}", name="edit_story")
     * @ParamConverter("story", class="AppBundle:Story")
     * @Template("default/index.html.twig")
     */
    public function editAction(Story $story = null, $id, Request $request)
    {
        if (!$story) {
            throw $this->createNotFoundException(
                'No story found for id '.$id
            // TODO: Change this error message
            );
        }

        // Checks if the user is allowed to actually edit the story
        $this->denyAccessUnlessGranted('edit', $story);

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

    /**
     * @Route("/s/{id}", name="story")
     * @ParamConverter("story", class="AppBundle:Story")
     * @Template("Story/story.html.twig")
     */
    public function viewAction(Story $story = null, $id)
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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="new_story")
     */
    public function newAction()
    {
        $story = new Story();

        $story->addUser($this->getUser());
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


