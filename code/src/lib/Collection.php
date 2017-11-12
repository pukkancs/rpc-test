<?php

namespace Pukkancs\Rpc\Lib;

class Collection
    implements CollectionInterface
{

    protected $items;

    public function __construct(array $array)
    {
        $this->items = $array;
    }

    public function __set(string $name , mixed $value): void
    {
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function getValues(): array
    {
        return array_values($this->items);
    }

    public function flatternWithCombinedKeys(): Collection
    {
        return new Collection(
            $this->doFlatternWithCombinedKeys($this->items)
        );
    }

    public function isMultiDimensional(): bool
    {
        foreach ($this->items as $item) {
            if (is_array($item)) {
                return true;
            }
        }

        return false;
    }

    public function containsOnlyType(string $type): bool
    {
        foreach ($this->items as $item) {
            if (gettype($item) !== $type && !($item instanceof $type)) {
                return false;
            }
        }

        return true;
    }

    public function count(): bool
    {
        return count($this->items, COUNT_RECURSIVE);
    }

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
