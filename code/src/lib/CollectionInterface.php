<?php

namespace Pukkancs\Rpc\Lib;

interface CollectionInterface
{
    public function __construct(array $array);

    public function toArray(): array;

    public function getValues(): array;

    public function count(): bool;

    public function isMultiDimensional(): bool;

    public function containsOnlyType(string $type): bool;

}
