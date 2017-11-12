<?php

namespace Pukkancs\Rpc\Test\Unit\Lib;


use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Pukkancs\Rpc\Lib\Collection;
use Pukkancs\Rpc\Lib\Math;

class MathTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @var  Mockery\Mock */
    protected $collection;

    protected function setUp()
    {
        $this->collection = Mockery::mock(Collection::class);
    }

    public function testContainsZerosOnlyWithNotOnlyZeros()
    {
        $original = [0,3,5];

        $this->collection->shouldReceive('getValues')->once()->andReturn($original);
        $this->assertFalse((new Math())->containsZerosOnly($this->collection));

    }

    public function testContainsZerosOnlyWithZeros()
    {
        $original = [0,0,0];
        $this->collection->shouldReceive('getValues')->once()->andReturn($original);

        $this->assertTrue((new Math())->containsZerosOnly($this->collection));
    }

    public function testAbsMinWithInputValues()
    {
        $original = [-15,90,2];
        $expected = 2;

        $this->collection->shouldReceive('getValues')->once()->andReturn($original);

        $this->assertSame($expected, (new Math())->getAbsMin($this->collection));
    }

    public function testAbsMinWithNoInputValues()
    {
        $original = [];
        $expected = null;

        $this->collection->shouldReceive('getValues')->once()->andReturn($original);

        $this->assertNull($expected, (new Math())->getAbsMin($this->collection));

    }

    public function testAbsMinWithStringInputValues()
    {
        $original = ['string'];
        $expected = null;

        $this->collection->shouldReceive('getValues')->once()->andReturn($original);

        $this->assertNull($expected, (new Math())->getAbsMin($this->collection));

    }

    public function testGCD()
    {
        $original = [15, 45, 35];
        $expected = 5;

        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(true);
        $this->collection->shouldReceive('count')->once()->andReturn(3);
        $this->collection->shouldReceive('getValues')->times(13)->andReturn($original);

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($this->collection)
        );
    }

    public function testGCDWithNonAssociativeArray()
    {
        $original = ['a' => 15, 'b' => 45, 'c' => 35];
        $expected = 5;

        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(true);
        $this->collection->shouldReceive('count')->once()->andReturn(3);
        $this->collection->shouldReceive('getValues')->times(13)->andReturn($original);

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($this->collection)
        );
    }

    public function testGCDWithZero()
    {
        $original = [0, 45];
        $expected = 45;

        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(true);
        $this->collection->shouldReceive('count')->once()->andReturn(2);
        $this->collection->shouldReceive('getValues')->times(3)->andReturn($original);

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($this->collection)
        );
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithZerosOnly()
    {
        $original = [0, 0];

        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(true);
        $this->collection->shouldReceive('count')->once()->andReturn(2);
        $this->collection->shouldReceive('getValues')->once()->andReturn($original);

        (new Math())->greatestCommonDivider($this->collection);
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithEmptyInput()
    {
        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(true);
        $this->collection->shouldReceive('count')->once()->andReturn(0);

        (new Math())->greatestCommonDivider($this->collection);
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithNonIntegerInput()
    {
        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(false);
        $this->collection->shouldReceive('containsOnlyType')->once()->andReturn(false);

        (new Math())->greatestCommonDivider($this->collection);
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithMultiDimensionalInput()
    {
        $this->collection->shouldReceive('isMultiDimensional')->once()->andReturn(true);

        (new Math())->greatestCommonDivider($this->collection);
    }

}