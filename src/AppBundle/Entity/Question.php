<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionHandler
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

	/**
	 *
	 * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
	 */
    private $answers;

    public function __construct() {
    	$this->answers = new ArrayCollection();
	}

	/**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Question
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

	/**
	 * @return ArrayCollection
	 */
	public function getAnswers() {
		return $this->answers;
	}

	/**
	 * @param $answer
	 */
	public function addAnswer($answer) {
		$this->answers[]= $answer;
	}

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'content' => $this->content,
			'answers' => $this->answers->toArray()
		];
	}


}

