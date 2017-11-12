<?php


namespace Pukkancs\Rpc\Test\Unit\Lib;

use PHPUnit\Framework\TestCase;
use Pukkancs\Rpc\Lib\Collection;

class CollectionTest extends TestCase
{

    public function testConstructWithArray()
    {
        $this->assertInstanceOf(Collection::class, new Collection([]));
    }

    /**
     * @expectedException \TypeError
     */
    public function testConstructWithNonArray()
    {
        $nonArray = 'string';

        new Collection($nonArray);
    }

    /** @depends  testConstructWithArray */
    public function testToArray()
    {
        $original = $expected = ['a' => 1];

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->toArray());
    }

    /** @depends  testConstructWithArray */
    public function testGetValues()
    {
        $original = ['a' => 1, 'b' => ['c' => '4']];
        $expected = [1, ['c' => '4']];

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->getValues());
    }

    /** @depends  testToArray */
    public function testFlatternWithCombinedKeysSimpleArray()
    {
        $original = ['a' => ['b' => 12, 'c' => 15], 'd' => 20];

        $expected = ['a-b' => 12, 'a-c' => 15, 'd' => 20];

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->flatternWithCombinedKeys()
                ->toArray());
    }

    /** @depends  testToArray */
    public function testFlatternWithCombinedKeysMatrix()
    {
        $original = [
            'a' =>
                ['b' => 12, 'c' => 15],
            'd' => 20,
            'f' => [
                'e' =>
                    ['g' => 12, 'h' => 15],
                'i' => 20
            ],
            'j'
        ];

        $expected = [
            'a-b' => 12,
            'a-c' => 15,
            'd' => 20,
            'f-e-g' => 12,
            'f-e-h' => 15,
            'f-i' => 20,
            'j'
        ];

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->flatternWithCombinedKeys()
                ->toArray());
    }

    /** @depends  testConstructWithArray */
    public function testIsMultiDimensionalWithSingleDimensionalArray()
    {
        $original = ['a' => 10, 'd' => 20];

        $expected = false;

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->isMultiDimensional()
        );
    }

    /** @depends  testConstructWithArray */
    public function testIsMultiDimensionalWithMultiDimensionalArray()
    {
        $original = [
            'a' =>
                ['b' => 12, 'c' => 15],
            'd' => 20,
            'f' => [
                'e' =>
                    ['g' => 12, 'h' => 15],
                'i' => 20
            ],
            'j'
        ];

        $expected = true;

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->isMultiDimensional()
        );
    }

    /** @depends  testConstructWithArray */
    public function testContainsOnlyTypeWithOnlyOneSimpleType()
    {
        $original = [
            'a' => 1,
            'b' => 20
        ];

        $expected = true;

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->containsOnlyType('integer')
        );
    }

    /** @depends  testConstructWithArray */
    public function testContainsOnlyTypeWithOnlyMultipleTypes()
    {
        $original = [
            'a' => 1,
            'b' => new Collection([]),
            'c' => '20'
        ];

        $expected = false;

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->containsOnlyType('integer')
        );
    }

    /** @depends  testConstructWithArray */
    public function testContainsOnlyTypeWithOnlyOneTypeOfObject()
    {
        $original = [
            'a' => new Collection([1]),
            'b' => new Collection([1, 5])
        ];

        $expected = true;

        $this->assertSame(
            $expected,
            (new Collection($original))
                ->containsOnlyType(Collection::class)
        );
    }

}
