<?php

namespace AppBundle\Service;
use AppBundle\Entity\Question;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

/**
 * Class QuestionHandler
 * @package AppBundle\Service\QuestionHandler
 */
class QuestionHandler {

	/** EntityManager */
	private $entityManager;

	public function __construct(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
	}

	public function getRandomQuestion() {
		$firstId = $this->entityManager->createQuery('SELECT MIN(q.id) FROM AppBundle:Question q')->getResult(Query::HYDRATE_SINGLE_SCALAR);
		$lastId = $this->entityManager->createQuery('SELECT MAX(q.id) FROM AppBundle:Question q')->getResult(Query::HYDRATE_SINGLE_SCALAR);

		return $this->entityManager->find(Question::class, rand($firstId, $lastId));
	}

}