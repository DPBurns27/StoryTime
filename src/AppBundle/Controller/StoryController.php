<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Story;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoryController extends Controller
{
    /**
     * @Route("/e/{id}", name="edit_story")
     * @ParamConverter("story", class="AppBundle:Story")
     * @Template("Story/edit_story.html.twig")
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
        //&& $request->request->has('next_word')
        if ($request->isXmlHttpRequest()) {
            $this->get("logger")->info("Received ajax request");
            $input = $request->request->all();
            $story->addWord($input['next_word']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

//            return new JsonResponse(array('body' => $story->getBody()));
            return $this->json(array('body' => $story->getBody(), 'code' => 100 , 'success' => true));
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
        $matcher = $this->get('app.matcher');

        $matcher->addUnmatchedUser($this->getUser());
        $users = $matcher->matchUsers();

        if ($users)
        {
            $story = new Story();
            foreach ($users as $user)
            {
                $story->addUser($user);
            }
            $story->setBody("");
            $dt = new \DateTime('now');
            $story->setCreationDate($dt);

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

            //redirect to the edit page
            return $this->redirectToRoute('edit_story', array('id' => $story->getId()));
        }

        //redirect to the waiting page
        return $this->redirectToRoute('waiting');
    }

    /**
     * @Route("/waiting", name="waiting")
     * @Template("Story/waiting.html.twig")
     */
    public function waitingAction()
    {
        return array();
    }
}




