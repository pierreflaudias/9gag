<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 13:40.
 */

namespace LolBundle\Reader;

use Doctrine\ORM\EntityRepository;

class CommentReader
{
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOneById($id)
    {
        return $this->repository->find($id);
    }
}
