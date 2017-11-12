<?php

namespace Pukkancs\Rpc\Lib;

/**
 * Class Collection
 * @package Pukkancs\Rpc\Lib
 */
class Collection
    implements CollectionInterface
{

    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->items = $array;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, mixed $value): void
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return array_values($this->items);
    }

    /**
     * @return Collection
     */
    public function flatternWithCombinedKeys(): Collection
    {
        return new Collection(
            $this->doFlatternWithCombinedKeys($this->items)
        );
    }

    /**
     * @return bool
     */
    public function isMultiDimensional(): bool
    {
        foreach ($this->items as $item) {
            if (is_array($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function containsOnlyType(string $type): bool
    {
        foreach ($this->items as $item) {
            if (gettype($item) !== $type && !($item instanceof $type)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function count(): bool
    {
        return count($this->items, COUNT_RECURSIVE);
    }

    /**
     * @param array $array
     * @param null|string $parentKey
     * @return array
     */
    protected function doFlatternWithCombinedKeys(array $array, ?string $parentKey = null): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = ($parentKey ? ($parentKey . '-') : '') . $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->doFlatternWithCombinedKeys($value, $newKey));
                continue;
            }

            $result[$newKey] = $value;
        }

        return $result;
    }
}
