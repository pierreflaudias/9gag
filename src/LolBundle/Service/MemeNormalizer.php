<?php
/**
 * Created by PhpStorm.
 * User: analbessar
 * Date: 12/06/17
 * Time: 10:41
 */

namespace LolBundle\Service;

use LolBundle\Entity\Meme;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MemeNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|scalar
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return [
            'id'     => $object->getId(),
            'name'   => $object->getTitle(),
            'image'   => $object->getImage(),
            'date'   => $object->getDate()->format('Y-m-d H:i:s'),
            'nbUpVote'   => $object->getNbUpVote(),
            'nbDownVote'   => $object->getNbDownVote(),
            'user' => $this->normalizer->normalize($object->getUser(), $format, $context),
            'comments' => array_map(
                function ($object) use ($format, $context) {
                    return $this->normalizer->normalize($object, $format, $context);
                },
                $object->getComments()->toArray()
            )
        ];
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Meme;
    }
}