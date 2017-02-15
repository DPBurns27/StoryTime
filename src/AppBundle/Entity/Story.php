<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Story
 *
 * @ORM\Table(name="story")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoryRepository")
 */
class Story
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
     * @ORM\Column(name="urlID", type="string", length=255, unique=true)
     */
    private $urlID;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var array
     *
     * @ORM\Column(name="users", type="array")
     */
    private $users;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="completionDate", type="datetime")
     */
    private $completionDate;

    public function __construct()
    {
        //$this->isActive = true;
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
     * Set urlID
     *
     * @param string $urlID
     *
     * @return Story
     */
    public function setUrlID($urlID)
    {
        $this->urlID = $urlID;

        return $this;
    }

    /**
     * Get urlID
     *
     * @return string
     */
    public function getUrlID()
    {
        return $this->urlID;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Story
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set users
     *
     * @param array $users
     *
     * @return Story
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Story
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set completionDate
     *
     * @param \DateTime $completionDate
     *
     * @return Story
     */
    public function setCompletionDate($completionDate)
    {
        $this->completionDate = $completionDate;

        return $this;
    }

    /**
     * Get completionDate
     *
     * @return \DateTime
     */
    public function getCompletionDate()
    {
        return $this->completionDate;
    }

    /**
     * Add a word to the body
     *
     * @param string $word
     */
    public function addWord($word)
    {
        $this->setBody($this->getBody() . " " . $word);
    }
}

