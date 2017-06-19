<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:03.
 */

namespace LolBundle\Service;

use Doctrine\ORM\EntityRepository;
use LolBundle\Entity\Comment;

class CommentReaderTest extends \PHPUnit_Framework_TestCase
{
    private $commentReader;
    
    public function testGetOneById(){
        $mockComment = $this->createMock(Comment::class);

        $mockComment->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Hello'));

        $commentRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $commentRepository->expects($this->once())
            ->method('find')
            ->will($this->returnValue($mockComment));

        $this->commentReader = new CommentReader($commentRepository);

        $comment1 = $this->commentReader->getOneById(1);

        $this->assertEquals($comment1->getContent(), 'Hello');
    }
}
