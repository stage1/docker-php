<?php

/*
 * This file has been auto generated by Jane,
 *
 * Do no edit it directly.
 */

namespace Docker\API\V1_25\Normalizer;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TaskSpecContainerSpecNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;

    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type !== 'Docker\\API\\V1_25\\Model\\TaskSpecContainerSpec') {
            return false;
        }

        return true;
    }

    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof \Docker\API\V1_25\Model\TaskSpecContainerSpec) {
            return true;
        }

        return false;
    }

    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException();
        }
        $object = new \Docker\API\V1_25\Model\TaskSpecContainerSpec();
        if (property_exists($data, 'Image')) {
            $object->setImage($data->{'Image'});
        }
        if (property_exists($data, 'Command')) {
            $values = [];
            foreach ($data->{'Command'} as $value) {
                $values[] = $value;
            }
            $object->setCommand($values);
        }
        if (property_exists($data, 'Args')) {
            $values_1 = [];
            foreach ($data->{'Args'} as $value_1) {
                $values_1[] = $value_1;
            }
            $object->setArgs($values_1);
        }
        if (property_exists($data, 'Env')) {
            $values_2 = [];
            foreach ($data->{'Env'} as $value_2) {
                $values_2[] = $value_2;
            }
            $object->setEnv($values_2);
        }
        if (property_exists($data, 'Dir')) {
            $object->setDir($data->{'Dir'});
        }
        if (property_exists($data, 'User')) {
            $object->setUser($data->{'User'});
        }
        if (property_exists($data, 'Labels')) {
            $values_3 = new \ArrayObject([], \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data->{'Labels'} as $key => $value_3) {
                $values_3[$key] = $value_3;
            }
            $object->setLabels($values_3);
        }
        if (property_exists($data, 'TTY')) {
            $object->setTTY($data->{'TTY'});
        }
        if (property_exists($data, 'Mounts')) {
            $values_4 = [];
            foreach ($data->{'Mounts'} as $value_4) {
                $values_4[] = $this->denormalizer->denormalize($value_4, 'Docker\\API\\V1_25\\Model\\Mount', 'json', $context);
            }
            $object->setMounts($values_4);
        }
        if (property_exists($data, 'StopGracePeriod')) {
            $object->setStopGracePeriod($data->{'StopGracePeriod'});
        }
        if (property_exists($data, 'DNSConfig')) {
            $object->setDNSConfig($this->denormalizer->denormalize($data->{'DNSConfig'}, 'Docker\\API\\V1_25\\Model\\TaskSpecContainerSpecDNSConfig', 'json', $context));
        }

        return $object;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = new \stdClass();
        if (null !== $object->getImage()) {
            $data->{'Image'} = $object->getImage();
        }
        if (null !== $object->getCommand()) {
            $values = [];
            foreach ($object->getCommand() as $value) {
                $values[] = $value;
            }
            $data->{'Command'} = $values;
        }
        if (null !== $object->getArgs()) {
            $values_1 = [];
            foreach ($object->getArgs() as $value_1) {
                $values_1[] = $value_1;
            }
            $data->{'Args'} = $values_1;
        }
        if (null !== $object->getEnv()) {
            $values_2 = [];
            foreach ($object->getEnv() as $value_2) {
                $values_2[] = $value_2;
            }
            $data->{'Env'} = $values_2;
        }
        if (null !== $object->getDir()) {
            $data->{'Dir'} = $object->getDir();
        }
        if (null !== $object->getUser()) {
            $data->{'User'} = $object->getUser();
        }
        if (null !== $object->getLabels()) {
            $values_3 = new \stdClass();
            foreach ($object->getLabels() as $key => $value_3) {
                $values_3->{$key} = $value_3;
            }
            $data->{'Labels'} = $values_3;
        }
        if (null !== $object->getTTY()) {
            $data->{'TTY'} = $object->getTTY();
        }
        if (null !== $object->getMounts()) {
            $values_4 = [];
            foreach ($object->getMounts() as $value_4) {
                $values_4[] = $this->normalizer->normalize($value_4, 'json', $context);
            }
            $data->{'Mounts'} = $values_4;
        }
        if (null !== $object->getStopGracePeriod()) {
            $data->{'StopGracePeriod'} = $object->getStopGracePeriod();
        }
        if (null !== $object->getDNSConfig()) {
            $data->{'DNSConfig'} = $this->normalizer->normalize($object->getDNSConfig(), 'json', $context);
        }

        return $data;
    }
}