<?php

namespace Pukkancs\Rpc\Lib;

/**
 * Interface CollectionInterface
 * @package Pukkancs\Rpc\Lib
 */
interface CollectionInterface
{
    /**
     * CollectionInterface constructor.
     * @param array $array
     */
    public function __construct(array $array);

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function getValues(): array;

    /**
     * @return bool
     */
    public function count(): bool;

    /**
     * @return bool
     */
    public function isMultiDimensional(): bool;

    /**
     * @param string $type
     * @return bool
     */
    public function containsOnlyType(string $type): bool;

}
