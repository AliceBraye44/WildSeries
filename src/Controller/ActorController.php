<?php
// src/Controller/ActorController.php
namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Episode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
* @Route("/actor", name="actor_")
*/
class ActorController extends AbstractController
{
    /**
     * @Route("/{id}/ ", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show( Actor $actor) : Response
    {

        if (!$actor) {
            throw $this->createNotFoundException(
                'No actor with id : '.$actor->getId().' found in actor\'s table.'
            );
        }

        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
        ]);
    }
}
