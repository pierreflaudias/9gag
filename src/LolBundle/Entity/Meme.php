<?php

namespace LolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var array
     */
    private $comments;

    /**
     * Meme constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
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
     * @return int
     */
    public function getNbUpVote(): int
    {
        return $this->nbUpVote;
    }

    /**
     * @param int $nbUpVote
     */
    public function setNbUpVote(int $nbUpVote)
    {
        $this->nbUpVote = $nbUpVote;
    }

    /**
     * @return int
     */
    public function getNbDownVote(): int
    {
        return $this->nbDownVote;
    }

    /**
     * @param int $nbDownVote
     */
    public function setNbDownVote(int $nbDownVote)
    {
        $this->nbDownVote = $nbDownVote;
    }

    /**
     * @return array
     */
    public function getComments(): array
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
