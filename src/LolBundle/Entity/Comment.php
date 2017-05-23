<?php

namespace LolBundle\Entity;

/**
 * Comment
 */
class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Meme
     */
    private $meme;


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
     * @return Comment
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
     * @return Meme
     */
    public function getMeme(): Meme
    {
        return $this->meme;
    }

    /**
     * @param Meme $meme
     * @return Comment
     */
    public function setMeme(Meme $meme): Comment
    {
        $this->meme = $meme;

        return $this;
    }
}