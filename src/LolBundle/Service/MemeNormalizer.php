<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 12/06/17
 * Time: 10:41.
 */

namespace LolBundle\Service;

use LolBundle\Entity\Meme;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MemeNormalizer implements NormalizerInterface, NormalizerAwareInterface, DenormalizerInterface, DenormalizerAwareInterface
{
    use NormalizerAwareTrait;
    use DenormalizerAwareTrait;

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object  object to normalize
     * @param string $format  format the normalization result will be encoded as
     * @param array  $context Context options for the normalizer
     *
     * @return array|scalar
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'name' => $object->getTitle(),
            'image' => $object->getImage(),
            'date' => $object->getDate()->format('Y-m-d H:i:s'),
            'nbUpVote' => $object->getNbUpVote(),
            'nbDownVote' => $object->getNbDownVote(),
            'user' => $this->normalizer->normalize($object->getUser(), $format, $context),
            'comments' => array_map(
                function ($object) use ($format, $context) {
                    return $this->normalizer->normalize($object, $format, $context);
                },
                $object->getComments()->toArray()
            ),
        ];
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Meme;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed  $data   Data to denormalize from
     * @param string $type   The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Meme::class;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed  $data    data to restore
     * @param string $class   the expected class to instantiate
     * @param string $format  format the given data was extracted from
     * @param array  $context options available to the denormalizer
     *
     * @return object
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!isset($data['title']) || !$data['image'] instanceof UploadedFile) {
            throw new BadRequestHttpException('A LOL must contain a title and an image.');
        }

        return new Meme($data['title'], $data['image']);
    }
}
