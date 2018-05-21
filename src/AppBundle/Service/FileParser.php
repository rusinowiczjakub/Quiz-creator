<?php

namespace AppBundle\Service;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\ORM\EntityManager;

/**
 * Class FileParser
 * @package AppBundle\Service
 */
class FileParser {

	/** @var EntityManager */
	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function parseFileToArray($file) {
		$fileContent = explode("\n\n", file_get_contents($file));

		$questionsArray = [];
		foreach ($fileContent as $line) {
			$singlePosition = [];
			$questionWithAnswers = explode(":", $line);

			$singlePosition[] = $questionWithAnswers[0];
			if (count($questionWithAnswers) > 1) {
				$singlePosition[] = explode("\n", $questionWithAnswers[1]);
			}

			$questionsArray[] = $singlePosition;
		}

		return $questionsArray;
	}

	/**
	 * @param array $questionsArray
	 * @throws \Doctrine\ORM\OptimisticLockException
	 */
	public function savePositionToDb(array $questionsArray) {

		$toFlush = [];
		foreach ($questionsArray as $singleArray) {
			$question = new Question();
			$question->setContent(trim($singleArray[0]));

			if (count($singleArray) > 1) {
				foreach ($singleArray[1] as $answerContent) {
					if (strlen($answerContent) > 2) {
						$answer = new Answer();
						$answer->setContent($answerContent);
						$answer->setQuestion($question);
						$question->addAnswer($answer);

						$this->entityManager->persist($answer);
						$toFlush[] = $answer;
					}
				}
			}
			$toFlush[] = $question;
			$this->entityManager->persist($question);
		}

		$this->entityManager->flush($toFlush);
	}
}