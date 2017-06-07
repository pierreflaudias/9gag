<?php

namespace LolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Meme
 */
class Meme
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $image;

    /**
     * @var int
     */
    private $nbUpVote;

    /**
     * @var int
     */
    private $nbDownVote;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $comments;

    /**
     * Meme constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->date = new \DateTime();
        $this->nbDownVote = 0;
        $this->nbUpVote = 0;
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
     * Set title
     *
     * @param string $title
     *
     * @return Meme
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Meme
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return int
     */
    public function getNbUpVote()
    {
        return $this->nbUpVote;
    }

    /**
     * @param int $nbUpVote
     */
    public function setNbUpVote($nbUpVote)
    {
        $this->nbUpVote = $nbUpVote;
    }

    public function upVote()
    {
        $this->nbUpVote++;
    }

    /**
     * @return int
     */
    public function getNbDownVote()
    {
        return $this->nbDownVote;
    }

    /**
     * @param int $nbDownVote
     */
    public function setNbDownVote($nbDownVote)
    {
        $this->nbDownVote = $nbDownVote;
    }

    public function downVote()
    {
        $this->nbDownVote++;
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function setComments(array $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Add comment
     *
     * @param \LolBundle\Entity\Comment $comment
     *
     * @return Meme
     */
    public function addComment(\LolBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \LolBundle\Entity\Comment $comment
     */
    public function removeComment(\LolBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
}
