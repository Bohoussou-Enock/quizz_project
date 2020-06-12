<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Score;
use App\Entity\History;
use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Participant;
use App\Entity\Proposition;
use App\Form\ParticipantType;
use App\Repository\ScoreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     */
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/enregistrement_participant", name="enregistrementParticipant")
     */
    public function enregistrement_participant(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->IsValid()) {
            $hash = $encoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($participant);
            $manager->flush();

            return $this->redirectToRoute('appLogin');
        }
        return $this->render('app/enregistrement_participant.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/liste_quiz", name="listeQuiz")
     */
    public function liste_quiz()
    {
        $r = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $r->findAll();
        //dump($quiz);

        return $this->render('app/liste_quiz.html.twig', [
            'controller_name' => 'AppController',
            'quiz' => $quiz
        ]);
    }

    /**
     * @Route("/quiz_question/{id}", name="quizQuestion")
     */
    public function quiz_question(Request $request, $id)
    {
        $question = $this->getDoctrine()->getRepository(Question::class)->findBy(['quiz' => $id]);
        //dump($request->request);
        if ($request->request->count() > 0) {
            /**
             * dataRequest est un tableau
             * [id question => id proposition choisie]
             */
            $dataRequest = $request->request->all();
            //dump($dataRequest);

            $note = 0;

            foreach ($dataRequest as $key => $value) {

                $question = $this->getDoctrine()->getRepository(Question::class)->findOneBy(['id' => $key]);
                $participant = $this->getDoctrine()->getRepository(Participant::class)->findOneBy(['id' => '1']);
                $history = new History();
                $history->addQuestion($question)
                    ->addProposition($this->getDoctrine()->getRepository(Proposition::class)->findOneBy(['id' => $value]))
                    ->addParticipant($participant);

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($history);

                $quiz = $this->getDoctrine()->getRepository(Quiz::class)->findOneBy(['id' => $question->getQuiz()]);
                $reponse = $this->getDoctrine()->getRepository(Reponse::class)->findOneBy(['question' => $key]);
                if ($reponse->getProposition()->getId() == $value) {
                    $note = $note + $reponse->getNote();
                }
            }
            $manager->flush();

            $score = new Score();
            $score->addQuiz($quiz)
                ->setValue($note)
                ->addParticipant($participant);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($score);
            $manager->flush();

            return $this->redirectToRoute('quizResultat');
        }

        return $this->render('app/quiz_question.html.twig', [
            'questions' => $question
        ]);
    }

    /**
     * @Route("/quiz_resultat", name="quizResultat")
     */
    public function quiz_resultat(ScoreRepository $scoreRepository): Response
    {
        return $this->render('app/quiz_resultat.html.twig', [
            'scores' => $scoreRepository->findAll(),
        ]);
    }
}
