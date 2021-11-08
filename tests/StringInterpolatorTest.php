<?php

namespace Fastwf\Tests;

use PHPUnit\Framework\TestCase;
use Fastwf\Interpolation\StringInterpolator;
use Fastwf\Interpolation\InterpolationException;

class StringInterpolatorTest extends TestCase
{

    /**
     * @covers Fastwf\Interpolation\StringInterpolator
     */
    public function testInterpolate()
    {
        $itpr = new StringInterpolator();

        $template = \file_get_contents(__DIR__.'/template.txt');
        $expected = \file_get_contents(__DIR__.'/expected.txt');

        $this->assertEquals(
            $expected,
            $itpr->interpolate($template, ['value' => 'VALUE'])
        );
    }

    /**
     * @covers Fastwf\Interpolation\StringInterpolator
     * @covers Fastwf\Interpolation\InterpolationException
     */
    public function testStrictInterpolate()
    {
        $this->expectException(InterpolationException::class);

        $itpr = new StringInterpolator(true);

        $template = \file_get_contents(__DIR__.'/template.txt');

        $itpr->interpolate($template, ['value' => 'VALUE']);
    }

}
