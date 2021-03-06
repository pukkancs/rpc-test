<?php

namespace Pukkancs\Rpc\Lib;

use InvalidArgumentException;

/**
 * Class Math
 * @package Pukkancs\Rpc\Lib
 */
class Math
{

    /**
     * @param CollectionInterface $subject
     * @return int
     */
    public function greatestCommonDivider(CollectionInterface $subject): int
    {
        if ($subject->isMultiDimensional()) {
            throw new InvalidArgumentException('GreatesCommonDivider supports single dimensional arrays only');
        }

        if (!$subject->containsOnlyType('integer')) {
            throw new InvalidArgumentException('GreatesCommonDivider can only contain integers');
        }

        if ($subject->count() < 2) {
            throw new InvalidArgumentException('GreatesCommonDivider can only be determined for two or more numbers');
        }

        if ($this->containsZerosOnly($subject)) {
            throw new InvalidArgumentException('GreatesCommonDivider can not be determined for only zeros');
        }

        return $this->calculateGreatestCommonDivider($subject);
    }

    /**
     * @param CollectionInterface $subject
     * @return bool
     */
    public function containsZerosOnly(CollectionInterface $subject): bool
    {
        foreach ($subject->getValues() as $key => $item) {
            if ($item <> 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param CollectionInterface $subject
     * @param bool $excludeZeroItems
     * @return int|null
     */
    public function getAbsMin(CollectionInterface $subject, $excludeZeroItems = false): ?int
    {
        $absMin = null;

        foreach ($subject->getValues() as $key => $item) {
            if (!is_numeric($item)) {
                continue;
            }

            if ($excludeZeroItems && $item === 0) {
                continue;
            }

            if (!is_null($absMin) && abs($item) > $absMin) {
                continue;
            }

            $absMin = abs($item);
        }

        return $absMin;
    }

    /**
     * @param CollectionInterface $subject
     * @return int
     */
    private function calculateGreatestCommonDivider(CollectionInterface $subject): int
    {
        $gcd = 1;
        $cap = $this->getAbsMin($subject, true);

        for ($i = $cap; $i >= 2; $i--) {
            $isNotCommonDivider = false;
            foreach ($subject->getValues() as $key => $item) {
                if ($item === 0) {
                    continue;
                }

                if ($item % $i !== 0) {
                    $isNotCommonDivider = true;
                }
            }

            if ($isNotCommonDivider) {
                continue;
            }

            $gcd = $i;
            break;
        }

        return $gcd;
    }

}
