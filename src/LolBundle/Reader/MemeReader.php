<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 17/06/17
 * Time: 17:22.
 */

namespace LolBundle\Reader;

use Doctrine\ORM\EntityRepository;

class MemeReader
{
    private $repository;

    /**
     * MemeReader constructor.
     *
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getAll($limit = 5)
    {
        return $this->memes = $this->repository
            ->findBy([], ['date' => 'DESC'], $limit, 0);
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function getOneById($id)
    {
        return $this->repository->find($id);
    }
}
