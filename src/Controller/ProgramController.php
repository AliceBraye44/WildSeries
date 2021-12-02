<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
* @Route("/program", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', [
        'programs' => $programs ,
     ]);
    }

    /**
     * @Route("/{id}/ ", methods={"GET"}, requirements={"id"="\d+"}, name="show")
     */
    public function show( Program $program) : Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program->getId().' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }


    /**
    * @Route("/{program_id}/season/{season_id}", methods={"GET"}, name="season_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "number"}})
    **/
    public function showSeason(Season $season): Response
   {
        return $this->render('program/season_show.html.twig', [
           'season' => $season,
        ]);
   }


   /**
    * @Route("/{program_id}/season/{season_id}/episode/{episode_id}", methods={"GET"}, name="episode_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_id": "id"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "number"}})
    * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_id": "id"}})
    **/
   public function showEpisode( Episode $episode) :Response
   {
    return $this->render('program/episode_show.html.twig', [
        'episode' => $episode,
    ]);
}

}
