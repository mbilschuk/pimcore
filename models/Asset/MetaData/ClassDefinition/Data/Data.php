<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\Model\Asset\MetaData\ClassDefinition\Data;

use Pimcore\Model\DataObject\Traits\SimpleNormalizerTrait;
use Pimcore\Normalizer\NormalizerInterface;

abstract class Data implements DataDefinitionInterface, NormalizerInterface
{
    use SimpleNormalizerTrait;

    /**
     * @param mixed $value
     * @param array $params
     *
     * @return mixed
     *
     * @deprecated use normalize() instead, will be removed in Pimcore 11
     */
    public function marshal($value, $params = [])
    {
        trigger_deprecation(
            'pimcore/pimcore',
            '10.4',
            sprintf('%s is deprecated, please use normalize() instead. It will be removed in Pimcore 11.', __METHOD__)
        );

        return $this->normalize($value, $params);
    }

    /**
     * @param mixed $value
     * @param array $params
     *
     * @return mixed
     *
     * @deprecated use denormalize() instead, will be removed in Pimcore 11
     */
    public function unmarshal($value, $params = [])
    {
        trigger_deprecation(
            'pimcore/pimcore',
            '10.4',
            sprintf('%s is deprecated, please use denormalize() instead. It will be removed in Pimcore 11.', __METHOD__)
        );

        return $this->denormalize($value, $params);
    }

    public function __toString()
    {
        return get_class($this);
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function transformGetterData($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function transformSetterData($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataFromEditMode($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataForResource($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataFromResource($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataForEditMode($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return bool
     */
    public function isEmpty($data, $params = [])
    {
        return empty($data);
    }

    /**
     * @param mixed $data
     * @param array $params
     */
    public function checkValidity($data, $params = [])
    {
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataForListfolderGrid($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataFromListfolderGrid($data, $params = [])
    {
        return $data;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return array
     */
    public function resolveDependencies($data, $params = [])
    {
        return [];
    }

    /**
     * @param mixed $value
     * @param array $params
     *
     * @return string
     */
    public function getVersionPreview($value, $params = [])
    {
        return (string)$value;
    }

    /**
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function getDataForSearchIndex($data, $params = [])
    {
        if (is_scalar($data)) {
            return $params['name'] . ':' . $data;
        }

        return null;
    }
}
