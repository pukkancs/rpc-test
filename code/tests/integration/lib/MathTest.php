<?php

namespace Pukkancs\Rpc\Test\Lib;

use PHPUnit\Framework\TestCase;
use Pukkancs\Rpc\Lib\{
    Collection, Math
};

class MathTest extends TestCase
{

    public function testGCD()
    {
        $original = [15, 45, 35];
        $expected = 5;

        $subject = (new Collection($original));

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($subject)
        );
    }

    public function testGCDWithNonAssociativeArray()
    {
        $original = ['a' => 15, 'b' => 45, 'c' => 35];
        $expected = 5;

        $subject = (new Collection($original));

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($subject)
        );
    }

    public function testGCDWithZero()
    {
        $original = [0, 45];
        $expected = 45;

        $subject = (new Collection($original));

        $this->assertSame(
            $expected,
            (new Math())->greatestCommonDivider($subject)
        );
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithZerosOnly()
    {
        $original = [0, 0];

        $subject = (new Collection($original));

        (new Math())->greatestCommonDivider($subject);
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithEmptyInput()
    {
        $original = [];

        $subject = (new Collection($original));

        (new Math())->greatestCommonDivider($subject);
    }

    /** @expectedException \InvalidArgumentException */
    public function testGCDWithMultiDimensionalInput()
    {
        $original = ['a' => 60, 'b' => 18, 'c' => ['d' => 30, 'e' => 24]];

        $subject = (new Collection($original));

        (new Math())->greatestCommonDivider($subject);
    }

}
