<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:04.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityRepository;
use LolBundle\Entity\Meme;

class MemeReaderTest extends \PHPUnit_Framework_TestCase
{
    private $memeReader;

    public function testGetAll()
    {
        $mockMeme1 = $this->createMock(Meme::class);
        $mockMeme2 = $this->createMock(Meme::class);

        $mockMeme1->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('The title'));

        $mockMeme2->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('The title 2'));

        $mockMemes = [$mockMeme1, $mockMeme2];

        $memeRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $memeRepository->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($mockMemes));

        $this->memeReader = new MemeReader($memeRepository);

        $memes = $this->memeReader->getAll();

        $this->assertEquals('The title', $memes[0]->getTitle());
        $this->assertEquals('The title 2', $memes[1]->getTitle());
    }

    public function testGetOneById()
    {
        $mockMeme = $this->createMock(Meme::class);

        $mockMeme->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('The title'));

        $memeRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $memeRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($mockMeme));

        $this->memeReader = new MemeReader($memeRepository);

        $meme = $this->memeReader->getOneById(1);

        $this->assertEquals('The title', $meme->getTitle());
    }
}
