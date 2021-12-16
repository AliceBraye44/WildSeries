<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Service\Slugify;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * The controller for the program add form
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request, Slugify $slugify, MailerInterface $mailer) : Response
    {
        // Create a new Category Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()&& $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($program);

             // Add Slugify
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);

            // Flush the persisted object
            $entityManager->flush();

            // Envoyer un mail lors qu'une nouvelle série est ajoutée
            $email = (new Email())
            ->from($this->getParameter('mailer_from'))
            ->to('your_email@example.com')
            ->subject('Une nouvelle série vient d\'être publiée !')
            ->html($this->renderView('program/newProgramEmail.html.twig', ['program' => $program]));

        $mailer->send($email);

            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('program/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @Route("/{slug}/ ", methods={"GET"}, name="show")
     * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"slug":"slug"}})
     */
    public function show( Program $program) : Response
    {

        if (!$program) {
            throw $this->createNotFoundException(
                'No program : '.$program->getSlug().' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,

        ]);
    }


    /**
    * @Route("/{slug}/season/{season_id}", methods={"GET"}, name="season_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"slug": "slug"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "number"}})
    **/
    public function showSeason(Season $season): Response
   {
        return $this->render('program/season_show.html.twig', [
           'season' => $season,
        ]);
   }


   /**
    * @Route("/{program_slug}/season/{season_id}/episode/{episode_slug}", methods={"GET"}, name="episode_show")
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program_slug": "slug"}})
    * @ParamConverter("season", class="App\Entity\Season", options={"mapping": {"season_id": "number"}})
    * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode_slug": "slug"}})
    **/
   public function showEpisode( Episode $episode) :Response
   {
    return $this->render('program/episode_show.html.twig', [
        'episode' => $episode,
    ]);
}

}
