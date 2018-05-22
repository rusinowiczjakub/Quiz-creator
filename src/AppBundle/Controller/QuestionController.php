<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Service\FileParser;
use AppBundle\Service\QuestionHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{

	/**
	 * @Route("/", name="homepage")
	 */
	public function indexAction() {
		return $this->render("/../");
	}

	/**
	 * @param FileParser $fileParser
	 * @return Response
	 * @throws \Doctrine\ORM\OptimisticLockException
	 *
	 * @Route("/upload", name="upload")
	 */
    public function uploadAction(FileParser $fileParser)
    {
    	$questionsArray = $fileParser->parseFileToArray(__DIR__.'/../../../questions.txt');
    	$fileParser->savePositionToDb($questionsArray);
        return new Response("ELO");
    }

	/**
	 * @param EntityManager $em
	 * @return Response
	 *
	 * @Route("/api/question", methods="GET")
	 */
    public function randomQuestionAction(QuestionHandler $questionService)
	{
		header("Access-Control-Allow-Origin: *");
		return new JsonResponse($questionService->getRandomQuestion());
	}
}
