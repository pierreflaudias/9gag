<?php
/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/06/17
 * Time: 14:03.
 */

namespace LolBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use LolBundle\Entity\Meme;
use LolBundle\Normalizer\CommentNormalizer;
use LolBundle\Normalizer\MemeNormalizer;
use LolBundle\Normalizer\UserNormalizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MemeNormalizerTest extends \PHPUnit\Framework\TestCase
{
    private $memeNormalizer;

    public function testNormalize()
    {
        $mock_meme = $this->createMock(Meme::class);

        $mock_meme->expects($this->once())
            ->method('getTitle')
            ->will($this->returnValue('Test meme'));

        $mock_meme->expects($this->once())
            ->method('getImage')
            ->will($this->returnValue('image.png'));

        $mock_meme->expects($this->once())
            ->method('getDate')
            ->will($this->returnValue(new \DateTime()));

        $mock_meme->expects($this->once())
            ->method('getNbUpVote')
            ->will($this->returnValue(5));

        $mock_meme->expects($this->once())
            ->method('getNbDownVote')
            ->will($this->returnValue(3));

        $mock_meme->expects($this->once())
            ->method('getComments')
            ->will($this->returnValue(new ArrayCollection()));

        $user_normalized = [
            'username' => 'userToto',
            'email' => 'toto@mail.com',
            'token' => 'apiKey',
        ];

        $mock_user_normalizer = $this->createMock(UserNormalizer::class);

        $mock_user_normalizer->expects($this->once())
            ->method('normalize')
            ->will($this->returnValue($user_normalized));

        $mock_comment_normalizer = $this->createMock(CommentNormalizer::class);

        /*$mock_comment_normalizer->expects($this->once())
            ->method('normalize')
            ->will($this->returnValue([
                'content' => 'A comment'
            ]));*/

        $this->memeNormalizer = new MemeNormalizer();

        $this->memeNormalizer->setNormalizer($mock_user_normalizer);
        //$this->memeNormalizer->setNormalizer($mock_comment_normalizer);

        $result = $this->memeNormalizer->normalize($mock_meme);

        $this->assertEquals('Test meme', $result['name']);
        $this->assertEquals($user_normalized, $result['user']);
    }

    public function testDenormalize()
    {
        $mock_image = $this->getMockBuilder('Symfony\Component\HttpFoundation\File\UploadedFile')
            ->enableOriginalConstructor()
            ->setConstructorArgs([tempnam(sys_get_temp_dir(), ''), 'image.png'])
            ->getMock();

        $mock_data = [
            'title' => 'Meme title',
            'image' => $mock_image
        ];

        $this->memeNormalizer = new MemeNormalizer();

        $result = $this->memeNormalizer->denormalize($mock_data, Meme::class);

        $this->assertInstanceOf(Meme::class, $result);
        $this->assertEquals($result->getTitle(), 'Meme title');
    }

    public function testDenormalizeException()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('A LOL must contain a title and an image.');

        $mock_data = ['foo' => 'Test content'];

        $this->memeNormalizer = new MemeNormalizer();

        $result = $this->memeNormalizer->denormalize($mock_data, Meme::class);

    }
}
