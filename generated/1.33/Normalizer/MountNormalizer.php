<?php

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\V1_33\Normalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MountNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type !== 'Docker\\API\\V1_33\\Model\\Mount') {
            return false;
        }

        return true;
    }

    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof \Docker\API\V1_33\Model\Mount) {
            return true;
        }

        return false;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException();
        }
        $object = new \Docker\API\V1_33\Model\Mount();
        if (property_exists($data, 'Target')) {
            $object->setTarget($data->{'Target'});
        }
        if (property_exists($data, 'Source')) {
            $object->setSource($data->{'Source'});
        }
        if (property_exists($data, 'Type')) {
            $object->setType($data->{'Type'});
        }
        if (property_exists($data, 'ReadOnly')) {
            $object->setReadOnly($data->{'ReadOnly'});
        }
        if (property_exists($data, 'Consistency')) {
            $object->setConsistency($data->{'Consistency'});
        }
        if (property_exists($data, 'BindOptions')) {
            $object->setBindOptions($this->denormalizer->denormalize($data->{'BindOptions'}, 'Docker\\API\\V1_33\\Model\\MountBindOptions', 'json', $context));
        }
        if (property_exists($data, 'VolumeOptions')) {
            $object->setVolumeOptions($this->denormalizer->denormalize($data->{'VolumeOptions'}, 'Docker\\API\\V1_33\\Model\\MountVolumeOptions', 'json', $context));
        }
        if (property_exists($data, 'TmpfsOptions')) {
            $object->setTmpfsOptions($this->denormalizer->denormalize($data->{'TmpfsOptions'}, 'Docker\\API\\V1_33\\Model\\MountTmpfsOptions', 'json', $context));
        }

        return $object;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = new \stdClass();
        if (null !== $object->getTarget()) {
            $data->{'Target'} = $object->getTarget();
        }
        if (null !== $object->getSource()) {
            $data->{'Source'} = $object->getSource();
        }
        if (null !== $object->getType()) {
            $data->{'Type'} = $object->getType();
        }
        if (null !== $object->getReadOnly()) {
            $data->{'ReadOnly'} = $object->getReadOnly();
        }
        if (null !== $object->getConsistency()) {
            $data->{'Consistency'} = $object->getConsistency();
        }
        if (null !== $object->getBindOptions()) {
            $data->{'BindOptions'} = $this->normalizer->normalize($object->getBindOptions(), 'json', $context);
        }
        if (null !== $object->getVolumeOptions()) {
            $data->{'VolumeOptions'} = $this->normalizer->normalize($object->getVolumeOptions(), 'json', $context);
        }
        if (null !== $object->getTmpfsOptions()) {
            $data->{'TmpfsOptions'} = $this->normalizer->normalize($object->getTmpfsOptions(), 'json', $context);
        }

        return $data;
    }
}