<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Service\FileParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

	/**
	 * @param FileParser $fileParser
	 * @return Response
	 * @throws \Doctrine\ORM\OptimisticLockException
	 *
	 * @Route("/index", name="homepage")
	 */
    public function indexAction(FileParser $fileParser)
    {
    	$questionsArray = $fileParser->parseFileToArray(__DIR__.'/../../../questions.txt');
    	$fileParser->savePositionToDb($questionsArray);
        return new Response("ELO");
    }

    public function randomQuestionAction() {
    	$this->getDoctrine()->getManager()->getRepository(Question::class);
	}
}
