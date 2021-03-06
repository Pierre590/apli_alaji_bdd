<?php

namespace App\Controller;
use App\Entity\Quiz;
use App\Entity\Student;
use App\Entity\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class QuizController extends AbstractController
{
    /**
     * @Route("/", name="quiz")
     */
    public function quizzes()
    {
        $quizzes = $this->getDoctrine()
        ->getRepository(Quiz::class)
        ->findAll();


        return $this->render('quiz/quizzes.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }
    /**
     * @Route("/{quizId}/candidat", name="quiz_candidat")
     */
    public function candidat(int $quizId)
    {
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($quizId);

        return $this->render('quiz/candidat.html.twig', [
            'quiz' => $quiz,
        ]);
    }
    /**
     * @Route("/{quizId}/candidat/{studentId}", name="quiz_candidat_form")
     */
    public function critere($quizId, $studentId, Request $request)
    {
        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($quizId);

        $student = $this->getDoctrine()
            ->getRepository(Student::class)
            ->find($studentId);



        if ($request->isMethod('POST')) {

            $entityManager = $this->getDoctrine()->getManager();

            $criterias = $quiz->getCriterias();

            foreach ($criterias as $criteria) {
                $result = $this->getDoctrine()
                    ->getRepository(Result::class)
                    ->findOneBy([
                        'criteria' => $criteria,
                        'student' => $student,
                    ]);
                $interview = (int) $request->request->get('criterias')[$criteria->getId()];
                $result->setInterview($interview === 1 ? 1 : 0);

                $test = $result->getTest();

                $aquis = $interview * $criteria->getCoeffInterview() + $test * $criteria->getCoeffTest();

                $result->setAquis($aquis > 0.5);
            }

            $entityManager->flush();

        }

        return $this->render('quiz/test.html.twig', [
            'quiz' => $quiz,
            'student' => $student,


        ]);
    }

    /**
     * @Route("/{quizId}/candidat/{studentId}/results", name="quiz_candidat_results")
     */

    public function result($quizId, $studentId)
    {

        $student = $this->getDoctrine()
            ->getRepository(Student::class)
            ->find($studentId);

        $quiz = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->find($quizId);

        $results = $this->getDoctrine()
            ->getRepository(Result::class)
            ->createQueryBuilder('r')
            ->where('r.student = :student')
            ->andWhere('r.criteria IN (:criteria)')
            ->setParameter('student', $studentId)
            ->setParameter('criteria', $quiz->getCriterias())
            ->getQuery()
            ->getResult();


        return $this->render('quiz/results.html.twig', [
             'student' => $student,
             'quiz' => $quiz,
             'results' => $results,

        ]);
    }

}
