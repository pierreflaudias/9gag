<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:02.
 */

namespace LolBundle\Service;

use LolBundle\Entity\Comment;
use LolBundle\Normalizer\CommentNormalizer;
use LolBundle\Normalizer\UserNormalizer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentNormalizerTest extends \PHPUnit\Framework\TestCase
{
    private $commentNormalizer;

    public function testNormalize()
    {
        $mock_comment = $this->createMock(Comment::class);

        $mock_comment->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Hello'));

        $user_normalized = [
            'username' => 'userToto',
            'email' => 'toto@mail.com',
            'token' => 'apiKey',
        ];

        $mock_user_normalizer = $this->createMock(UserNormalizer::class);

        $mock_user_normalizer->expects($this->once())
            ->method('normalize')
            ->will($this->returnValue($user_normalized));

        $this->commentNormalizer = new CommentNormalizer();

        $this->commentNormalizer->setNormalizer($mock_user_normalizer);

        $result = $this->commentNormalizer->normalize($mock_comment);

        $this->assertEquals('Hello', $result['content']);
        $this->assertEquals($user_normalized, $result['user']);
    }

    public function testDenormalize()
    {
        $mock_data = ['content' => 'Test content'];

        $this->commentNormalizer = new CommentNormalizer();

        $result = $this->commentNormalizer->denormalize($mock_data, Comment::class);

        $this->assertInstanceOf(Comment::class, $result);
        $this->assertEquals($result->getContent(), 'Test content');
    }

    public function testDenormalizeException()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('A comment must have a content.');

        $mock_data = ['foo' => 'Test content'];

        $this->commentNormalizer = new CommentNormalizer();

        $result = $this->commentNormalizer->denormalize($mock_data, Comment::class);

    }
}
